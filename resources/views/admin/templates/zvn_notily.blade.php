{{-- @php
    dd(session('zvn_notily'));
@endphp --}}
@if (session('zvn_notily'))
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-info alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>{{session('zvn_notily')}}</strong>
            </div>
        </div>
    </div>
@endif
