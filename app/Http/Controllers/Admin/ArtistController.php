<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\ArtistModel as MainModel;
use App\Http\Requests\ArtistRequest as MainRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminController;
class ArtistController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.artist.';
        $this->controllerName       = 'artist';
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
            // dd($params);
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

        $nodes = $this->model->listItems($this->params, ['task'=>'admin-list-items-in-select-box']);

        return view($this->pathViewController . 'form', [
            'item'          =>$item,
            'autoIncrement' =>$autoIncrement,
            'nodes'         =>$nodes
        ]);
    }
}

