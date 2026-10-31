<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\AlbumModel as MainModel;
use App\Models\ArtistModel;
use App\Http\Requests\AlbumRequest as MainRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminController;
class AlbumController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.album.';
        $this->controllerName       = 'album';
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
    }

    public function index(Request $request)
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        $artistModel = new ArtistModel();
        $artistList  = $artistModel::pluck('name', 'id');
        $artistList  = $artistList->toArray();
        $data['artistList'] = $artistList;

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData();

        return view($this->pathViewController . 'index', (array)$data);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request
            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';

            if($params['id'] !== null){
                $task = 'edit-item';
                $notify   = 'Cập nhật thành công!';
            }
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function form(Request $request)
    {
        $item   = null;

        $autoIncrement = $this->model->getItem(null,['task'=>'get-auto-increment']);
        $autoIncrement = $autoIncrement[0]->AUTO_INCREMENT;

        if($request->id !== null){
            $this->params['id']   = $request->id;
            $autoIncrement        = $this->params['id'];
            $item = $this->model->getItem($this->params,['task'=>'get-item']);
        }

        $artistModel = new ArtistModel();
        $artistList          = $artistModel::pluck('name', 'id');
        $artistList          = $artistList->toArray();
        $firstArtistElement  = [0 => '-- Chọn nghệ sĩ cho album --'];
        $artistList          = $firstArtistElement + $artistList;

        return view($this->pathViewController . 'form', [
            'item'          =>$item,
            'autoIncrement' =>$autoIncrement,
            'artistList'    =>$artistList
        ]);
    }



}

