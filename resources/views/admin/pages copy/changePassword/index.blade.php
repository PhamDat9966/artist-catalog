@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $id                = (isset($params['id']))? $params['id'] : '';
    $inputHiddenID     = html()->hidden('id' , $id);

    $elements   = [
        [
            'label'     =>  html()->label('passwordCurrent', 'Mật khẩu hiện tại')->attributes($formlabelAttr),
            'element'   =>  html()->password('passwordCurrent')->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('passwordNew', 'Mật khẩu mới')->attributes($formlabelAttr),
            'element'   =>  html()->password('password')->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('passwordNew', 'Xác nhận mật khẩu mới')->attributes($formlabelAttr),
            'element'   =>  html()->password('password_confirmation')->attributes($formInputAttr)
        ],
        [
            'element'   =>  $inputHiddenID . html()->submit('Save')->class('btn btn-success'),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])
@include('admin.templates.zvn_notily')
@include('admin.templates.error')

<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title',['title'=>'Form'])
            <!-- x Content -->
            <div class="x_content" style="display: block;">
                {{-- Thẻ Form::open chính là thẻ form trong html với nhiều thuộc tính hơn, lấy từ đối tượng Collective --}}
                {{ html()->form('POST', route($controllerName.'/save'))
                    ->attribute('accept-charset', 'UTF-8')
                    ->attribute('enctype', 'multipart/form-data')
                    ->class('form-horizontal form-label-left')
                    ->id('main-form')
                    ->open() }}

                    {!! FormTemplate::show($elements)!!}

                {{ html()->form()->close() }}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

<!-- /page content -->
@endsection

{{-- <script>
    CKEDITOR.replace('content');
</script> --}}
