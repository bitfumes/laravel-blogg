<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="shortcut icon" href="{{ asset('/vendor/bitfumes/blog/favicon.ico') }}">

    <title>{{ config('app.name') }}</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link href="{{ asset(mix($cssFile, 'vendor/blogg')) }}" rel="stylesheet" type="text/css">
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</head>
<body>

<div id="blogg" data-app>
    <flash message="{{session('flash')}}"></flash>
    <transition name="fade">
        <router-view></router-view>
    </transition>
</div>
<script>
window.apiEndpoint = "{{ config('app.url') }}/api"
</script>

<script src="{{asset(mix('app.js', 'vendor/blogg'))}}"></script>
</body>
</html>
