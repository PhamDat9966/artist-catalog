@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    // dd($artistList);
    $id             = (isset($item['id']))? $item['id'] : '';
    $album_id       = (isset($item['album_id']))? $item['album_id'] : '';
    $album_name     = (isset($item['album_name']))? $item['album_name'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $audio          = (isset($item['audio']))? $item->audio : '';
    $status         = (isset($item['status']))? $item->status : '';
    $created        = (isset($item['created']))? $item->created : '';
    $created_by     = (isset($item['created_by']))? $item->created_by : '';
    $modified       = (isset($item['modified']))? $item->modified : '';
    $modified_by    = (isset($item['modified_by']))? $item->modified_by : '';


    $formlabelAttr     = config('zvn.template.form_label');
    $formInputAttr     = config('zvn.template.form_input');
    // $inputHiddenID      = Form::hidden('id' , $id);
    $inputHiddenID      = html()->hidden('id', $id);
    $inputHiddenAudio   = html()->hidden('audio_current', $audio);

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
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('album', 'Album')->attributes($formlabelAttr),
            'element'   =>  html()->select('album_id', $albumList, $album_id)->attributes($formInputAttr)
            //tại select, mảng đầu vào là $artistList với danh sách nghệ sĩ, tại $artist_id đây chính giá trị default
        ],
        [
            'label'   => html()->label('Track nhạc', 'audio')->attributes($formlabelAttr),
            'element' => html()->file('audio')
                            ->attributes($formInputAttr)
                            ->attribute('accept', 'audio/*')
                        . '<audio id="audio-preview" controls style="display:none; margin-top:8px;"></audio>' // Chỗ này để audio mới được tải lên hiện lên
                        . '<div id="audio-current">' . Template::showItemAudio($controllerName, $audio) . '</div>' // Chỗ này để audio sẵn có hiện lên và ẩn đi (nếu trường hợp upload file audio mới)
        ],
        [
            // 'element'   =>  $inputHiddenID . Form::submit('Save',['class'=>'btn btn-success']),
            'element'   =>  $inputHiddenID . $submitButton . $inputHiddenAudio,
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

