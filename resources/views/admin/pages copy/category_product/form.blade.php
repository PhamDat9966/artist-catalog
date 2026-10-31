@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id                     = (isset($item['id']))? $item['id'] : '';
    $name                   = (isset($item['name']))? $item->name : '';
    $slug                   = (isset($item['slug']))? $item->slug : '';
    $status                 = (isset($item['status']))? $item->status : '';
    $isHome                 = (isset($item['is_home']))? $item->is_home : 0;
    $parent_id              = (isset($item['parent_id']))? $item->parent_id : '';
    $isPhoneCategory        = (isset($item['is_phone_category']))? $item->is_phone_category : 0;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID     = html()->hidden('id', $id);


    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    $isHomeValue        = [
                                1    => Config::get('zvn.template.is_home.1.name'),
                                0    => Config::get('zvn.template.is_home.0.name')
                          ];
    $isPhoneCategoryValue  = [
                                1    => Config::get('zvn.template.is_phone_category.1.name'),
                                0    => Config::get('zvn.template.is_phone_category.0.name')
                             ];

    $inputNameCategory = '<input class="form-control col-md-6 col-xs-12"
                                 name="name"
                                 type="text"
                                 value="'.$name.'"
                                 id="category_product"
                                 data-auto-increment="'.$autoIncrement.'"
                         >';

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),
            'element'   =>  $inputNameCategory
        ],
        [
            'label'     =>  html()->label('slug', 'Slug')->attributes($formlabelAttr),
            'element'   =>  html()->text('slug', $slug)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('parent', 'Parent')->attributes($formlabelAttr),
            'element'   =>  html()->select('parent_id', $nodes, $parent_id)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('isHome', 'Is Home')->attributes($formlabelAttr),
            'element'   =>  html()->select('is_home', $isHomeValue, $isHome)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('is_phone_category', 'Is Phone Category')->attributes($formlabelAttr),
            'element'   =>  html()->select('is_phone_category', $isPhoneCategoryValue, $isPhoneCategory)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'element'   =>  $inputHiddenID . html()->submit('Save')->attributes(['class'=>'btn btn-success btn-merged-category']),
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

