<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArtistRequest as MainRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\ArtistModel as MainModel;

class ArtistController extends AdminController
{
    public function __construct()
    {
        $this->controllerName       = 'artist';
        $this->model  = new MainModel();
        parent::__construct();
    }
    public function index(Request $request)
    {
        $this->params['filter']['status']   = $request->input('filter_status','all'); // $request->input() là do laravel định nghĩa, tương đương với $_GET
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        //Params date
        $this->params['filter']['created']   = $request->input('filter_created');
        $this->params['filter']['modified']  = $request->input('filter_modified');
        $this->params['filter']['date']      = $request->input('filter_date');

        //pagination:
        $this->params['offset']              = $request->input('offset',0);
        $this->params['limit']               = $request->input('limit',4);

        // dd($request->all());

        // $artists = DB::table('artist')
        //             ->where('status', 'active')
        //             ->orderByDesc('id')
        //             ->paginate(10);

        $artists                = $this->model->listItemsAPI($this->params,['task' => "admin-list-items"]);
        // dd($artists->toArray());
        $artistsStatusCount     = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return response()->json([
            'artists'      => $artists,
            'status_count' => $artistsStatusCount,
        ]);
    }

    public function show($id)
    {
        $this->params['id'] = $id;
        $artist             = $this->model->getItem($this->params,['task' => "get-item-active"]);

        /*
            Đùng lệnh dd ở backend để gây lỗi chủ động, để frondend hiện url của backend->chạy url đó để trực tiếp
            debug API controller của backend
         */
        // dd($artist->toArray());

        if (!$artist) {
            return response()->json(['message' => 'Không tìm thấy ca sĩ'], 404);
        }

        $albums = DB::table('album')
                    ->where('artist_id', $artist->id)
                    ->where('status', 'active')
                    ->orderByDesc('id')
                    ->get()
                    ->map(fn ($a) => [
                        'id'    => $a->id,
                        'name'  => $a->name,
                        'thumb' => $a->thumb ? asset('images/album/' . $a->thumb) : null,
                    ]);

        return response()->json([
            'data' => [
                'id'    => $artist->id,
                'name'  => $artist->name,
                'thumb' => $artist->thumb ? asset('images/artist/' . $artist->thumb) : null,
                'genres'=> $artist->genres,
                'albums'=> $albums
            ],
        ]);
    }
}
