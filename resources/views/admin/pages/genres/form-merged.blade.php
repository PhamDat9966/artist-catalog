{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $id             = (isset($item['id']))? $item['id'] : '';
    $task           = (isset($item['id']))? '<input name="taskEditInfo" type="hidden" value="taskEditInfo">'
                                            : '<input name="taskAdd" type="hidden" value="taskAdd">';

    $name           = (isset($item['name']))? $item->name : '';
    $status         = (isset($item['status']))? $item->status : '';
    $category       = (isset($item['category_id']))? $item->category_id : '';
    $content        = (isset($item['content']))? $item->content : '';
    $thumb          = (isset($item['thumb']))? $item->thumb : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');
    $inputHiddenID     = html()->hidden('id', $id);
    $inputHiddenThumb  = html()->hidden('thumb_current', $thumb );

    $statusValue       = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    $categoryValue     = $itemsCategory;

    //$submitButton      = Form::submit('Save all',['class'=>'btn btn-success btn-merged-article']);
    //$submitButton      = '<a href="#" type="button" class="btn btn-success btn-merged-article">Save All</a>';
    $submitButton       = html()->button('Save all')->attributes(['type' => 'submit', 'class' => 'btn btn-success btn-merged-article']);

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('status', 'Trạng thái')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('category', 'Phân loại')->attributes($formlabelAttr),
            'element'   =>  html()->select('category_id', $categoryValue, $category)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('thumb', 'Hình ảnh')->attributes($formlabelAttr),
            'element'   =>  html()->file('thumb')->attributes($formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $thumb , $name) : Template::showItemThumb($controllerName, '' , '')
        ],
        [
            'element'   =>  $inputHiddenID . $inputHiddenThumb . $submitButton . $task,
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
                    {!! FormTemplate::show($elements)!!}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

