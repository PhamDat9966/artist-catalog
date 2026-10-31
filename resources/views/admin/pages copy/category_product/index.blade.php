@extends('admin.main')

@php
    use App\Helpers\Template as Template;
    // $xhtmlButtonFilter          = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'],$params);
    // $xhtmlAreaSearch            = Template::showAreaSearch($controllerName, $params['search']);
    // $xhtmlItemIsHomeFilter      = Template::showItemIsHomeFilter($controllerName, $params['filter']['is_home']);
    // $xhtmlItemDisplayFilter     = Template::showItemDisplayFilter($controllerName, $params['filter']['display']);
    // $xhtmlCreated               = Template::showCreatedFilter($params['filter']['created']);
    // $xhtmlModified              = Template::showModifiedFilter($params['filter']['modified']);
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
                    <div class="col-md-3">
                        {{-- {!!$xhtmlButtonFilter!!} --}}
                    </div>
                    <div class="col-md-1">
                        {{-- filter is home --}}
                        {{-- {!!$xhtmlItemIsHomeFilter!!} --}}
                    </div>
                    <div class="col-md-1">
                        {{-- filter display --}}
                        {{-- {!!$xhtmlItemDisplayFilter!!} --}}
                    </div>
                    <div class="col-md-2">
                        {{-- {!!$xhtmlCreated!!} --}}
                    </div>
                    <div class="col-md-2">
                        {{-- {!!$xhtmlModified!!} --}}
                    </div>
                    <div class="col-md-3">
                        {{-- {!!$xhtmlAreaSearch!!} --}}
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
            @include("admin.pages.category_product.list")
            <!--end List-->
        </div>
    </div>
</div>
<!--end-box-lists-->
<!--box-pagination-->
@if (count($items) > 0)
@endif
<!--end-box-pagination-->
<!-- /page content -->
@endsection

