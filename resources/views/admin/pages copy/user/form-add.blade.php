@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    $roleValue        = [
                            'default'   => 'Select Role'
                        ];

    foreach($roleList as $role){
        $roleValue[$role['id']] = Config::get('zvn.template.role.'.$role['name'].'.name');
    }
    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('username', 'Username')->attributes($formlabelAttr),
            'element'   =>  html()->text('username', null)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('fullname', 'Fullname')->attributes($formlabelAttr),
            'element'   =>  html()->text('fullname', null)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('email', 'Email')->attributes($formlabelAttr),
            'element'   =>  html()->text('email', null)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('password', 'Password')->attributes($formlabelAttr),
            'element'   =>  html()->password('password')->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('password_confirmation', 'Password Confirmation')->attributes($formlabelAttr),
            'element'   =>  html()->password('password_confirmation')->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('role', 'Role')->attributes($formlabelAttr),
            'element'   =>  html()->select('roles_id', $roleValue, 'default')->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue , 'default' )->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('avatar', 'Avatar')->attributes($formlabelAttr),
            'element'   =>  html()->file('avatar')->attributes($formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $avatar , $username) : ''
        ],
        [
            'element'   =>  html()->submit('Save')->attributes(['class' => 'btn btn-success', 'task' => 'taskAdd']),
            'type'      =>  'btn-submit'
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
                {!! html()->form()->close() !!}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>

<!-- /page content -->
