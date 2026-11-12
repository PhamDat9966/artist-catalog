<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function index()
    {
        $artists = DB::table('album')
                    ->where('status', 'active')
                    ->orderByDesc('id')
                    ->paginate(10);

        return response()->json($artists);
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
