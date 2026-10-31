{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $link           = (isset($item['link']))? $item->link : '';
    $status         = (isset($item['status']))? $item->status : '';
    $thumb          = (isset($item['thumb']))? $item->thumb : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    // $inputHiddenID      = Form::hidden('id' , $id);
    // $inputHiddenThumb   = Form::hidden('thumb_current', $thumb );

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

    //$submitButton      = Form::submit('Save all',['class'=>'btn btn-success btn-merged-article']);
    $submitButton      = html()->submit('Save all')->class('btn btn-success btn-merged-article');


    $elements   = [
        [
            'label'     =>  html()->label('link', 'Link')->attributes($formlabelAttr),
            'element'   =>  html()->text('link', $link)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('thumb', 'Thumb')->attributes($formlabelAttr),
            'element'   =>  html()->file('thumb')->attributes($formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $thumb , $name) : Template::showItemThumb($controllerName, '' , '')
        ],
        [
            'element'   =>  $inputHiddenID . $inputHiddenThumb . $submitButton,
            'type'      =>  'btn-submit'
        ]
    ];

@endphp

<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <!-- x Content -->
            <div class="x_content" style="display: block;">

                    {!! FormTemplate::show($elements) !!}

            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

