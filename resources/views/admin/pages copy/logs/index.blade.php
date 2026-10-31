@extends('admin.main')


@section('content')
<!-- page content -->
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Logs</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <iframe src="/log-viewer" width="100%" height="800px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

