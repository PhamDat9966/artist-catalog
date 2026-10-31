@extends('admin.main')

@php
    use App\Helpers\template as Template;
    $playlistYoutube             = ($playlistYoutube)? $playlistYoutube : '';
    $formInput  = '<form method="POST" action="'. Route($controllerName.'/save').'" enctype="multipart/form-data" accept-charset="UTF-8" class="form-horizontal form-label-left" id="main-form">
                        ' . csrf_field() . '
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input  class="form-control col-md-12 col-xs-12"
                                        name="link_play_list_youtube"
                                        type="text"
                                        id="link_play_list_youtube"
                                        value="'.$playlistYoutube.'" required
                                        >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="btn btn-success" task="taskAdd" type="submit" value="Save">
                            </div>
                        </div>
                    </form>';


@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

@include('admin.templates.zvn_notily')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Link playlist Youtube'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        {!!$formInput!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Danh sách'])
            <div class="x_content">
                @if (count($items['items']) > 0)
                    <div class="row">
                        @foreach ($items['items'] as $item )
                        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3">
                            <div class="x_content">
                                <img style="width: 100%" src="{{$item['snippet']['thumbnails']['medium']['url']}}">
                            </div>
                            <div class="text-center">
                                <h6>{{$item['snippet']['title']}}</h6>
                                <a class="btn btn-primary" target="_blank" href="https://www.youtube.com/watch?v={{$item['snippet']['resourceId']['videoId']}}">Xem video</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <h4 class="alert alert-primary text-center">Danh sách rỗng!</h4>
                @endif
            </div>
        </div>
    </div>
</div>
<!--end-box-lists-->
<!-- /page content -->
@endsection

