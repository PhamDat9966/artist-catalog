<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;     // Eloquent thao tác trên csdl
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location

class AdminModel extends Model
{
    protected $table = '';
    //protected $primaryKey = 'id'; //$primaryKey mặc định là id nên ở đây không cần khai báo

    protected $folderUpload = '';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fieldSearchAccepted = [
        'id',
        'name'
    ] ;

    protected $crudNotActived = [
        '_token',
        'thumb_current'
    ];

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','description','status','link','thumb')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        return $result;
    }

    public function uploadThumb($thumbObj){
        $thumbName       = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName ,'zvn_storage_image');
        return $thumbName;
    }

    public function uploadTempDropzoneThumb($thumbObj){
        $thumbName       = 'temp_' . Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName ,'zvn_storage_image');
        return $thumbName;
    }

    public function deleteThumb($thumbName){
        Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function prepareParams($params){
        return array_diff_key($params,array_flip($this->crudNotActived));
    }

    public function uploadThumbArtist($thumbObj){
        $thumbName       = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName ,'zvn_storage_image_artist');
        return $thumbName;
    }
    public function deleteThumbArtist($thumbName){
        Storage::disk('zvn_storage_image_artist')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function uploadThumbAlbum($thumbObj){
        $thumbName       = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName ,'zvn_storage_image_album');
        return $thumbName;
    }
    public function deleteThumbAlbum($thumbName){
        Storage::disk('zvn_storage_image_album')->delete($this->folderUpload . '/' . $thumbName);
    }

}
