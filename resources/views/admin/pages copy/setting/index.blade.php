@extends('admin.main')

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

@include('admin.templates.error')

@include('admin.templates.zvn_notily')
@php
    $generalClassActive   = '';
    $emailClassActive     = '';
    $socialClassActive    = '';
    $type = (isset($params['type'])) ? $params['type'] : '';
    switch ($type) {
        case 'general':
            $generalClassActive = 'active';
            break;
        case 'email':
            $emailClassActive = 'active';
            break;
        case 'social':
            $socialClassActive = 'active';
            break;
    }
@endphp

<!--box-lists-->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_content">
            <ul class="nav nav-tabs bar_tabs" role="tablist">
                <li class="nav-item {!!$generalClassActive!!}">
                    <a class="nav-link {!!$generalClassActive!!}" href="{!! route('setting',['type'=>'general']) !!}">Cấu hình chung</a>
                </li>
                <li class="nav-item {!!$emailClassActive!!}">
                    <a class="nav-link {!!$emailClassActive!!}" href="{!! route('setting',['type'=>'email']) !!}">Email</a>
                </li>
                <li class="nav-item {!!$socialClassActive!!}">
                    <a class="nav-link {!!$socialClassActive!!}" href="{!! route('setting',['type'=>'social']) !!}">Social</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" role="tabpanel" aria-labelledby="home-tab">
                    @foreach ($items as $item)
                        @switch($type)
                            @case('general')
                                @include('admin.pages.setting.child-index.from-general',['item'=>$item])
                                @break
                            @case('email')
                                @include('admin.pages.setting.child-index.from-email-account',['item'=>$item])
                                @include('admin.pages.setting.child-index.from-email-bcc',['item'=>$item])
                                @break
                            @case('social')
                                @include('admin.pages.setting.child-index.from-social',['item'=>$item])
                                @break
                            @default
                                @include('admin.pages.setting.child-index.from-general',['item'=>$item])
                                @break
                        @endswitch
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection

