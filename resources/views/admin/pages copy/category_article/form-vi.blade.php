{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    // dd($item);
    $nameVi = '';
    $slugVi = '';

    if($item != null){
        foreach($item['translations'] as $itemTrans){
            if($itemTrans['locale'] == 'vi'){
                $nameVi = $itemTrans['name'];
                $slugVi = $itemTrans['slug'];
                break;
            }
        }
    }

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');

    $inputNameArticle  = '<input class="form-control col-md-6 col-xs-12"
                                 name="name-vi"
                                 type="text"
                                 value="' . htmlspecialchars($nameVi, ENT_QUOTES, 'UTF-8') . '"
                                 id="category_article_vi"
                                 data-auto-increment="'.$autoIncrement.'"
                          >';
    $inputSlugVi      = '<input  class="form-control col-md-6 col-xs-12"
                                    name="slug-vi"
                                    type="text"
                                    id="slug-vi"
                                    value="'.$slugVi.'"
                        >';

    // Dồn các thẻ thành 1 mảng, chuyển các class lặp lại vào zvn.php rồi dùng config::get để lấy ra
    $elements   = [
        [
            'label'     =>  html()->label('name', 'Tên')->attributes($formlabelAttr),
            'element'   =>  $inputNameArticle
        ],
        [
            'label'     =>  html()->label('slug', 'Slug')->attributes($formlabelAttr),
            'element'   =>  $inputSlugVi
        ]
    ];

@endphp


<div class="tab-pane fade show active in" id="form-vi" role="tabpanel" aria-labelledby="home-tab">
    <!-- x Content -->
    <div class="x_content" style="display: block;">
            {!! FormTemplate::show($elements)!!}
    </div>
</div>
