@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $username             = (isset($item->username))? $item->username : '';
    $password             = (isset($item->password))? $item->password : '';

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('username', 'Username')->attributes($formlabelAttr),  // Với html() trong mảng này chính là các thuộc tính như class, id , name của thẻ label
            'element'   =>  html()->text('username', $username)->attributes($formInputAttr)  // Với html() trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('password', 'Mật khẩu')->attributes($formlabelAttr),
            'element'   =>  html()->text('password', $password)->attributes($formInputAttr)  // Với html() trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'element'   =>  html()->submit('Save')->attributes(['class' => 'btn btn-success', 'name' => 'taskEmailAccount']),
            'type'      =>  'btn-submit'
        ]

    ];

@endphp
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="tab-pane fade show active in" id="email" role="tabpanel" aria-labelledby="home-tab">
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
