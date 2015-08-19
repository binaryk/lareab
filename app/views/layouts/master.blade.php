<!DOCTYPE html>
<html lang="en" ng-app="app">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}" />

    <title>Code Corner</title>

    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    {{ HTML::style('assets/css/plugins/metisMenu/metisMenu.min.css'); }}
    {{ HTML::style('assets/css/plugins/timeline.css'); }}
    {{ HTML::style('assets/css/sb-admin-2.css'); }}
    {{ HTML::style('assets/css/sb-admin-3.css'); }}
    {{ HTML::style('assets/css/plugins/morris.css'); }}
    {{ HTML::style('assets/css/plugins/toastr.min.css'); }}
    {{ HTML::style('assets/font-awesome-4.3.0/css/font-awesome.min.css'); }}
    {{ HTML::style('assets/css/awesome-bootstrap-checkbox.css'); }}
    <!--{{ HTML::style('assets/css/toastr.css'); }} -->
    {{ HTML::style('http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css'); }}
    {{ HTML::style('assets/css/plugins/x-editable/bootstrap-editable.css'); }}
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}

    @yield('head_scripts')

    <!-- Custom CSS -->
    {{ HTML::style('assets/css/main.css'); }}
    {{ HTML::style('assets/css/quick-sidebar.css'); }}
    {{ HTML::style('assets/css/layout-chat.css'); }}
    {{ HTML::style('assets/css/darkblue.css'); }}
    {{ HTML::style('assets/css/bootstrap-switch.min.css'); }}
    {{ HTML::style('assets/css/simple-line-icons.min.css'); }}

    <script>var _interval_timer;</script>
    <script>var base_url = '{{ URL::to("/"); }}';</script>
</head>

