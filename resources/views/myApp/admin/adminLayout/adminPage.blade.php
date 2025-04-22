<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Ce que j'ai ajouté-->
    <link rel="stylesheet" href="{{asset('assets/css/portal.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/templatemo-style.css')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--
    <script src="assets/plugins/fontawesome/js/all.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    -->
    <title>@yield('title')</title>
</head>
<body>
  <div>
    <div class="app-sidepanel-admin">
    @include('myApp.admin.adminLayout.NavSideBar')
    </div>
    <div class="content-wrapper">
    @yield('search-bar')
    @yield('parties-prenantes')
    @yield('content')
    @yield('errorContent')
    @yield('script')
    @yield('content2')
    @yield('info-edit-user')
    </div>
  </div>
  <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>