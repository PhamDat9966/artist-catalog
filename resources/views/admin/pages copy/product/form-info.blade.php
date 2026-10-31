@extends('admin.main')

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    //'dd($attributesWithValue);

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $slug           = (isset($item['slug']))? $item->slug : '';
    $status         = (isset($item['status']))? $item->status : '';
    $category       = (isset($item['category_product_id']))? $item->category_product_id : '';
    $description    = (isset($item['description']))? $item->description : '';

    $priceDiscountValue         =  (isset($item['price_discount_value']))? $item->price_discount_value : 0;
    $priceDiscountPercent       =  (isset($item['price_discount_percent']))? $item->price_discount_percent : 0;
    $priceDiscountType          =  (isset($item['price_discount_type']))? $item->price_discount_type : 'percent';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');
    $formCkeditorAttr  = Config::get('zvn.template.form_ckeditor');
    $inputHiddenID     = html()->hidden('id', $id);

    $statusValue       =    [
                                'default'    => Config::get('zvn.template.status.all.name'),
                                'active'     => Config::get('zvn.template.status.active.name'),
                                'inactive'   => Config::get('zvn.template.status.inactive.name')
                            ];
    $priceDiscountChoise =  [
                                'percent'    => Config::get('zvn.template.type_price_discount.percent.name'),
                                'value'      => Config::get('zvn.template.type_price_discount.value.name'),
                            ];

    $categoryValue  = $itemsCategory;

    $inputNameArticle  = '<input class="form-control col-md-6 col-xs-12"
                                 name="name"
                                 type="text"
                                 value="'.$name.'"
                                 id="name_article"
                                 data-auto-increment="'.$autoIncrement.'"
                          >';

    $elementsAttribute  = [];
    $inputAttributes    = '';

    $i = 0;

    foreach($attributesWithValue as $attribute){

        //$elementsAttribute[$i]['label'] = Form::label($attribute['attribute_name'], ucfirst($attribute['attribute_name']), $formlabelAttr);
        $elementsAttribute[$i]['label'] = html()->label($attribute['attribute_name'], ucfirst($attribute['attribute_name']))->attributes($formlabelAttr); // Sử dụng html helper để tạo label với các thuộc tính từ config

        //Biến định danh loại thuộc tính: color_1 màu sắc có id = 1, material-2 nguyên liệu có id = 2, slogan-3 slogan có id =3
        $attribute_type      = $attribute['attribute_name'] . '-' . $attribute['attribute_id'];

        $inputAttributes     = '<div class="col-md-12 col-xs-12">';

        foreach($attribute['attribute_values'] as $attributeValues){
            $flagCheckbox     = '';
            $flagCheckbox = (in_array($attributeValues['value_id'] , $item_has_attribute_ids)) ? 'checked' : '';

            $inputAttributes .= '<div style="position: relative;margin:5px;">';
            $inputAttributes .=     '<div class="checkbox checkbox-wrapper-8" style="position: relative;">';
            $inputAttributes .=         '<input name="attribute_value[]" style="margin-left:0px;margin:0px" class="tgl tgl-skewed"
                                                type="checkbox"
                                                value="'.$attributeValues['value_id'].'$'.$attributeValues['value_name'].'$'.$attribute_type.'"
                                                id="'.$attributeValues['value_id'].'"
                                                ' .$flagCheckbox. '
                                        >';

            $inputAttributes .=         '<label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="'.$attributeValues['value_id'].'"></label>';
            $inputAttributes .=     '</div>';
            $inputAttributes .=     '<strong style="margin-left: 2px;margin-top: 2px;">' . $attributeValues['value_name'] . '</strong>';
            $inputAttributes .='</div>';
        }
        $inputAttributes     .= '</div>';

        $elementsAttribute[$i]['element'] = $inputAttributes;

        $i++;
    }

    //Dropzone thumb
    $thumbs = '<input type="file" name="file" style="display: none;">';

    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),
            'element'   =>  $inputNameArticle                            // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('slug', 'Slug')->attributes($formlabelAttr),
            'element'   =>  html()->text('slug', $slug)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('description', 'Description')->attributes($formlabelAttr),
            'element'   =>  html()->textarea('description', $description)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('thumbs', 'Thumbs')->attributes($formlabelAttr),
            'type'      =>  "dropzone"
        ],
        [
            'label'     =>  html()->label('status', 'Status')->attributes($formlabelAttr),
            'element'   =>  html()->select('status', $statusValue, $status)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'label'     =>  html()->label('category', 'Category')->attributes($formlabelAttr),
            'element'   =>  html()->select('category_product_id', $categoryValue, $category)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('price_discount_percent ', 'Price discount percent')->attributes($formlabelAttr),
            'element'   =>  html()->text('price_discount_percent', $priceDiscountPercent)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('price_discount_value', 'Price discount value')->attributes($formlabelAttr),
            'element'   =>  html()->text('price_discount_value', $priceDiscountValue)->attributes($formInputAttr)  // Với collective trong mảng này chính là các thuộc..
                                                                                                    // ..tính như class, id , name của thẻ input
        ],
        [
            'label'     =>  html()->label('price_discount_type ', 'Price discount type')->attributes($formlabelAttr),
            'element'   =>  html()->select('price_discount_type', $priceDiscountChoise, $priceDiscountType)->attributes($formInputAttr)
            //Chú thích form::select(name,array Input for select, giá trị select ban đầu mặc định là default nếu rỗng, class)
        ],
        [
            'element'   =>  $inputHiddenID . html()->submit('Save')->attributes(['class'=>'btn btn-success']),
            'type'      =>  'btn-submit'
        ]

    ];

    // Xác định vị trí muốn chèn (ví dụ chèn vào sau phần tử có khóa 2)
    $position = 3;
    // Tách mảng elements làm 2 phần rồi chèn các phần tử của mảng elementsAttribute vào giữa
    $firstPart = array_slice($elements, 0, $position, true);
    $secondPart = array_slice($elements, $position, null, true);

    // Ghép elementsAttribute vào phần thứ nhất
    $formElements01 = array_merge($firstPart, $elementsAttribute);
    // Nối phần thứ 2 vào phần đã ghép
    $elements   = array_merge($formElements01, $secondPart);
   // dd($media);
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
                {{-- Thẻ Form::open chính là thẻ form trong html với nhiều thuộc tính hơn, lấy từ đối tượng Collective --}}
                {{ html()->form('POST', route($controllerName.'/save'))
                    ->attribute('accept-charset', 'UTF-8')
                    ->attribute('enctype', 'multipart/form-data')
                    ->class('form-horizontal form-label-left')
                    ->id('main-form')
                    ->open() }}

                    {!! FormTemplate::show($elements)!!}

                {{ html()->form()->close() }}
                {{--  custom file preview dropzone   --}}

                <div id="tpl" style="display: none;">
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image" style="margin:auto">
                            <img data-dz-thumbnail />
                        </div>
                        <div class="dz-details">
                            <div class="dz-size"><span data-dz-size></span></div>
                            <div class="dz-filename"><span data-dz-name></span></div>
                        </div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div class="dz-success-mark"><span>✔</span></div>
                        <div class="dz-error-mark"><span>✘</span></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        <div style="margin-top: 5px"  class="input-thumb">
                            <input type="text" placeholder="Alt ảnh" name="thumb[alt][]" class="dz-custom-input">
                        </div>
                    </div>
                </div>

                {{--  End custom file preview dropzone  --}}
            </div>
            <!-- end x Content -->
        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section('after_script')
    <script src="{{asset('admin/js/ckeditor/ckeditor.js')}}"></script>
    <script>
        // Khởi tạo CKEditor, tích hợp với Laravel file manager
        CKEDITOR.replace('description', {
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token={{ csrf_token() }}'
        });
    </script>

    <!-- jQuery UI Sortable -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

    <script>
    $(document).ready(function() {

        Dropzone.autoDiscover = false;
        /*Dropzone.autoDiscover = false Ngăn Dropzone tự động tìm kiếm các form với class "dropzone".
          Dùng cho trường hợp tạo dropzone cho thẻ div thay vì form */
        let uploadedDocumentMap = {};
        let isSubmitting = false;           // Cờ theo dõi trạng thái submit form
        const files = @json($media);        // Chuyền dữ liệu media vào javasript trong trường hợp edit

        var myDropzone = new Dropzone("div#mydropzone", {
            url: "{{route($controllerName.'/media')}}",
            dictDefaultMessage: "Kéo thả hình ảnh vào để tải lên",
            dictRemoveFile: "Xóa",
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            previewTemplate: document.querySelector('#tpl').innerHTML,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },

            thumbnailWidth: 120, // Điều chỉnh chiều rộng thumbnail
            thumbnailHeight: null, // Đặt null để tự động điều chỉnh chiều cao theo tỷ lệ

            init: function () {

                const dropzoneInstance = this;
                const uploadedFiles = {}; // Đối tượng lưu trữ các file đã tải lên
                console.log(files);
                //Edit item thumb tại dropzone
                for(var i in files){
                    var fileData    = JSON.parse(files[i]); // Chuyển đổi JSON  --}}

                    var mockFile = {
                        id: fileData.id,
                        name: fileData.name,
                        size: fileData.size,
                        accepted: true
                    };

                    // Thêm file vào Dropzone
                    this.emit("addedfile", mockFile);
                    this.emit("thumbnail", mockFile,  "{{$srcMedia}}" + "/" + fileData.name);
                    this.emit("complete", mockFile);

                    /* khi sử dụng this.displayExitingFile(file,src); Sẽ xuất hiện lỗi: `Uncaught TypeError: this.displayExitingFile is not a function`
                    xảy ra vì trong Dropzone.js không có phương thức gốc tên là displayExitingFile. Thay vào đó, ta nên sử dụng các phương thức
                    của Dropzone như emit để hiển thị các file hiện có.*/

                    // Đánh dấu file là hoàn thành tải
                    mockFile.previewElement.classList.add("dz-complete");

                    // Thêm thông tin input hidden
                    $(mockFile.previewElement)
                        .find(".input-thumb")
                        .append(
                            `<input type="hidden" name="thumb[id][]" value="${fileData.id}">
                             <input type="hidden" name="thumb[name][]" value="${fileData.name}">`
                    );

                    $(mockFile.previewElement).find('.input-thumb [name="thumb[alt][]"]').val(fileData.alt); // gán alt vào ảnh
                }

                // Khởi tạo Sortable trên khu vực preview của Dropzone
                $("#mydropzone").sortable({
                    items: ".dz-preview", // Chỉ sắp xếp các file preview
                    cursor: "move",
                    opacity: 0.7,
                    update: function (event, ui) {
                        const sortedPreviews = $(this).sortable("toArray");
                        console.log("Thứ tự mới:", sortedPreviews);
                    }
                });

                // Lắng nghe sự kiện thêm file để cập nhật Sortable
                this.on("addedfile", function (file) {
                    $("#mydropzone").sortable("refresh"); // Làm mới Sortable sau khi thêm file
                });

                // Khi upload thành công, nhận phản hồi từ server
                this.on("success", function (file, response) {
                    isSubmitting = true; // Đặt cờ, nhằm ngăn chặn sự kiện `beforeunload` clear file temp

                    if (response.name) {
                        uploadedFiles[file.upload.uuid] = response.name; // Lưu bằng UUID của file
                        console.log("Tệp đã tải lên:",  uploadedFiles[file.upload.uuid]);
                    }

                    // Gắn hidden input chứa thông tin file đã upload
                    $(file.previewElement)
                        .find('.input-thumb')
                        .append(`<input type="hidden" name="thumb[name][]" value="${response.name}">`);

                    // Lưu thông tin file đã upload vào biến
                    uploadedDocumentMap[file.name] = response.name;
                });

                // Sự kiện khi nhấn nút "Xóa"
                this.on("removedfile", function (file) {

                    const serverFileName = uploadedFiles[file.upload.uuid]; // Lấy tên file từ đối tượng

                    if (serverFileName) {

                        console.log("File server name:", serverFileName);

                        // Gửi yêu cầu xóa file đến server
                        $.ajax({
                            url:"{{route($controllerName.'/deleteMedia')}}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                fileName: serverFileName
                            },
                            success: function (response) {
                                console.log("File đã được xóa:", response);
                            },
                            error: function (xhr) {
                                console.error("Lỗi khi xóa file:", xhr.responseText);
                            }
                        });
                    } else {
                        console.warn("Không tìm thấy tên file trên server.");
                    }
                });

            }

            {{--  success: function(file, response){
                $(file, previewElement)
                    .find('.input-thumb')
                    .append('<input type="hidden" name="[name][]" value="${response.name}">');
                uploadedDocumentMap[file.name] = response.name;
            },
            removedfile: function (file){
                file.previewElement.remove();
                var name = '';
                if(typeof file.nam !== 'undefined') {

                } else {
                    name = uploadedDocumentMap[file.name]
                }
            },
            error: function (file, response){
                return false;
            }  --}}

        });

    });

    /*  Cleanup file ảnh qua Sự Kiện Form (f5 hoặc refresh)
        Sự kiện được kích hoạt khi trang được tải lại (refresh/F5) hoặc khi người dùng thoát khỏi form hoặc không submit*/
    window.addEventListener("beforeunload", function (e) {

        if (isSubmitting) {
            // Nếu đang submit form, không kích hoạt xóa file tạm
            return;
        }

        // Gửi yêu cầu AJAX để xóa file tạm
        $.ajax({
            url: "{{route($controllerName.'/cleanupTemporaryFiles')}}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" // CSRF Token
            },
            success: function (response) {
                console.log("Đã dọn dẹp file tạm:", response);
            },
            error: function (xhr) {
                console.error("Lỗi khi dọn dẹp file tạm:", xhr.responseText);
            }
        });
    });

    </script>

@endsection


