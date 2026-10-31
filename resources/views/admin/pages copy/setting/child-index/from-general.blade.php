@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    use Illuminate\Http\Request;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $logo               = (isset($item->logo))? $item->logo : '';
    $logoUrl            = (!empty($logo)) ? $host . $logo : '';
    $hotline            = (isset($item->hotline))? $item->hotline : '';
    $timeword           = (isset($item->timeword))? $item->timeword : '';
    $copyright          = (isset($item->copyright))? $item->copyright : '';
    $address            = (isset($item->address))? $item->address : '';
    $introduction       = (isset($item->introduction))? $item->introduction : '';
    $googlemap          = (isset($item->googlemap))? $item->googlemap : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $statusValue       = [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                          ];

    $inputLogoImage     = '<div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="logo" value="'.$logo.'">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="'.$logoUrl.'">';
                            //input value của input quyết định xem đường dẫn của ảnh
                            //image src quyet định hình ảnh ở vị trí nào, nếu không xuất ảnh để giá trị rỗng

    $elements   = [
        [
            'label'     =>  html()->label('logo', 'Logo')->attributes($formlabelAttr),
            'element'   =>  $inputLogoImage
        ],
        [
            'label'     =>  html()->label('hotline', 'Hotline')->attributes($formlabelAttr),
            'element'   =>  html()->text('hotline', $hotline)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('timeword', 'Thời gian làm việc')->attributes($formlabelAttr),
            'element'   =>  html()->text('timeword', $timeword)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('copyright', 'Copyright')->attributes($formlabelAttr),
            'element'   =>  html()->text('copyright', $copyright)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('address', 'Address')->attributes($formlabelAttr),
            'element'   =>  html()->text('address', $address)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('introduction', 'Giới thiệu')->attributes($formlabelAttr),
            'element'   =>  html()->textarea('introduction', $introduction)->attributes($formCkeditorAttr)
        ],
        [
            'label'     =>  html()->label('googlemap', 'Google Maps')->attributes($formlabelAttr),
            'element'   =>  html()->textarea('googlemap', $googlemap)->attributes($formInputAttr)
        ],
        [
            'element'   =>  html()->submit('Save')->attributes(['class' => 'btn btn-success', 'name' => 'taskGeneral']),
            'type'      =>  'btn-submit'
        ]

    ];



@endphp
<div class="tab-pane fade show active in" id="home" role="tabpanel" aria-labelledby="home-tab">
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
