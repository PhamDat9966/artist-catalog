@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    //dd($itemsAttributevalue);
    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');

    $elements = [];
    $i=0; //phần tử định vị

    foreach ($itemsAttribute as $itemAttribute) {
        //Lấy các name của từng Attributevalue nối vào tags theo attribute_id
        $ids        = '';
        $tags       = '';
        foreach ($itemsAttributevalue as $tagValue) {
            if($tagValue['attribute_id'] == $itemAttribute['id']){
                $ids    .= $tagValue['id'] . ',';
                $tags   .= $tagValue['name'] . '$';
            }
        }
        $ids  = rtrim($ids, ",");
        $tags = rtrim($tags, ",");
        /* Ý tưởng: tạo 2 input, một thẻ chứa các tag name của các phần tử, một thẻ chứa các id của phần tử.
            Sau đó dùng jquery để đồng bộ trong tác vụ `xóa tags`: attribute.js */
        //Gom trung 3 input.
        $tagsInput               = '<input type="text" value="'.$tags.'" data-role="tagsinput" class="tags form-control" name="'.$itemAttribute['name'].'">';
        $iputHiddenIDS           = '<input type="hidden" id="'.$itemAttribute['name'].'_ids" name="'.$itemAttribute['name'].'_ids" value="'.$ids.'">';
        $iputHiddenAddIDS        = '<input type="hidden" id="'.$itemAttribute['name'].'_add" name="'.$itemAttribute['name'].'_add" value="">';

        $elements[$i]['label']   = html()->label($itemAttribute['name'], ucwords($itemAttribute['name']))->attributes($formlabelAttr);
        $elements[$i]['element'] = $tagsInput . $iputHiddenIDS . $iputHiddenAddIDS;

        // input chứa tập hợp các name dưới dạng tags: Tách 3 thẻ ra để test dữ liệu, tạm giữ lại khi cần
        // $tagsInput               = '<input type="text" value="'.$tags.'" data-role="tagsinput" class="tags" name="'.$itemAttribute['name'].'">';
        // $elements[$i]['label']   = Form::label( $itemAttribute['name'] , ucwords($itemAttribute['name']) , $formlabelAttr );
        // $elements[$i]['element'] = $tagsInput;
        // // input chứa tập hợp các id tương ứng dưới dạng hidden, tạm thời ở đây sẽ show input
        // $i=$i+1;
        // $iputHiddenIDS           = '<input type="text" id="'.$itemAttribute['name'].'_ids" name="'.$itemAttribute['name'].'_ids" value="'.$ids.'">';
        // $elements[$i]['label']   = Form::label( $itemAttribute['name'] .'-ids' , ucwords($itemAttribute['name']) .'-ids' , $formlabelAttr );
        // $elements[$i]['element'] = $iputHiddenIDS;

        // // input chứa tập hợp các id tương ứng dưới dạng hidden, tạm thời ở đây sẽ show input
        // $i=$i+1;
        // $iputHiddenAddIDS        = '<input type="text" id="'.$itemAttribute['name'].'_add" name="'.$itemAttribute['name'].'_add" value="">';
        // $elements[$i]['label']   = Form::label( $itemAttribute['name'] .'-add' , ucwords($itemAttribute['name']) .'-add' , $formlabelAttr );
        // $elements[$i]['element'] = $iputHiddenAddIDS;

        $i++;
    }

    $elements[$i]['element'] = html()->submit('Save')->attributes(['class' => 'btn btn-success']);
    $elements[$i]['type']    = 'btn-submit';

@endphp

@section('content')
<!-- page content -->
@include('admin.templates.page_header', ['pageIndex' => false])

@include('admin.templates.error')

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
@endsection

