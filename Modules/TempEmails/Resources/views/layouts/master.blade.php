<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}}
            v{{Config::get('core.version')}}@endif</title>

        <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/alertifyjs/1.9.0/css/themes/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/alertifyjs/1.9.0/css/alertify.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.10.0/styles/default.min.css" />


        <!---page specific-->
    @yield('page_specific_head')
    <!--/page specific-->


    </head>
    <body>
        @yield('content')


    <!--common js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
        <script src="https://cdn.jsdelivr.net/alertifyjs/1.9.0/alertify.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.2.1/vue-resource.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.10.0/highlight.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.1/clipboard.js"></script>


        <script>
            (function (document, window, $) {
                'use strict';
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
            })(document, window, jQuery);
        </script>

    <!--/common js-->

        <!---page specific-->
        @yield('page_specific_footer')
        <!--/page specific-->
    </body>
</html>
