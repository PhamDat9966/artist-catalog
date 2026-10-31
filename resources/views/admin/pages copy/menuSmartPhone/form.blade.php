@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    //dd($item);

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $status         = (isset($item['status']))? $item->status : '';
    $url            = (isset($item['url']))? $item->url : '';
    $ordering       = (isset($item['ordering']))? $item->ordering : 10;
    $type_menu      = (isset($item['type_menu']))? $item->type_menu : '';
    $type_open      = (isset($item['type_open']))? $item->type_open : '';
    $parent_id      = (isset($item['parent_id']))? $item->parent_id : '';
    $container      = (isset($item['container']))? $item->container : '';
    $note           = (isset($item['note']))? $item->note : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');
    $inputHiddenID     = Form::hidden('id' , $id);

    $statusValue       =    [
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                            ];

    $categoryValue     = $itemsCategory;
    $type_menuArr         = [
                                'link'               => Config::get('zvn.template.type_menu.link.name'),
                                'category_product'   => Config::get('zvn.template.type_menu.category_product.name'),
                                'category_article'   => Config::get('zvn.template.type_menu.category_article.name'),
                            ];

    $type_openArr         = [
                                'current'   => Config::get('zvn.template.type_open.current.name'),
                                '_new'      => Config::get('zvn.template.type_open._new.name'),
                                '_blank'    => Config::get('zvn.template.type_open._blank.name'),
                            ];

    $containerArr         = [
                                'none'      => Config::get('zvn.template.container.none'),
                                'category'  => Config::get('zvn.template.container.category'),
                                'article'   => Config::get('zvn.template.container.article'),
                            ];

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  Form::label('name', 'Name', $formlabelAttr),
            'element'   =>  Form::text('name', $name,   $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('url', 'Url', $formlabelAttr),
            'element'   =>  Form::text('url', $url,   $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('type_menu', 'Type Menu', $formlabelAttr),
            'element'   =>  Form::select('type_menu', $type_menuArr, $type_menu , $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('type_open', 'Type Open', $formlabelAttr),
            'element'   =>  Form::select('type_open', $type_openArr, $type_open , $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  Form::label('parent', 'Parent', $formlabelAttr),
            'element'   =>  Form::select('parent_id', $parentArray, $parent_id , $formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  Form::label('ordering', 'Ordering', $formlabelAttr),
            'element'   =>  Form::number('ordering', $ordering ,$formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  Form::label('status', 'Status', $formlabelAttr),
            'element'   =>  Form::select('status', $statusValue, $status, $formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  Form::label('container', 'Container', $formlabelAttr),
            'element'   =>  Form::select('container', $containerArr, $container, $formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  Form::label('note', 'Note',$formlabelAttr),
            'element'   =>  Form::textarea('note', $note, $formCkeditorAttr)
        ],
        [
            'element'   =>  $inputHiddenID . Form::submit('Save',['class'=>'btn btn-success']),
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
                {!! Form::open([
                        'url'               =>  Route($controllerName.'/save'),
                        'method'            =>  'POST',
                        'accept-charset'    =>  'UTF-8',
                        'enctype'           =>  'multipart/form-data',
                        'class'             =>  'form-horizontal form-label-left',
                        'id'                =>  'main-form'
                    ]) !!}

                    {!! FormTemplate::show($elements)!!}

                {!! Form::close() !!}
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
