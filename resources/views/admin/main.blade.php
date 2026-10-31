<!DOCTYPE html>
<html lang="en">
<head>
    {{-- @extends('admin.elements.head'); --}}
    @include('admin.elements.head')
</head>
<body class="nav-sm">
    {{-- nav-md --}}
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                @include('admin.elements.sidebar_title')
                @include('admin.elements.sidebar_menu')
            </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
            @include('admin.elements.top_navigation')
        </div>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
            @yield('content')
            <!--end-box-pagination-->
        </div>
        <!-- /page content -->
        <!-- footer -->
        @include('admin.elements.footer')
        <!-- /footer -->
    </div>
    @yield('popup')
</div>

    {{-- Các script chung --}}
    @include('admin.elements.script')

    {{-- Phần này sẽ load script riêng cho từng trang, cụ thể trang nào có sử dụng ckeditor --}}
    @yield('after_script')
</body>
</html>
