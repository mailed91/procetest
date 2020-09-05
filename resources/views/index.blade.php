<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/jexcel/css/jsuites.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/jexcel/css/jexcel.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="row" style="margin: 0;padding: 2%;">
    <div class="col-md-12"><h1 style="text-align: center;">فرم بروزرسانی قیمت</h1></div>
    <div class="col-md-12"><hr></div>
    <div class="col-md-2"><label>از تاریخ :</label><input type="text" name="S_DATE" style="width: 100%;"></div>
    <div class="col-md-2"><label>تا تاریخ :</label><input type="text" name="E_DATE" style="width: 100%;"></div>
    <div class="col-md-12"></div>
    <div class="col-md-2">
        <a class="btn btn-gradient-info" onclick="load();">تصویب</a>
        <a class="btn btn-gradient-success" onclick="save();">ذخیره</a>
    </div>
    <div class="col-md-12"><hr></div>
    <div class="col-md-12 align-items-center justify-content-center" id="table"></div>
</div>

<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('assets/jexcel/js/jexcel.js') }}"></script>
<script src="{{ URL::asset('assets/jexcel/js/jsuites.js') }}"></script>
<script src="{{ URL::asset('assets/js/trigger/index.js') }}"></script>

</body>
</html>
