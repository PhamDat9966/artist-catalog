@extends('admin.main')

@php
    use App\Helpers\template as Template;
    // $xhtmlButtonFilter  =   Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'], $params);
    // $xhtmlAreaSearch    =   Template::showAreaSearch($controllerName, $params['search']);
@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => true])

@include('admin.templates.zvn_notily')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Bộ lọc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6">
                        {{-- {!!$xhtmlButtonFilter!!} --}}
                    </div>
                    <div class="col-md-6">
                        {{-- {!!$xhtmlAreaSearch!!} --}}
                        {{-- <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button"
                                        class="btn btn-default dropdown-toggle btn-active-field"
                                        data-toggle="dropdown" aria-expanded="false">
                                    Search by All <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="#"
                                            class="select-field" data-field="all">Search by All</a></li>
                                    <li><a href="#"
                                            class="select-field" data-field="id">Search by ID</a></li>
                                    <li><a href="#"
                                            class="select-field" data-field="username">Search by Username</a>
                                    </li>
                                    <li><a href="#"
                                            class="select-field" data-field="fullname">Search by Fullname</a>
                                    </li>
                                    <li><a href="#"
                                            class="select-field" data-field="email">Search by Email</a></li>
                                </ul>
                            </div>
                            <input type="text" class="form-control" name="search_value" value="">
                            <span class="input-group-btn">
                        <button id="btn-clear" type="button" class="btn btn-success"
                                style="margin-right: 0px">Xóa tìm kiếm</button>
                        <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                        </span>
                            <input type="hidden" name="search_field" value="all">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Danh sách'])
            <!--List content-->
            @include("admin.pages.system.list")
            <!--end List-->
        </div>
    </div>
</div>
<!--end-box-lists-->
<!-- /page content -->
@endsection

