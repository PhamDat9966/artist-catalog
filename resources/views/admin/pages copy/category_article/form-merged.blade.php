{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $id             = (isset($item['id']))? $item['id'] : '';
    $status         = (isset($item['status']))? $item->status : '';
    $parent_id      = (isset($item['parent_id']))? $item->parent_id : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID     = html()->hidden('id', $id);

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    //dd($nodes);

    // $submitButton      = '<a href="#" type="button" class="btn btn-success btn-merged-category-article">Save All</a>';
    $submitButton      = html()->button('Save All')->attributes(['class' => 'btn btn-success']);

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('parent_id', 'Parent')->attributes($formlabelAttr),
            'element'   =>  html()->select('parent_id', $nodes, $parent_id)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
        ],
        [
            'element'   =>  $inputHiddenID . $submitButton,
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
                {{-- Thẻ Form::open chính là thẻ form trong html với nhiều thuộc tính hơn, lấy từ đối tượng Collective --}}
                    {!! FormTemplate::show($elements)!!}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

