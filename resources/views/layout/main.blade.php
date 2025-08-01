<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/admin/assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $title }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    @include('layout.header')

</head>
<style>
    .pagination nav {
    margin: 0 auto; }
.pagination nav div:nth-child(1) {
    display: none; }
.pagination nav div:nth-child(2) span {
    box-shadow: none !important; }
.pagination nav div:nth-child(2) span span span {
    padding: 10px 14px !important;
    border: none !important;
    margin: 0 5px;
    background-color: #696cff !important;
    color: white; }
.pagination nav div:nth-child(2) span a {
    padding: 10px 14px !important;
    border: none !important;
    margin: 0 5px;
    transition: all .3s; }
.pagination nav div:nth-child(2) span a:hover {
    background-color: #696cff !important;
    color: white;
    transition: all .3s; }
.pagination svg {
    width: 20px; }

</style>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
 <div class="layout-page ps-0">
          <!-- Navbar -->
    @include('layout.head')



          <!-- / Navbar -->
            @yield('contents')

          <!-- Content wrapper -->
          @include('layout.foot')
        </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

</script>

@include('layout.footer')


</body>
</html>
