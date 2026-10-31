<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\TracksModel as MainModel;
use App\Http\Requests\TracksRequest as MainRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminController;
use App\Models\AlbumModel;
class TracksController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.tracks.';
        $this->controllerName       = 'tracks';
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
    }

    public function index(Request $request)
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData();

        return view($this->pathViewController . 'index', (array)$data);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {

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

        $albumModel         = new AlbumModel();
        $albumList          = $albumModel::pluck('name', 'id');
        $albumList          = $albumList->toArray();
        $firstAlbumElement  = [0 => '-- Chọn album cho track --'];

        $albumList      = $firstAlbumElement + $albumList;

        return view($this->pathViewController . 'form', [
            'item'          =>$item,
            'autoIncrement' =>$autoIncrement,
            'albumList'     =>$albumList
        ]);
    }

    public function move(Request $request){
        $this->clearCache();
        $params['type'] = $request->type;
        $params['id']   = $request->id;
        $this->model->move($params, null);
        return redirect()->route($this->controllerName);
    }
}

