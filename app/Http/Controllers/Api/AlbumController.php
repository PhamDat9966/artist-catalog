<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AlbumRequest as MainRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\AlbumModel as MainModel;

class AlbumController extends AdminController
{
    public function __construct()
    {
        $this->controllerName       = 'album';
        $this->model  = new MainModel();
        parent::__construct();
    }
    public function index(Request $request, $artistID = null)
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

        $this->params['artist_id']           = $artistID;

        // dd($request->all());


        $albums                 = $this->model->listItemsAPI($this->params,['task' => "admin-list-items"]);
        $albumsStatusCount     = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return response()->json([
            'albums'      => $albums,
            'status_count' => $albumsStatusCount,
        ]);
    }

    public function show($id)
    {

        $album = DB::table('album')
                    ->where('id', $id)
                    ->where('status', 'active')
                    ->first();

        if (!$album) {
            return response()->json(['message' => 'Không tìm thấy album'], 404);
        }

        $tracks = DB::table('tracks')
                    ->where('album_id', $album->id)
                    ->where('status', 'active')
                    ->orderByDesc('id')
                    ->get()
                    ->map(fn ($a) => [
                        'id'    => $a->id,
                        'name'  => $a->name,
                        'audio' => $a->audio ? asset('audio/tracks/' . $a->audio) : null,
                    ]);

        return response()->json([
            'data' => [
                'id'    => $album->id,
                'name'  => $album->name,
                'thumb' => $album->thumb ? asset('images/album/' . $album->thumb) : null,
                'tracks'=> $tracks
            ],
        ]);
    }
}
