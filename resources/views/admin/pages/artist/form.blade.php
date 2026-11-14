@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $status         = (isset($item['status']))? $item->status : '';
    $thumb          = (isset($item['thumb']))? $item->thumb : '';

    $genreList     = $genreList ?? [];       // [id => name], truyền từ controller

    //select multy:
    $selectedGenres = $selectedGenres ?? []; // mảng id đã chọn của ca sĩ này

    //check box:
    $selectedGenres = old('genre_ids', $selectedGenres ?? []);
    $genreCheckboxes = '';
    foreach ($genreList as $gid => $gname) {
        $checked = in_array($gid, (array) $selectedGenres) ? 'checked' : '';

        $genreCheckboxes .= '<label style="margin-right:20px; font-weight:normal; cursor:pointer;">'
                                .'<input type="checkbox" name="genre_ids[]" value="' . e($gid) . '" ' . $checked . '> '
                                . e($gname)
                           .'</label>';
    }

    $formlabelAttr      = config('zvn.template.form_label');
    $formInputAttr      = config('zvn.template.form_input');
    $inputHiddenID      = html()->hidden('id', $id);
    $inputHiddenThumb   = html()->hidden('thumb_current', $thumb);

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];

    $submitButton      = html()->submit('Save')->class('btn btn-success');

    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),
            'element'   =>  html()->text('name', $name)->attributes($formInputAttr)
        ],
        // [
        //     'label'     =>  html()->label('Thể loại', 'genre_ids')->attributes($formlabelAttr),
        //     'element'   =>  html()->select('genre_ids[]', $genreList, $selectedGenres)
        //                         ->multiple()
        //                         ->id('genre_ids')
        //                         ->attributes($formInputAttr)
        // ],
        [
            'label'     =>  html()->label('Thể loại', 'genre_ids')->attributes($formlabelAttr),
            'element'   =>  '<div style="padding:20px;">' . $genreCheckboxes . '</div>'
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('thumb', 'Hình ảnh')->attributes($formlabelAttr),
            'element'   =>  html()->file('thumb')->attributes($formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $thumb , $name) : Template::showItemThumb($controllerName, '' , '')
        ],
        [
            // 'element'   =>  $inputHiddenID . Form::submit('Save',['class'=>'btn btn-success']),
            'element'   =>  $inputHiddenID . $submitButton . $inputHiddenThumb,
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
                {!! FormTemplate::show($elements) !!}
            {!! html()->form()->close() !!}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

<!-- /page content -->
@endsection

