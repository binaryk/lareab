@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
  Grupuri de utilizatori
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <button id="btn_show_hide" class="btn btn-primary" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </button>  
                </div>
                                                                        
                <div id="div_cautare" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nume de utilizator</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>                      
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista grupuri de utilizatori              
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::to('admin/roles/create') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-group">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nume grup de utilizator</th>                   
                            <th class="text-center">Creat in</th>
                            <th class="text-center">Numar utilizatori in grup</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Nume grup de utilizator</th>                   
                            <th class="text-center">Creat in</th>
                            <th class="text-center">Numar utilizatori in grup</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($grupuri as $grup)
                            <tr data-id="{{ $grup->id }}">         
                              <td class="text-left">{{ $grup->name }}</td>
                              <td class="text-center">{{ $grup->created_at }}</td>
                              <td class="text-center">{{ $grup->num_users }}</td>
                              <td class="center action-buttons">                                
                                <a href="{{ URL::to('admin/roles/' . $grup->id . '/edit') }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>                           
                                </a>
                              </td>                                                         
                            </tr>
                          @endforeach                             
                        </tbody>
                      </table>
                   </div>
                   <!-- /.table-responsive -->
               </div>
               <!-- /.panel-body -->
           </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row --> 
  @stop

@section('footer_scripts')
    <!-- DataTables JavaScript -->
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }} 

    <script>
        $(document).ready(function() {          
            $('#dataTables-group').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-group').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" },            
                ]
            });

        });
    </script>
@stop