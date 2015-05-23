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

    <!-- MetisMenu CSS -->
    {{ HTML::style('assets/css/plugins/metisMenu/metisMenu.min.css'); }}

    <!-- Timeline CSS -->
    {{ HTML::style('assets/css/plugins/timeline.css'); }}

    <!-- Custom CSS -->
    {{ HTML::style('assets/css/sb-admin-2.css'); }}

    <!-- Morris Charts CSS -->
    {{ HTML::style('assets/css/plugins/morris.css'); }}

    <!-- Custom Fonts -->
    {{ HTML::style('assets/font-awesome-4.1.0/css/font-awesome.min.css'); }}

    {{ HTML::style('assets/css/awesome-bootstrap-checkbox.css'); }}

    {{ HTML::style('assets/css/toastr.css'); }}

    {{ HTML::style('http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css'); }}

    {{ HTML::style('assets/css/plugins/x-editable/bootstrap-editable.css'); }}

    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}

    @yield('head_scripts')

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html" name="user_connected">                
                @if(!empty($_organizatie))
					{{ $_organizatie[0]->organizatie . " (" . $_organizatie[0]->utilizator . ")" }}
				@endif
				</a> 
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <?php $colors = array('success', 'info', 'warning', 'danger'); $i = 0; ?>
          
                        <li>
                            <a class="text-center" href="#">
                                <strong>Vezi toate sarcinile</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ URL::to('account/profile') }}"><i class="fa fa-user fa-fw"></i> Profil</a></li>
                        <li><a href="{{ URL::to('account/settings') }}"><i class="fa fa-gear fa-fw"></i> Setari</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('user/login') }}"><i class="fa fa-sign-out fa-fw"></i> Delogare</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">                     
                        <li>
                            <a class="active" href="{{ URL::to('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('livrabile') }}"><i class="fa fa-archive fa-fw"></i> Livrabile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-exchange fa-fw"></i> Registru<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ URL::to('registru_intrare_list') }}"> Registru intrare</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('registru_iesire_list') }}">Registru iesire</a>
                                </li>
                            </ul>
                        </li>  
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Entitati<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('firme_organizatie_list') }}"> Firme din grup</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('reprezentant_legal_list_organizatie') }}"> Reprezentanti legali</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('clienti_organizatie_list') }}"> Parteneri ai grupului</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('entitati_publice_list') }}"> Entitati publice</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('asociatii_proprietari_list') }}"> Asociatii de proprietari</a>
                                </li>
                                <li>                                    
                                    <a href="{{ URL::route('imobile_list') }}"> Imobile</a>
                                </li>
                                <li>                                    
                                    <a href="{{ URL::route('imobile_asociatii') }}"> Imobile asociatii</a>
                                </li>                                                                                            
                            </ul>
                        </li>                                            
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Nomenclator<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('date_template_contract') }}"> Date template contract</a>
                                </li>
                                <li>                                    
                                    <a href="{{ URL::route('template_contract') }}"> Template contract</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Management financiar<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('contract_list') }}"> Contracte</a>
                                </li>
                                <li>                                    
                                    <a href="{{ URL::route('obiectiv_list') }}"> Obiective</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Financiar<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('livrabile_nefacturate_client') }}"> Livrabile nefacturate client</a>
                                </li>                                
                                <li>                                    
                                    <a href="{{ URL::route('livrabile_nefacturate_furnizor') }}"> Livrabile nefacturate furnizor</a>
                                </li>                                
                                <li>                                    
                                    <a href="{{ URL::route('facturi_furnizor') }}"> Facturi furnizor</a>
                                </li>                             
                                <li>                                    
                                    <a href="{{ URL::route('facturi_client') }}"> Facturi client</a>
                                </li>                             
                                <li>                                    
                                    <a href="{{ URL::route('facturi_client') }}"> Centralizator financiar</a>
                                </li>                             
                            </ul>
                        </li>
                    </ul>                    
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('title')</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            @yield('content')
         </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- jQuery Version 1.11.0 -->
    {{ HTML::script('assets/js/jquery-1.11.1.js'); }}

    <!-- jQuery UI Version 1.11.2  -->
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}

    <!-- jQuery UI Version 2.0.3 -->
    {{ HTML::script('//code.jquery.com/jquery-2.0.3.min.js') }}

    <!-- Bootstrap Core JavaScript -->
    {{ HTML::script('assets/js/bootstrap.min.js'); }}

    <!-- Metis Menu Plugin JavaScript -->
    {{ HTML::script('assets/js/plugins/metisMenu/metisMenu.min.js'); }}

    <!-- Custom Theme JavaScript -->
    {{ HTML::script('assets/js/sb-admin-2.js'); }}

    {{ HTML::script('assets/js/bootstrap-checkbox.js'); }}

    {{ HTML::script('assets/js/autoNumeric.js'); }}

    {{ HTML::script('assets/js/jquery-ui.js'); }}
        
    {{ HTML::script('assets/js/plugins/bootbox.min.js') }} 
    
    {{ HTML::script('assets/js/toastr.js') }}

    {{ HTML::script('assets/js/util.js') }}

    {{ HTML::script('assets/js/plugins/x-editable/bootstrap-editable.min.js') }} 
    <!-- For tooltips -->
    <script>
        $(document).ready(function(){
            $('[title]:not([data-placement])').tooltip({'placement': 'right'});
            /*$.ajax({
                type: "GET",
                url : ""              
            });*/
        })
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        jQuery(function($) {
            $('.auto').autoNumeric('init');
        });
    </script>

    @yield('footer_scripts') 

</body>

</html>