<body>

    <div id="mySpinner" ng-show="loading" />
        <div class="loader__">
            <div class="loader-inner">
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <div class="navbar-brand"> 
                <a href="{{ URL::route('modifica_utilizator_actual') }}"> 
                    Salut, 
                        @if(null !== Entrust::user()) {{ Entrust::user()->full_name }} @else guest @endif                 
                    </a> &nbsp; <a id="menu-toggle" href="#"><i class="fa fa-bars"></i></a></div>               
            </div>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            @if (Session::has('session_changed'))
            <li><a href="#" class="backtoAdmin"><i class="fa fa-refresh fa-spin"></i> Inapoi la utilizatori</a></li>
            &nbsp; | &nbsp;
            @endif

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

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="{{ phpversion(); }}">
                    <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
            </li>
            <!-- /.dropdown -->
            @if (Entrust::can('manage_users') || Entrust::can('config_app') || Entrust::can('administrare_platforma'))
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-cogs fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    @if (Entrust::can('config_app') || (Entrust::can('administrare_platforma')))
                    <li><a href="#"><i class="fa fa-cog fa-fw"></i> Configurare aplicatie</a></li>
                    @endif                 
                </ul>
                <!-- /.dropdown-user -->
            </li>
            @endif
            <li class="dropdown">
                <a title="Iesire" href="{{ URL::to('user/login') }}">
                    <i class="fa fa-sign-out fa-fw"></i>
                </a>
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" id="chat-sidebar" data-toggle="dropdown" href="#">
                    <i class="fa fa-weixin"></i>
                </a>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
    </nav>
    <div id="wrapper" class="active">
        <div class="page-quick-sidebar-wrapper">
            <div class="page-quick-sidebar">
                <div class="nav-justified">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                            <a href="#quick_sidebar_tab_1" data-toggle="tab">
                                Useri
                            </a>
                        </li>
                        <li>
                            <a href="#quick_sidebar_tab_2" data-toggle="tab">
                                Alerte &nbsp;<span class="badge badge-success">7</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                More<i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                        Alerts </a>
                                </li>                              
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                        Activities </a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                        Settings </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                            <div class="page-quick-sidebar-chat-users lista-useri" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                @include('chat.users')
                            </div>
                            <div class="page-quick-sidebar-item 1">
                                <div class="page-quick-sidebar-chat-user">
                                    <div class="page-quick-sidebar-nav">
                                        <a href="javascript:;" class="page-quick-sidebar-back-to-list"><i class="icon-arrow-left"></i> Inapoi</a>
                                    </div>
                                    <span class="load-messages" style="display: none;"><br><br><br><br><br><br><br><br><br><center><img height="50" src="{{ URL::to("/images/loading.gif") }}"></img></center></span>
                                    <div class="page-quick-sidebar-chat-user-messages">
                                        </div>
                                    <div class="page-quick-sidebar-chat-user-form">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Scrie mesajul aici..." type="text">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-primary">Trimite</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                            <div class="page-quick-sidebar-alerts-list">
                                <h3 class="list-heading">General</h3>
                                <ul class="feeds list-items">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        You have 4 pending tasks. <span class="label label-sm label-warning ">
													Take action <i class="fa fa-share"></i>
													</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                Just now
                                            </div>
                                        </div>
                                    </li>                                                                                
                                </ul>
                                <h3 class="list-heading">System</h3>
                                <ul class="feeds list-items">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        You have 4 pending tasks. <span class="label label-sm label-warning ">
													Take action <i class="fa fa-share"></i>
													</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                Just now
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-danger">
                                                            <i class="fa fa-bar-chart-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            Finance Report for year 2013 has been released.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    20 mins
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                24 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        New order received with <span class="label label-sm label-success">
													Reference Number: DR23923 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                30 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                24 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
													Overdue </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                2 hours
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-briefcase"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            IPO Report for year 2013 has been released.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    20 mins
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                            <div class="page-quick-sidebar-settings-list">
                                <h3 class="list-heading">General Settings</h3>
                                <ul class="list-items borderless">
                                    <li>
                                        Enable Notifications <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                        Allow Tracking <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                        Log Errors <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                        Auto Sumbit Issues <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                        Enable SMS Alerts <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                </ul>
                                <h3 class="list-heading">System Settings</h3>
                                <ul class="list-items borderless">
                                    <li>
                                        Security Level
                                        <select class="form-control input-inline input-sm input-small">
                                            <option value="1">Normal</option>
                                            <option value="2" selected>Medium</option>
                                            <option value="e">High</option>
                                        </select>
                                    </li>
                                    <li>
                                        Failed Email Attempts <input class="form-control input-inline input-sm input-small" value="5"/>
                                    </li>
                                    <li>
                                        Secondary SMTP Port <input class="form-control input-inline input-sm input-small" value="3560"/>
                                    </li>
                                    <li>
                                        Notify On System Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                        Notify On SMTP Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                </ul>
                                <div class="inner-content">
                                    <button class="btn btn-success"> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-default sidebar active" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>                        
                            <a class="active" href="{{ URL::to('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        @if (Entrust::can('administrare_platforma'))
                        <li>                        
                            <a href="#"><i class="fa fa-ellipsis-v fa-fw"></i> Aplicatii<span class="fa arrow"></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ URL::to('aplicatii_list') }}"> Acces aplicatii</a>
                                </li>
                            </ul>                            
                        </li>                            
                        @endif                        
                        @if (Entrust::can('list_livrabil'))
                        <li>
                            <a href="{{ URL::to('livrabile') }}"><i class="fa fa-archive fa-fw"></i> Livrabile</a>
                        </li>
                        @endif
                        @if (Entrust::can('manage_registru_intrare') || Entrust::can('manage_registru_iesire'))
                        <li>
                            <a href="#"><i class="fa fa-exchange fa-fw"></i> Registru<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            @if (Entrust::can('manage_registru_intrare'))
                                <li>
                                    <a href="{{ URL::to('registru_intrare_list') }}"> Registru intrare</a>
                                </li>
                            @endif
                            @if (Entrust::can('manage_registru_iesire'))
                                <li>
                                    <a href="{{ URL::to('registru_iesire_list') }}">Registru iesire</a>
                                </li>
                            </ul>
                            @endif
                        </li>  
                        @endif
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Entitati<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ URL::route('reprezentant_legal_list') }}"> Reprezentanti legali</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('personal_list') }}"> Personal grup</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('entitati_organizatie_list', 2) }}"> Parteneri ai grupului</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('entitati_publice_list') }}"> Entitati publice</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('asociatii_proprietari_list') }}"> Asociatii de proprietari</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Clienti PF</a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('banci_list') }}"> Banci</a>
                                </li>
                            </ul>
                        </li>                                            

                        <li>
                            <a href="#"><i class="fa fa-stack-overflow fa-fw"></i> Nomenclator<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('tipuri_atribute_imobil_list') }}"> Atribute imobile</a>
                                </li>                                
                                <li>                                    
                                    <a href="{{ URL::route('ocupatii_list') }}"><i class="fa fa-circle text-success"></i> COR 2015</a>
                                </li>
                                <li>                                    
                                    <a href="#"> Cladiri<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>                                    
                                            <a href="{{ URL::route('categorie_constructie_list') }}"> &nbspCategorie cladire</a>
                                        </li>   
                                        <li>                                    
                                            <a href="{{ URL::route('destinatie_constructie_list') }}"> &nbspDestinatie cladire</a>
                                        </li>   
                                    </ul>
                                </li>
                                @if (Entrust::can('manage_dtc'))                            
                                <li>                                    
                                    <a href="{{ URL::route('date_template_contract') }}"> Date template contract</a>
                                </li>
                                @endif
                                @if (Entrust::can('manage_tc'))
                                <li>                                    
                                    <a href="{{ URL::route('template_contract') }}"> Template contract</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @if (Entrust::can('list_contract') || Entrust::can('list_obiectiv'))
                        <li>
                            <a href="#"><i class="fa fa-book fa-fw"></i> Management contracte<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @if (Entrust::can('list_contract'))
                                <li>                                    
                                    <a href="{{ URL::route('contract_list') }}"> Contracte</a>
                                </li>
                                @endif
                                @if (Entrust::can('list_obiectiv'))
                                <li>                                    
                                    <a href="{{ URL::route('obiectiv_list') }}"> Obiective</a>
                                </li>
                                @endif
                                @if (Entrust::can('list_centralizator_cc'))
                                <li>                                    
                                    <a href="{{ URL::route('centralizator_cc_list') }}"><i class="fa fa-circle text-success"></i> Centralizator contracte client</a>
                                </li>
                                @endif
                                @if (Entrust::can('list_centralizator_cf'))
                                <li>                                    
                                    <a href="{{ URL::route('centralizator_cc_list') }}"><i class="fa fa-circle text-success"></i> Centralizator contracte furnizor</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if (Entrust::can('manage_finance'))  
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw"></i> Management financiar<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('livrabile_nefacturate_client') }}"> Livrabile nefacturate client</a>
                                </li>                                
                                <li>                                    
                                    <a href="{{ URL::route('livrabile_nefacturate_furnizor') }}"> Livrabile nefacturate furnizor</a>
                                </li>                                
                                <li>                                    
                                    <a href="{{ URL::route('facturi_furnizor') }}"> Facturi primite</a>
                                </li>                             
                                <li>                                    
                                    <a href="{{ URL::route('facturi_client') }}"> Facturi emise</a>
                                </li>                             
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Cash flow</a>
                                </li>                             
                                <li>                                    
                                    <a href="{{ URL::route('serii_facturare') }}"> Serii de facturare</a>
                                </li>                             
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a href="#"><i class="fa fa-building fa-fw"></i> Management cladiri<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('imobile_list') }}"> Imobile</a>
                                </li>                                                                                                                     
                            </ul>
                        </li>                        
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw text-danger"></i> Management investitie<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Pregatire</a>
                                </li>                             
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Implementare</a>
                                </li>                             
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Exploatare</a>
                                </li>                             
                            </ul>
                        </li>                        
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw text-danger"></i> Management AAA<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Avize</a>
                                </li>                             
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Acorduri</a>
                                </li>                             
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Autorizatii</a>
                                </li>                             
                            </ul>
                        </li> 
                        <li>
                            <a href="#"><i class="fa fa-circle fa-fw text-success"></i> Management proiecte<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @if (Entrust::can('list_por_axa12'))
                                <li>                                    
                                    <a href="{{ URL::route('investitie_por_axa12_list', 1) }}"><i class="fa fa-circle text-success"></i> Repartizare cheltuieli</a>
                                </li>
                                @endif
                            </ul>
                        </li>                                                
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw text-danger"></i> Management devize<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            </ul>
                        </li>                                                
                        <li>
                            <a href="#"><i class="fa fa-magnet fa-fw text-danger"></i> Management procese<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Operational</a>
                                </li>
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Ticketing</a>
                                </li>                                 
                            </ul>
                        </li>                     
                        <li>
                            <a href="#"><i class="fa fa-circle fa-fw text-danger"></i> Management HR<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            </ul>
                        </li>                                                
                        <li>
                            <a href="#"><i class="fa fa-circle fa-fw text-danger"></i> Management PR<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            </ul>
                        </li>                                                
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw"></i> Management grup<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="{{ URL::route('entitati_organizatie_list', 1) }}"> Firme din grup</a>
                                </li>
                                @if (Entrust::can('list_departament') || Entrust::can('administrare_platforma'))
                                <li>                                    
                                    <a href="{{ URL::route('departament_list_organizatie') }}"> Departamente</a>
                                </li>
                                @endif 
                                @if (Entrust::can('manage_roles') || Entrust::can('administrare_platforma'))                                                                 
                                <li>                                    
                                    <a href="{{ URL::to('admin/roles/list') }}">Grupuri utilizatori</a>
                                </li>
                                @endif
                                @if (Entrust::can('manage_users'))        
                                <li>                                    
                                    <a href="{{ URL::to('admin/users/list') }}"> Utilizatori</a>
                                </li>
                                @endif   
                            </ul>
                        </li>                                                
                        <li>
                            <a href="#"><i class="fa fa-eur fa-fw text-danger"></i> Instrumente<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Calendar</a>
                                </li>
                                <li>                                    
                                    <a href="#"><i class="fa fa-circle text-danger"></i> Forum</a>
                                </li>                                                            
                            </ul>
                        </li>                                                
                    </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </div>
    <!-- /#wrapper -->

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="  padding-bottom: 0px; margin: 15px 5px;">@yield('title')</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        @yield('content')
     </div>
    <!-- /#page-wrapper -->


    <!-- jQuery Version 1.11.0 -->
    {{ HTML::script('assets/js/jquery-1.11.1.js'); }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}
    {{ HTML::script('//code.jquery.com/jquery-2.0.3.min.js') }}
    {{ HTML::script('assets/js/bootstrap.min.js'); }}
    {{ HTML::script('assets/js/plugins/metisMenu/metisMenu.min.js'); }}
    {{ HTML::script('assets/js/sb-admin-2.js'); }}
    {{ HTML::script('assets/js/bootstrap-checkbox.js'); }}
    {{ HTML::script('assets/js/autoNumeric.js'); }}
    {{ HTML::script('assets/js/jquery-ui.js'); }}   
    {{ HTML::script('assets/js/plugins/bootbox.min.js') }}
    {{ HTML::script('assets/js/plugins/toastr.min.js') }}   
    {{ HTML::script('assets/js/util.js') }}
    {{ HTML::script('assets/js/plugins/x-editable/bootstrap-editable.min.js') }}
    {{ HTML::script('assets/js/main.js'); }}
    {{ HTML::script('assets/js/quick-sidebar.js'); }}
    {{ HTML::script('assets/js/metronic.js'); }} 
    {{ HTML::script('assets/js/jquery_017.js'); }}
    {{ HTML::script('assets/js/bootstrap-switch.min.js'); }}
    
    <script>
        // for tooltips
        $(document).ready(function(){
            $('[title]').tooltip();

            $('#mySpinner').hide();

            $('.backtoAdmin').click(function(){
                $.ajax({
                    type: "POST",
                    url : "{{ URL::to('/session/change_session_admin') }}",
                    success : function(data){
                        window.location.href = "{{ URL::to('admin/users/list') }}";
                    },
                    error : function(data) {
                        console.log(data);
                    }
                });
            });

        });

        // sending token header
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        jQuery(document).ready(function() {
            Metronic.init();
            QuickSidebar.init();
        });
        $('body').bind('DOMMouseScroll', function(e){
            if(e.originalEvent.detail > 0) {
                $(".page-quick-sidebar-wrapper").addClass("active");
            }
            if(!$(window).scrollTop()) {
                $(".page-quick-sidebar-wrapper").removeClass("active");
            }
        });
        jQuery(function($) {
            $('.auto').autoNumeric('init');
        });
    </script>

    @yield('footer_scripts')

</body>

</html>
