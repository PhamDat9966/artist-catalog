@extends('admin.main')

@php
    use App\Helpers\template as Template;
    //$xhtmlButtonFilter  =   Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'], $params);
    //$xhtmlAreaSearch    =   Template::showAreaSearch($controllerName, $params['search']);
    $urlPhoneSearch     = route($controllerName . '/phoneSearch');
    $xhtmlAreaSearch    =   '<select name="searchPhone" id="searchPhone" class="form-control" style="width: 100%" data-url="'.$urlPhoneSearch.'">
                                <option value="">Tìm kiếm thông tin smart phone...</option>
                            </select>
                            <button id="btn-clear-search" type="button" class="btn btn-success"
                                    style="margin-right: 0px">Xóa tìm kiếm</button>';
@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

@include('admin.templates.zvn_notily')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Bộ lọc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-7">

                    </div>
                    <div class="col-md-5">
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
            @include("admin.pages.productHasMedia.list")
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

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="" id="modal-image" class="img-responsive center-block" alt="Ảnh sản phẩm">
      </div>
    </div>
  </div>
</div>
