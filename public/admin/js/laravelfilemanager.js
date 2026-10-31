//-- Tích hợp Cấu hình CKEditor để sử dụng Laravel File Manager --
$(document).ready(function() {

    // Kiểm tra xem CKEditor có được load hay không
    if (typeof isCkeditorRequired !== 'undefined' && isCkeditorRequired) {
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
        };

        // var options = {
        //     filebrowserImageBrowseUrl: 'http://proj_news.xyz/laravel-filemanager?type=Images',
        //     filebrowserImageUploadUrl: 'http://proj_news.xyz/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
        //     filebrowserBrowseUrl: 'http://proj_news.xyz/laravel-filemanager?type=Files',
        //     filebrowserUploadUrl: 'http://proj_news.xyz/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
        // };

        /* Lỗi: "Uncaught The editor instance "content" is already attached to the provided element".

        Lỗi này xảy ra vì CKEditor cố gắng khởi tạo lại trên một phần tử đã được khởi tạo trước đó.
        Khi bạn gọi CKEDITOR.replace('content', options);, nó sẽ cố gắng khởi tạo lại một instance CKEditor trên phần tử có id là content,
        mặc dù CKEditor đã được đính kèm trước đó.
        Để tránh lỗi này, bạn cần kiểm tra xem CKEditor đã được khởi tạo trên phần tử đó hay chưa trước khi gọi CKEDITOR.replace.
        */

        if (CKEDITOR.instances['content']) {
            /* Lỗi sẽ xuất hiện khi ta đã sử dụng class=ckedite cho input nhưng muốn nhét thêm giao diện CKEDITOR có option trên id
            vì class=ckedite sẽ gọi giao diện ckeditor cho input mà không có option.
            Nên muốn thêm option có tích hợp Laravel file manager thì ta phải `destroy` giao diện ckeditor cũ không có option trước, sau đó mới dùng
            CKEDITOR.replace('content', options);  để CKEDITOR có option tích hợp để được gọi thêm một lần nữa. Hoặc đổi class input không có ckeditor*/
            CKEDITOR.instances['content'].destroy(true);
        }
        CKEDITOR.replace('content', options);
    } else {
        console.log('CKEditor không được load trên trang này.');
    }
});



