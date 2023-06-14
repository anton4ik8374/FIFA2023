<!doctype html>
<html lang="ru">
<head>
    <title>Web_door &#9748;</title>
    <meta charset="UTF-8">
    <meta name="yandex-verification" content="c6b3a2e9b03ce44b" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Web-Door">
    <link rel="shortcut icon" sizes="61x35" href="/images/logo/icon.png">
    <link rel="apple-touch-icon" sizes="61x35" href="/images/logo/icon.png">
    <meta property="title" content="«Web_Door» | Ваш новый сайт уже готов">
    <meta property="description" content="Создание современных web приложений, ресурсов, сервисов.">
    <meta property="keywords" content="Создание современных web приложений, ресурсов, сервисов.">
    <meta property="og:title" content="«Web_Door» | Ваш новый сайт уже готов">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width"/>
    <title>{{env('APP_NAME', '')}}</title>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(55869289, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/55869289" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Global site tag (gtag.js) - Google Analytics
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-121796055-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-121796055-1');
    </script>
    Google Tag Manager
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TXPKZ62');</script>
   End Google Tag Manager -->
</head>
<body>
<div id="app"></div>
@viteReactRefresh
@vite("resources/js/app.jsx")
</body>
</html>
