@extends('admin.main')

@php
    use App\Helpers\template as Template;
    $xhtmlAreaSearch    =   Template::showAreaSearch($controllerName, $params['search']);
    $xhtmlPermission    = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#popupForm">
                                Thêm phân quyền
                            </button>';
@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

@include('admin.templates.zvn_notily')
@include('admin.templates.error')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Bộ lọc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-4">
                        {!! $xhtmlPermission !!}
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-6">
                        {!!$xhtmlAreaSearch!!}
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
            @include("admin.pages.permission.list")
            <!--end List-->
        </div>
    </div>
</div>
<!--end-box-lists-->
<!--box-pagination-->
@if (count($items) > 0)
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Phân trang'])
            @include('admin.templates.pagination')
        </div>
    </div>
</div>
@endif
<!--end-box-pagination-->
<!-- /page content -->
@endsection

@section('popup')
<!-- Modal -->
<div class="modal fade" id="popupForm" tabindex="-1" aria-labelledby="popupFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="popupFormLabel">Thêm Permission</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route($controllerName.'/save')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label text-right pt-3"  style="line-height: 32px;">Chọn controller:</label>
                        <div class="col-sm-9">
                            <select name="controllerSelect" id="controllerSelect" class="form-control" style="width: 100%" >
                                <option value="">-- Chọn Controller --</option>
                                @foreach ($controllerList as $controller)
                                    <option value="{{ $controller }}">{{ $controller }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label text-right pt-3"  style="line-height: 32px;">Chọn hành động:</label>
                        <div class="col-sm-9">
                            <select name="permissionAction" id="permissionAction" class="form-control" style="width: 100%" >
                                <option value="">-- Chọn Permission Action --</option>
                                @foreach ($permissionActions as $keyPerAction=>$permissionAction)
                                    <option value="{{ $keyPerAction }}">{{ $permissionAction }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label text-right pt-3"  style="line-height: 32px;">Guard Name:</label>
                        <div class="col-sm-9">
                            <input type="text" value="web" name="guard_name" readonly class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
