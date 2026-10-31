@extends('admin.main')

@php
    use App\Helpers\template as Template;

@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => true])
<!-- zvn_notily -->
@include('admin.templates.zvn_notily')
<!-- /zvn_notily -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Danh sách'])
            <!--List content-->
            @include("admin.pages.setting.list")
            <!--end List-->
        </div>
    </div>
</div>

<!-- /page content -->
@endsection

