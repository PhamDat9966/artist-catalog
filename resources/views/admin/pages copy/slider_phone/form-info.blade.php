@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    // dd($item);
    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $description    = (isset($item['description']))? $item->description : '';
    $link           = (isset($item['link']))? $item->link : '';
    $status         = (isset($item['status']))? $item->status : '';
    $thumb          = (isset($item['thumb']))? $item->thumb : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID      = html()->hidden('id', $id);
    $inputHiddenThumb   = html()->hidden('thumb_current', $thumb);

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];

    $thumbSlider            = '<input class="form-control col-md-6 col-xs-12" name="thumb_slider" type="file" id="thumb_slider">
                                <p style="margin-top: 50px;"></p>
                                <p>
                                    <img id="thumb-slider-preview" src="" alt="" class="zvn-thumb">
                                </p>';
    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra

    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),  // Với html() trong mảng này chính là các thuộc tính như class, id , name của thẻ label
            'element'   =>  html()->text('name', $name)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('description', 'Description')->attributes($formlabelAttr),
            'element'   =>  html()->text('description', $description)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('link', 'Link')->attributes($formlabelAttr),
            'element'   =>  html()->text('link', $link)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        // [
        //     'label'     =>  Form::label('thumb', 'Thumb', $formlabelAttr),
        //     'element'   =>  $thumbSlider
        // ],
        [
            'label'     =>  html()->label('thumb', 'Thumb')->attributes($formlabelAttr),
            'element'   =>  html()->file('thumb')->attributes($formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $thumb , $name) : Template::showItemThumb($controllerName, '' , '')
        ],
        [
            'element'   =>  $inputHiddenID . $inputHiddenThumb . html()->submit('Save')->class('btn btn-success'),
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

