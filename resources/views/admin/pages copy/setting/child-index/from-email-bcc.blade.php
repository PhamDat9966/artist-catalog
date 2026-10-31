@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $bcc               = (!empty($item->bcc))? $item->bcc : 'email01@gmail,email02@mail.com';

    $tagsInput = '<input type="text" value="'.$bcc.'" data-role="tagsinput" class="tags" name="bcc">';
    $elements   = [
        [
            'label'     =>  html()->label('bcc','BCC')->attributes($formlabelAttr),
            'element'   =>  $tagsInput
        ],
        [
            'element'   =>  html()->submit('Save')->attributes(['class' => 'btn btn-success']),
            'type'      =>  'btn-submit'
        ]

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
