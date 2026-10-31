@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $cost           = (isset($item['cost']))? $item->cost : '';
    $status         = (isset($item['status']))? $item->status : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    $levelValue        = [
                                'default'    => 'Select level',
                                'admin'      => Config::get('zvn.template.level.admin.name'),
                                'member'     => Config::get('zvn.template.level.member.name')
                        ];
    $submitButton      = '<input name="id" type="hidden" value="'.$id.'">
                          <input class="btn btn-success" name="taskEditInfo" type="submit" value="Save">';
    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),  // Với html() trong mảng này chính là các thuộc tính như class, id , name của thẻ label
            'element'   =>  html()->text('name', $name)->attributes($formInputAttr)  // Với html() trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('cost', 'Phí vận chuyển')->attributes($formlabelAttr),
            'element'   =>  html()->number('cost', $cost)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     => html()->label('level', 'Level')->attributes($formlabelAttr),
            'element'   => $submitButton
        ]

    ];

@endphp

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
