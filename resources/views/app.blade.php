<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="{{env('APP_NAME', '')}}}">
    <link rel="shortcut icon" sizes="61x61" href="/storage/logos/site.png">
    <link rel="apple-touch-icon" sizes="61x61" href="/storage/logos/site.png">
    <meta property="title" content="{{env('APP_NAME', '')}}}">
    <meta property="description" content="soccer win bet">
    <meta property="keywords" content="soccer">
    <meta property="og:title" content="{{env('APP_NAME', '')}}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width"/>
    <title>{{env('APP_NAME', '')}}</title>
</head>
<body>
<div id="app"></div>
@viteReactRefresh
@vite("resources/js/app.jsx")
</body>
</html>
