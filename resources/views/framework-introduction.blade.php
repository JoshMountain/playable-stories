<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>{{ $introduction->story->name }}</title>

        <!-- Bootstrap -->
        <link href="/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="/css/app.css">

        @yield('header-include')

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="story-view">

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-left">
                    <p class="navbar-text">{{ Session::get('story-'.$introduction->story->id.'-meter-1-name') }}<br /><span class="lead">${{ Session::get('story-'.$introduction->story->id.'-meter-1-value') }}</span></p>
                </div>
                <div class="navbar-right">
                    <p class="navbar-text text-right">{{ Session::get('story-'.$introduction->story->id.'-meter-2-name') }}<br /><span class="lead">{{ Session::get('story-'.$introduction->story->id.'-meter-2-value') }}</span></p>
                </div>
            </div>
        </nav>

        @yield('content')

        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <div class="navbar-center">
                    <p class="navbar-text text-center">Powered by <a href="http://playablemedia.org">Playable Media</a></p>
                </div>
            </div>
        </nav>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Include IFrame-Resizer to support embedding in other contexts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.5.5/ie8.polyfils.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.5.5/iframeResizer.contentWindow.min.js"></script>

        @yield('footer-include')
    </body>
</html>
