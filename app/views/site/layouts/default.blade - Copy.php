<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}" />

    <title>Reabilitare EU</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    <!-- Custom CSS -->
    {{ HTML::style('assets/css/sb-admin-2.css'); }}
   
    <!-- Custom Fonts -->
    {{ HTML::style('assets/font-awesome-4.1.0/css/font-awesome.min.css'); }}

    {{ HTML::style('assets/css/awesome-bootstrap-checkbox.css'); }}
	
	{{ HTML::style('assets/css/login.css'); }}

    @yield('head_scripts')

</head>

<body>
	@yield('content')

	    
    <!-- jQuery Version 1.11.0 -->
    {{ HTML::script('assets/js/jquery-1.11.1.js'); }}

    <!-- Bootstrap Core JavaScript -->
    {{ HTML::script('assets/js/bootstrap.min.js'); }}

    <!-- Custom Theme JavaScript -->
    {{ HTML::script('assets/js/sb-admin-2.js'); }}

    {{ HTML::script('assets/js/bootstrap-checkbox.js'); }}

    @yield('footer_scripts') 

</body>

</html>
