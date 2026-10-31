@extends('admin.main')

@section('content')
    <!-- page content -->
    @include('admin.templates.page_header', ['pageIndex' => false])

    @include('admin.templates.error')

    @include('admin.pages.product.info-product')

@endsection
