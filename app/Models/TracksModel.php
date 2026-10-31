<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;

use App\Models\AlbumModel;

// use Kalnoy\Nestedset\NodeTrait;

class TracksModel extends AdminModel
{

    // use NodeTrait;
    protected $table    = 'tracks';
    protected $crudNotActived = ['_token','audio_current'];
    protected $guarded  = [];

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->from('tracks', 'tr')
                          ->select('tr.id','ar.name as artistName','tr.album_id','tr.album_name','tr.name','tr.audio','tr.status','tr.created','tr.created_by','tr.modified','tr.modified_by')
                          ->leftJoin('album as al', 'tr.album_id', '=', 'al.id')
                          ->leftJoin('artist as ar', 'al.artist_id', '=', 'ar.id');

            if($params['filter']['status'] !== "all"){
               $query->where('tr.status','=',$params['filter']['status']);

            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('tr.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('tr.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
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

            // dd($params);
            $albumModel = new AlbumModel();
            $albumName  = $albumModel::where('id', '=', $params['album_id'])->get();
            $albumName  = $albumName->toArray();

            $albumName  = $albumName[0]['name'];

            $audio     = $params['audio'];
            $audioName = Str::slug($audio->getClientOriginalName(),'-','en')
                            . '-' . time() . '.' . $audio->getClientOriginalExtension();
            /*
                audioName là sự kết hợp của:
                -Str::slug():dùng để chuyển đổi một chuỗi văn bản bất kỳ thành một chuỗi "slug" thân thiện với đường dẫn URL (URL-friendly).
                -time(): Thời gian tại thời điểm upload. Chống trùng lặp
                -$audio->getClientOriginalExtension(): đuôi của file audio
            */

            // Disk đã trỏ sẵn vào public/audio/tracks nên path để rỗng
            $audio->storeAs('', $audioName, 'zvn_storage_audio');

            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            /* Save dữ liệu với Nestedset có parent*/
            // Tạo coreParams bằng cách loại bỏ các trường translation
            $coreParams = array_diff_key($params,array_flip($this->crudNotActived));



            /* Save dữ liệu theo eloquent */
            $this->name         = $params['name'];
            $this->album_id     = $params['album_id'];
            $this->album_name   = $albumName;
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->audio        = $audioName;
            $this->save();

        }

        if($options['task'] == 'edit-item'){
            // dd($params);
            if (isset($params['audio']) && $params['audio'] instanceof \Illuminate\Http\UploadedFile) {
                $audio                  = $params['audio'];
                $audioName = Str::slug($audio->getClientOriginalName(),'-','en')
                                        . '-' . time() . '.' . $audio->getClientOriginalExtension();

                // Disk đã trỏ sẵn vào public/audio/tracks nên path để rỗng
                $audio->storeAs('', $audioName, 'zvn_storage_audio');

                // tạo $fileName như trên, storeAs, rồi:
                Storage::disk('zvn_storage_audio')->delete($params['audio_current']);

                $params['audio'] = $audioName;
            }

            $coreParams = array_diff_key($params,array_flip($this->crudNotActived));

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            $query = $current = self::find($params['id']);
            $query->update($this->prepareParams($coreParams));

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $trackDelete    = self::find($params['id']);
            Storage::disk('zvn_storage_audio')->delete($trackDelete->audio); //Xóa audio file ra khỏi public
            $trackDelete->delete(); //Xóa track khỏi table

            // $this->where('id', $params['id'])->delete();

        }
    }

    public function getItem($params = null,$options = null){
        $locale     = app()->getLocale();
        $result   = null;
        if($options['task'] == 'get-item'){
           $result = $this::select('tr.id','al.artist_id','al.artist_name','tr.album_id','tr.album_name','tr.name','tr.audio','tr.status','tr.created','tr.created_by','tr.modified','tr.modified_by')
                    ->from('tracks as tr')
                    ->leftJoin('album as al', 'tr.album_id', '=', 'al.id')
                    ->where('tr.id', $params['id'])
                    ->first();

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
