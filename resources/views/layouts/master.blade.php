<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Shopworks Code Test</title>

        <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        
    </head>

    <body>

        <nav class="navbar navbar-inverse bg-inverse">
            <a class="navbar-brand" href="#">Shopworks Code Test</a>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>

        <script src="{{asset('js/app.min.js')}}"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

        @stack('scripts')
    
    </body>

</html>
