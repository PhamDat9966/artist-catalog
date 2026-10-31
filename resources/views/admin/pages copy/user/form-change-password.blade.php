@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label_edit');
    $formInputAttr     = Config::get('zvn.template.form_input');

    $id             = (isset($item['id']))? $item['id'] : '';
    $inputHiddenID     = html()->hidden('id', $id);

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    // $elements   = [
    //     [
    //         'label'     =>  Form::label('password', 'Password',$formlabelAttr),
    //         'element'   =>  Form::password('password', $formInputAttr)
    //     ],
    //     [
    //         'label'     =>  Form::label('password_confirmation', 'Password_confirmation',$formlabelAttr),
    //         'element'   =>  Form::password('password_confirmation', $formInputAttr)
    //     ],
    //     [
    //         'element'   =>  $inputHiddenID . Form::submit('Save',['class'=>'btn btn-success','name'=>'taskChangePassword']),
    //         'type'      =>  'btn-submit-edit'
    //     ]
    // ];

    $elements   = [
        [
            'label'     =>  html()->label('password', 'Password')->attributes($formlabelAttr),
            'element'   =>  html()->password('password')->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('password_confirmation', 'Password Confirmation')->attributes($formlabelAttr),
            'element'   =>  html()->password('password_confirmation')->attributes($formInputAttr)
        ],
        [
            'element'   =>  $inputHiddenID . html()->submit('Save')->attributes(['class' => 'btn btn-success', 'name' => 'taskChangePassword']),
            'type'      =>  'btn-submit-edit'
        ]
    ];

@endphp

<!--box-lists-->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title',['title'=>'Change Password'])
        <!-- x Content -->
        <div class="x_content" style="display: block;">
            {{ html()->form('POST', route($controllerName.'/change-password'))
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

<!-- /page content -->

{{-- <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title',['title'=>'Change Password'])
        <!-- x Content -->
        <div class="x_content" style="display: block;">
            {!! Form::open([
                    'url'               =>  Route($controllerName.'/change-password'),
                    'method'            =>  'POST',
                    'accept-charset'    =>  'UTF-8',
                    'enctype'           =>  'multipart/form-data',
                    'class'             =>  'form-horizontal form-label-left',
                    'id'                =>  'main-form'
                ]) !!}

            {!! FormTemplate::show($elements)!!}
            {!! Form::close() !!}
        </div>
        <!-- end x Content -->
    </div>
</div> --}}
