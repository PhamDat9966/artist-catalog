@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $facebook          = (isset($item->facebook))? $item->facebook : 'https://www.facebook.com/zendvngroup12345';
    $youtube           = (isset($item->youtube))? $item->youtube : 'https://www.youtube.com/@luutruonghailan_zendvn12345';
    $google            = (isset($item->google))? $item->google : 'https://www.youtube.com/user/zendvn12345';

    $facebookTagsInput = '<input type="text" value="'.$facebook.'" data-role="tagsinput" class="tags" name="facebook">';
    $youtubeTagsInput  = '<input type="text" value="'.$youtube.'" data-role="tagsinput" class="tags" name="youtube">';
    $googleTagsInput   = '<input type="text" value="'.$google.'" data-role="tagsinput" class="tags" name="google">';


    $elements   = [
        [
            'label'     =>  html()->label('facebook','Facebook')->attributes($formlabelAttr),
            'element'   =>  $facebookTagsInput
        ],
        [
            'label'     =>  html()->label('youtube','Youtube')->attributes($formlabelAttr),
            'element'   =>  $youtubeTagsInput
        ],
        [
            'label'     =>  html()->label('google','Google')->attributes($formlabelAttr),
            'element'   =>  $googleTagsInput
        ],
        [
            'element'   =>  html()->submit('Save')->attributes(['class' => 'btn btn-success']),
            'type'      =>  'btn-submit'
        ],


    ];

@endphp
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="tab-pane fade show active in" id="bcc" role="tabpanel" aria-labelledby="home-tab">
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
            </div>
        </div>
    </div>
</div>

