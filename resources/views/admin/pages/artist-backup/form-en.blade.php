{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    //dd($itemEn->toArray());

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $nameEn           = (isset($itemEn['name']))? $itemEn->name : '';
    $slugEn           = (isset($itemEn['slug']))? $itemEn->slug : '';
    $contentEn        = (isset($itemEn['content']))? $itemEn->content : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $inputNameArticleEn  = '<input class="form-control col-md-6 col-xs-12 name_article"
                                 name="name-en"
                                 type="text"
                                 value="' . htmlspecialchars($nameEn, ENT_QUOTES, 'UTF-8') . '"
                                 id="name_article-en"
                                 data-auto-increment="'.$autoIncrement.'"
                          >';
    $inputSlugEn      = '<input  class="form-control col-md-6 col-xs-12"
                                    name="slug-en"
                                    type="text"
                                    id="slug-en"
                                    value="'.$slugEn.'"
                        >';

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    // $elements   = [
    //     [
    //         'label'     =>  Form::label('name', 'Name', $formlabelAttr),
    //         'element'   =>  $inputNameArticleEn
    //     ],
    //     [
    //         'label'     =>  Form::label('slug', 'Slug', $formlabelAttr),
    //         'element'   =>  $inputSlugEn
    //     ],
    //     [
    //         'label'     =>  Form::label('content', 'Content',$formlabelAttr),
    //         'element'   =>  Form::textarea('content-en', $contentEn, $formInputAttr + ['id' => 'ckeditor-en'])
    //     ]
    // ];

    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),
            'element'   =>  $inputNameArticleEn
        ],
        [
            'label'     =>  html()->label('slug', 'Slug')->attributes($formlabelAttr),
            'element'   =>  $inputSlugEn
        ],
        [
            'label'     =>  html()->label('content', 'Content')->attributes($formlabelAttr),
            'element'   =>  html()->textarea('content-en', $contentEn)->attributes($formInputAttr + ['id' => 'ckeditor-en'])
        ]
    ];

@endphp


<div class="tab-pane fade show active in" id="form-en" role="tabpanel" aria-labelledby="home-tab">
    <!-- x Content -->
    <div class="x_content" style="display: block;">
            {!! FormTemplate::show($elements)!!}
    </div>
</div>

<script src="{{asset('admin/js/ckeditor/ckeditor.js')}}"></script>
<script>
    // Khởi tạo CKEditor, tích hợp với Laravel file manager với những input textarea có id = 'ckeditor' hoặc id = 'content'
    CKEDITOR.replace('ckeditor-en', {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token={{ csrf_token() }}'
    });
</script>
