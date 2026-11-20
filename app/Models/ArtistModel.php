<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use App\Models\AlbumModel;
use App\Models\TracksModel;
use App\Models\GenresModel;

// use Kalnoy\Nestedset\NodeTrait;

class ArtistModel extends AdminModel
{

    // use NodeTrait;
    protected $table    = 'artist';
    protected $crudNotActived = ['_token','thumb_current']; // 'thumb_current' ở đây nếu có tồn tại ảnh có sẵn thì không cần update
    protected $guarded  = [];

    public function genres()
    {
        return $this->belongsToMany(GenresModel::class, 'artist_genre', 'artist_id', 'genre_id')
                    ->withPivot('artist_name', 'genre_name');
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->from('artist', 'a')
                          ->select('a.id','a.name','a.thumb','a.status','a.created','a.created_by','a.modified','a.modified_by')
                          ->with('genres');

            if(isset($params['filter']['status'])){
                if($params['filter']['status'] !== "all"){
                $query->where('a.status','=',$params['filter']['status']);

                }
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('a.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('a.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');


                            if($params['filter']['date'] !== null){
                                $query->where("created","like","%".$params['filter']['date']."%");
                            }

                            if($params['filter']['created'] !== null){
                                $query->where("created","like","%".$params['filter']['created']."%");
                            }

                            if($params['filter']['modified'] !== null){
                                $query->where("modified","like","%".$params['filter']['modified']."%");
                            }

                            if($params['search'] !== ""){

                                if($params["search"]["field"] == "all"){

                                    $query->where(function ($query) use ($params){
                                        foreach ($this->fieldSearchAccepted as $column) {
                                            {
                                                $query->orWhere($column,"like","%".$params["search"]["value"]."%");
                                            }
                                        }
                                    }
                                );

                                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                                    $query->where($params["search"]["field"],"like","%".$params["search"]["value"]."%");
                                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                                }
                            }

            $result     = $query->get()
                                ->toArray();
        }

        return $result;
    }

    public function saveItem($params = null,$options = null){
        if (Session::has('userInfo')) {
            $userInfo = Session::get('userInfo');
        } else {
            $userInfo = ['username'=>'admin'];
        }

        $params['modified_by']   = $userInfo['username'];
        $params['modified']      = date('Y-m-d');

        if($options['task'] == 'change-status'){
            $status  = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            $this::where('id', $params['id'])
                        ->update(['status' => $status, 'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-display'){
            $this::where('id', $params['id'])
                        ->update(['display' => $params['display'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-is-home'){
            $this::where('id', $params['id'])
                        ->update(['is_home' => $params['currentIsHome'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-ordering'){
            $this::where('id', $params['id'])
                        ->update(['ordering' => $params['ordering'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);

        }

        if($options['task'] == 'add-item'){

            $thumb                  = $params['thumb'];
            $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image_artist');

            /* Save dữ liệu theo eloquent */
            /*
                Sau save(), Eloquent gán id vừa được cấp vào $this->id. Nếu gọi sync() trước save()
                thì $this->id là null và không có artist_id để ghi. Bạn đã đặt đúng thứ tự.
                Ở edit-item, model cha là kết quả của self::find($coreParams['id']), nên id có sẵn từ lúc truy vấn.
            */

            $this->name         = $params['name'];
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->thumb        = $params['thumb'];
            $this->save();

            /* Lưu thể loại */
            // $this->genres()->sync($params['genre_ids'] ?? []);

            /* Lưu thể loại với hàm $this->genres(), laravel đã “biết” đó là ca sĩ nào*/
            $this->genres()->sync($this->buildGenrePivot($params['genre_ids'] ?? [], $params['name']));
        }

        if($options['task'] == 'edit-item'){

            // Tách genre_ids ra, không để lọt vào câu UPDATE của bảng artist
            $genreIds = $params['genre_ids'] ?? [];
            unset($params['genre_ids']);

            if(!empty($params["thumb"])){

                /*Xóa ảnh cũ*/
                $item   =  $this->getItem($params,['task' => 'get-thumb']);
                //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $params['thumb_current']);
                $this->deleteThumbArtist($params['thumb_current']);
                /* Thêm ảnh mới */
                // $thumb                  = $params['thumb'];
                // $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
                // $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image');
                $params['thumb']        = $this->uploadThumbArtist($params['thumb']);
                /* end Thêm ảnh mới */
            }

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $coreParams   = $this->prepareParams($params);
            self::where('id', $coreParams['id'])->update($coreParams);

            /* Lưu thể loại */
                // self::find($coreParams['id'])->genres()->sync($genreIds);
            /* Lưu thể loại với hàm $this->genres(), laravel đã “biết” đó là ca sĩ nào*/
            self::find($coreParams['id'])->genres()->sync(
                $this->buildGenrePivot($genreIds, $params['name'])
            );

        }

    }
    /*
        sync() làm gì bên trong

        sync() nhận danh sách thể loại mới và làm cho bảng artist_genre của ca sĩ này khớp với danh sách đó, theo 3 bước:

        1. Đọc hiện trạng: SELECT genre_id FROM artist_genre WHERE artist_id = {id của $this}.
        2. So sánh với danh sách mới (là các khóa của mảng bạn truyền vào).
        3. Thực hiện chênh lệch:
            Thể loại có trong DB nhưng không có trong danh sách mới → xóa (detach).
            Thể loại có trong danh sách mới nhưng chưa có trong DB → thêm (attach), kèm các cột phụ.
            Thể loại đã có ở cả hai → giữ lại, và chỉ UPDATE nếu các cột phụ (artist_name, genre_name) khác đi.

        Ví dụ với Duy Khánh (id = 10), đang có thể loại [1, 2, 5], bạn bỏ chọn 1 và thêm 4, tức danh sách mới là [2, 4, 5]:

        genre_id	Hành động
        1	xóa dòng (10, 1)
        2, 5	giữ lại (cập nhật tên nếu khác)
        4	thêm dòng (10, 4, 'Duy Khánh', 'Rap/Hip-hop')
     */

    /**
     * Chuyển [1, 2, 5] thành:
     * [1 => ['artist_name' => '...', 'genre_name' => 'Nhạc vàng'], 2 => [...], ...]
     * để sử dung Pivot, bổ xung thêm, tên artis và tên thể loại vào bản artist_genre
     */
    public function buildGenrePivot($genreIds, $artistName)
    {
        $genreIds = array_filter((array) $genreIds);
        if (empty($genreIds)) return [];

        // Lấy tên các thể loại bằng 1 truy vấn: [id => name]
        $genreNames = GenresModel::whereIn('id', $genreIds)->pluck('name', 'id');

        $data = [];
        foreach ($genreIds as $genreId) {
            if (!isset($genreNames[$genreId])) continue;   // bỏ qua id không tồn tại
            $data[$genreId] = [
                'artist_name' => $artistName,
                'genre_name'  => $genreNames[$genreId],
            ];
        }
        dd($data);
        return $data;
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $albumModel     = new AlbumModel();
            $tracksModel    = new TracksModel();
            //Xóa ảnh của nghệ sĩ:
            $artistDelete   = self::find($params['id']);
            $artistCurrent  = $artistDelete->toArray();

            $this->deleteThumbArtist($artistCurrent['thumb']);

            //Truy vấn tất cả các album của Ca sĩ:
            $albums       = $albumModel->where('artist_id', $params['id'])->get()->toArray();

            if (!empty($albums) && is_array($albums)) {
                foreach($albums as $album){

                    //Xóa tất cả ảnh của album:
                    $this->deleteThumbAlbum($album['thumb']);

                    //Duyệt các track nhạc của album:
                    $tracks = $tracksModel->where('album_id', $album['id'])->get()->toArray();

                    //Xóa tất cả các track nhạc thuộc album:
                    foreach($tracks as $track){
                        $audioNameDelete = $track['audio'];
                        Storage::disk('zvn_storage_audio')->delete($audioNameDelete); //Xóa audio file ra khỏi public
                    }



                }
            }

            $artistDelete->delete();

        }
    }

    public function getItem($params = null,$options = null){
        $locale     = app()->getLocale();
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this->where('id', $params['id'])
                            ->where('status', 'active')
                            ->with('genres')
                            ->first();

        }

        if($options['task'] == 'get-item-active'){   // dùng cho frontend
            $result = $this->where('id', $params['id'])
                        ->where('status', 'active')
                        ->with('genres')
                        ->first();
        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'get-auto-increment'){
            $dataBaseName         = DB::connection()->getDatabaseName();
            $result = DB::select("SELECT AUTO_INCREMENT
                                  FROM INFORMATION_SCHEMA.TABLES
                                  WHERE TABLE_SCHEMA = '".$dataBaseName."'
                                  AND TABLE_NAME = '".$this->table."'");
        }

        return $result;
    }

}
