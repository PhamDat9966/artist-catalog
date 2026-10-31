@extends('admin.main')

@section('content')
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Doashboard</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Doashboard</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="top_tiles">
                        @foreach ($items as $key => $val)
                            @php
                                $nameTable      = $val['TableName'];
                                $elementCount   = $val['ElementCount'];
                                $icon           = $val['icon'];
                                // Tách chuỗi theo dấu '_', sau đó chuyển ký tự đầu của từng từ thành chữ in hoa (trừ từ đầu tiên)
                                $strArray   = explode('_', $nameTable);
                                $routerTable = array_shift($strArray) . implode('', array_map('ucfirst', $strArray));

                                $link           = route($routerTable);
                            @endphp

                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
                                <div class="tile-stats">
                                    <div class="icon">{!!$icon!!}</div>
                                    <div class="count">{{$elementCount}}</div>
                                    <h3>Tổng số {{$nameTable}}</h3>
                                    <p>
                                        <a href="{{$link}}">Xem chi tiết.</a>
                                    </p>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>
                @php
                    $linkUpdate = route('dashboard/updateDoashboard');
                @endphp

                <div class="row">
                    <div class="zvn-add-new pull-right">
                        <a href="{{$linkUpdate}}" class="btn btn-secondary">Cập nhật lại số liệu nếu có lỗi</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
