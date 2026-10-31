@extends('admin.main')

@php

    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $status         = (isset($item['status']))? $item->status : '';
    $fieldClass     = (isset($item['fieldClass']))? $item->fieldClass : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID     = html()->hidden('id', $id);

    $statusValue        = [
                            'default'    => Config::get('zvn.template.status.all.name'),
                            'active'     => Config::get('zvn.template.status.active.name'),
                            'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];


    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),  // Với html() trong mảng này chính là các thuộc tính như class, id , name của thẻ label
            'element'   =>  html()->text('name', $name)->attributes($formInputAttr)  // Với html() trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('fieldClass', 'FieldClass')->attributes($formlabelAttr),
            'element'   =>  html()->text('fieldClass', $fieldClass)->attributes($formInputAttr)
        ],
        [
            'element'   =>  $inputHiddenID . html()->submit('Save')->attributes(['class' => 'btn btn-success']),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

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

