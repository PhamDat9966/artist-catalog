<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\DashboardModel as MainModel;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Contracts\Session\Session;

class DashboardController extends Controller
{
    private $pathViewController  = 'admin.pages.dashboard.';
    private $controllerName      = 'dashboard';
    protected $model;
    protected $params             = array();

    public function __construct()
    {
        $this->params['artist'] = 'artist';
        $this->params['album']  = 'album';
        $this->params['tracks']   = 'tracks';

        // $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
    }

    public function index()
    {

        return view($this->pathViewController . 'index',[
        ]);
    }

}
