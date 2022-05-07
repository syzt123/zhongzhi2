<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>指尖种植</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
</head>
<body>
@section('sidebar')
    <div class="">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            @yield('content')
        </div>
    </div>
@show
<script src="/layui/layui.js"></script>
@yield('js')

</body>
</html>
