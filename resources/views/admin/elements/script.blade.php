<!-- jQuery -->
<script src="{{asset('admin/js/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin/asset/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('admin/js/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('admin/asset/nprogress/nprogress.js')}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{asset('admin/asset/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('admin/asset/iCheck/icheck.min.js')}}"></script>
<!-- sweetalert2 Scripts -->
<script src="{{asset('admin/js/sweetalert2.all.min.js')}}"></script>
<!-- Notify Scripts -->
<script src="{{asset('admin/js/notify.min.js')}}"></script>
<!-- bootstrap tags input -->
<script src="{{asset('admin/asset/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
<!-- Jquery Tags Input-->
{{-- <script src="{{asset('admin/asset/jquery-tagsinput/jquery.tagsinput.min.js')}}"></script> --}}
<!-- Tạo calendar với Bootstrap Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('admin/js/calendar.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{asset('admin/js/custom.min.js')}}"></script>
<!-- laravel File Manager Scripts -->
{{-- <script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script> --}}
<!-- Truyền mảng ánh xạ $tagToIdMap từ PHP vào JavaScript phải dùng  window.tagToIdMap vì để biến có thể sử dụng khi load DOM xong-->
<script>
    window.tagToIdMap = @json($tagToIdMap ?? []);
</script>
{{-- Tạm đặt attribute.js phía trên my-js.js do tích hợp CKEditor trong my-js.js có sự xung đột, gây lỗi làm dừng load DOM --}}
<script src="{{asset('admin/js/attribute-value.js')}}"></script>

{{-- Dropzone  --}}
<script src="{{asset('admin/asset/dropzone/dist/dropzone.js')}}"></script>
{{--  <link rel="stylesheet" href="{{asset('admin/asset/dropzone/dist/dropzone.css')}}" type="text/css" />  --}}

<!--Jquery IU Sortable-->
<script src="{{asset('admin/asset/jquery-ui/jquery-ui.js')}}"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script src="{{asset('admin/js/my-js.js')}}"></script>

<!--Cách ly tạm thời giải thuật tích hợp CKEditor để tránh gây lỗi load DOM cho các giải thuật khác-->
{{-- <script src="{{asset('admin/js/laravelfilemanager.js')}}"></script> --}}





