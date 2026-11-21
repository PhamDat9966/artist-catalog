<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use App\Models\ArtistModel;
use App\Models\TracksModel;

// use Kalnoy\Nestedset\NodeTrait;

class AlbumModel extends AdminModel
{

    // use NodeTrait;
    protected $table    = 'album';
    protected $crudNotActived = ['_token','thumb_current']; // 'thumb_current' ở đây nếu có tồn tại ảnh có sẵn thì không cần update
    protected $guarded  = [];

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->from('album', 'a')
                          ->select('a.id','a.artist_id','a.artist_name','a.name','a.thumb','a.status','a.created','a.created_by','a.modified','a.modified_by');

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

        if($options['task'] == 'add-item'){

            // dd($params);
            $artistModel = new ArtistModel();
            $artistName  = $artistModel::where('id', '=', $params['artist_id'])->get();
            $artistName  = $artistName->toArray();

            $artistName  = $artistName[0]['name'];

            $thumb                  = $params['thumb'];
            $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image_album');

            /* Save dữ liệu theo eloquent */
            $this->name         = $params['name'];
            $this->artist_id    = $params['artist_id'];
            $this->artist_name  = $artistName;
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
                $this->deleteThumbAlbum($params['thumb_current']);
                /* Thêm ảnh mới */
                // $thumb                  = $params['thumb'];
                // $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
                // $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image');
                $params['thumb']        = $this->uploadThumbAlbum($params['thumb']);
                /* end Thêm ảnh mới */
            }

            // dd($params);

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            $artistModel = new ArtistModel();
            $artistName  = $artistModel::where('id', '=', $params['artist_id'])->get();
            $artistName  = $artistName->toArray();
            $artistName  = $artistName[0]['name'];

            $params['artist_name'] = $artistName;

            $coreParams   = $this->prepareParams($params);
            self::where('id', $coreParams['id'])->update($coreParams);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $albumDelete    = self::find($params['id']);
            //Xóa ảnh của album:
            $this->deleteThumbAlbum($albumDelete->thumb);

            $tracksModel    = new TracksModel();
            $tracks = $tracksModel->where('album_id', $params['id'])->get()->toArray();
            // dd($tracks);

            //Xóa tất cả các file audio của album:
            if (!empty($tracks) && is_array($tracks)) {
                foreach($tracks as $key=>$track){
                    $audioNameDelete = $track['audio'];
                    Storage::disk('zvn_storage_audio')->delete($audioNameDelete); //Xóa audio file ra khỏi public
                }
            }

            $albumDelete->delete(); //Xóa track khỏi table
        }
    }

    public function getItem($params = null,$options = null){
        $locale     = app()->getLocale();
        $result   = null;
        if($options['task'] == 'get-item'){
           $result = $this::select('al.id','al.artist_id','al.artist_name','al.name','al.thumb','al.status','al.created','al.created_by','al.modified','al.modified_by')
                    ->from('album as al')
                    ->leftJoin('artist as ar', 'al.artist_id', '=', 'ar.id')
                    ->where('al.id', $params['id'])
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
