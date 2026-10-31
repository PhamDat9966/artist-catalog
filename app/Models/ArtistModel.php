<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use App\Models\AlbumModel;
use App\Models\TracksModel;

// use Kalnoy\Nestedset\NodeTrait;

class ArtistModel extends AdminModel
{

    // use NodeTrait;
    protected $table    = 'artist';
    protected $crudNotActived = ['_token','thumb_current']; // 'thumb_current' ở đây nếu có tồn tại ảnh có sẵn thì không cần update
    protected $guarded  = [];

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->from('artist', 'a')
                          ->select('a.id','a.name','a.thumb','a.status','a.created','a.created_by','a.modified','a.modified_by');

            if($params['filter']['status'] !== "all"){
               $query->where('a.status','=',$params['filter']['status']);

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
            $this->name         = $params['name'];
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->thumb        = $params['thumb'];
            $this->save();

        }

        if($options['task'] == 'edit-item'){

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

        }

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

    // public function deleteItem($params = null, $options = null)
    // {
    //     if ($options['task'] == 'delete-item') {

    //         $artist = self::find($params['id']);
    //         if (!$artist) return;

    //         // 1. Thu thập tên file trước khi xóa DB
    //         $albums      = DB::table('album')->where('artist_id', $artist->id)->get(['id', 'thumb']);
    //         $albumThumbs = $albums->pluck('thumb')->filter()->all();
    //         $audioFiles  = DB::table('tracks')
    //                             ->whereIn('album_id', $albums->pluck('id'))
    //                             ->pluck('audio')->filter()->all();
    //         $artistThumb = $artist->thumb;

    //         // 2. Xóa dữ liệu (album và tracks tự xóa theo nhờ CASCADE)
    //         DB::transaction(function () use ($artist) {
    //             $artist->delete();
    //         });

    //         // 3. DB đã xóa thành công thì mới xóa file
    //         if ($artistThumb) $this->deleteThumbArtist($artistThumb);

    //         foreach ($albumThumbs as $thumb) {
    //             $this->deleteThumbAlbum($thumb);
    //         }

    //         foreach ($audioFiles as $audio) {
    //             Storage::disk('zvn_storage_audio')->delete($audio);
    //         }
    //     }
    // }

    public function getItem($params = null,$options = null){
        $locale     = app()->getLocale();
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','thumb','status')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'news-get-item'){
            $result = $this::select('ca.id','cat.name','ca.display')
                    ->from('category_article as ca')
                    ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'ca.id')
                    ->where('ca.id', $params['category_id'])
                    ->where('cat.locale',$locale)
                    ->first();
                    if($result != null) $result->toArray();
        }

        if($options['task'] == 'news-get-all-items-in-category'){
            $result = $this::select('ca.id','cat.name','ca.display')
                    ->from('category_article as ca')
                    ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'ca.id')
                    ->where('ca.id', $params['category_id'])
                    ->where('cat.locale',$locale)
                    ->get();
                    if($result != null) $result->toArray();
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

    public function move($params = null,$options = null){
        $node       = self::find($params['id']);
        $historyBy  = session('userInfo')['username'];
        $this->where('id',$params['id'])->update(['modified_by' => $historyBy]);
        if($params['type'] == 'down') $node->down();
        if($params['type'] == 'up')   $node->up();
    }
}
