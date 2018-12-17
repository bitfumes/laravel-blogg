<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/bitfumes/blog/favicon.ico') }}">

    <title>Bitfumes</title>

    <!-- Style sheets-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="{{ asset(mix($cssFile, 'vendor/blogg')) }}" rel="stylesheet" type="text/css">
</head>
<body>

<div id="blogg">
    <flash message="{{session('flash')}}"></flash>
    <router-view></router-view>
</div>

<script src="{{asset(mix('app.js', 'vendor/blogg'))}}"></script>
</body>
</html>
