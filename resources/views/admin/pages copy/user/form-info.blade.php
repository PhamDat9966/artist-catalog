@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $id             = (isset($item['id']))? $item['id'] : '';
    $username       = (isset($item['username']))? $item->username : '';
    $fullname       = (isset($item['fullname']))? $item->fullname : '';
    $email          = (isset($item['email']))? $item->email : '';
    $roles_id       = (isset($item['roles_id']))? $item->roles_id : '';
    $status         = (isset($item['status']))? $item->status : '';
    $avatar         = (isset($item['avatar']))? $item->avatar : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $inputHiddenID     = html()->hidden('id', $id);
    $inputHiddenThumb  = html()->hidden('avatar_current', $avatar );

    $statusValue        = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];
    $primeID        = Config::get('zvn.config.lock.prime_id');
    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    // $elements   = [
    //     [
    //         'label'     =>  Form::label('username', 'Username', $formlabelAttr),
    //         'element'   =>  Form::text('username', $username,   $formInputAttr)  // Với collective trong mảng này chính là các thuộc..
    //                                                                                                 // ..tính như class, id , name của thẻ input
    //     ],
    //     [
    //         'label'     =>  Form::label('fullname', 'Fullname',$formlabelAttr),
    //         'element'   =>  Form::text('fullname', $fullname ,  $formInputAttr)
    //     ],
    //     [
    //         'label'     =>  Form::label('email', 'Email',$formlabelAttr),
    //         'element'   =>  Form::text('email', $email , $formInputAttr)
    //     ],
    //     [
    //         'label'     =>  Form::label('status', 'Status', $formlabelAttr),
    //         'element'   => ($roles_id != $primeID) ? Form::select('status', $statusValue, $status, $formInputAttr) : '<label class="control-label" style="color:blue">Locked</label>'
    //         //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
    //     ],
    //     [
    //         'label'     =>  Form::label('avatar', 'Avatar', $formlabelAttr),
    //         'element'   =>  Form::file('avatar',  $formInputAttr),
    //         'type'      =>  'thumb',
    //         'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $avatar , $username) : ''
    //     ],
    //     [
    //         'element'   =>  $inputHiddenID . $inputHiddenThumb . Form::submit('Save',['class'=>'btn btn-success','name'=>'taskEditInfo']),
    //         'type'      =>  'btn-submit'
    //     ]

    // ];

    $elements   = [
        [
            'label'     =>  html()->label('username', 'Username')->attributes($formlabelAttr),
            'element'   =>  html()->text('username', $username)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('fullname', 'Fullname')->attributes($formlabelAttr),
            'element'   =>  html()->text('fullname', $fullname)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('email', 'Email')->attributes($formlabelAttr),
            'element'   =>  html()->text('email', $email)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   => ($roles_id != $primeID) ? html()->select('status', $statusValue, $status)->attributes($formInputAttr) : '<label class="control-label" style="color:blue">Locked</label>'
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('avatar', 'Avatar')->attributes($formlabelAttr),
            'element'   =>  html()->file('avatar')->attributes($formInputAttr),
            'type'      =>  'thumb',
            'thumb'     =>  (!empty($item['id'])) ? Template::showItemThumb($controllerName, $avatar , $username) : ''
        ],
        [
            'element'   =>  $inputHiddenID . $inputHiddenThumb . html()->submit('Save')->attributes(['class' => 'btn btn-success', 'name' => 'taskEditInfo']),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp

<!--box-lists-->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title',['title'=>'Form Edit Info'])
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
