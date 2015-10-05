@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
    {{ HTML::style('Editor-PHP-1.4.2/css/dataTables.editor.css') }}
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}
@stop

@section('title')
    <p>Scarile imobilului 
        @if(isset($imobil)) {{ $imobil->adresa }} @endif
    </p> 
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
                                <label class="control-label">Scara</label></td>
                            <td width="75%"><p id="_col_scara"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Observatii</label></td>
                            <td width="75%"><p id="_col_observatii"></p></td>
                        </tr>   
						<tr>
                            <td width="25%">
                                <label class="control-label">Asociatie de locatari</label></td>
                            <td width="75%"><p id="_col_ap"></p></td>
                        </tr>                                                          
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista scari ale imobilului
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                              
                        <a href="{{ URL::route('scara_add', $id_imobil) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-incasari">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Scara</th>                      
                            <th class="text-center">Observatii</th>
                            <th class="text-center">Asociatia de proprietari</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Scara</th>                      
                            <th class="text-center">Observatii</th>
                            <th class="text-center">Asociatia de proprietari</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($scari as $scara)
                            <tr data-id="{{ $scara->id }}">                              
                              <td class="text-center">{{ $scara->scara }}</td>                            
                              <td class="text-center">{{ $scara->observatii }}</td>                            
                              <td class="text-center">{{ $scara->ap }}</td>                            
                              <td class="center action-buttons"> 
                                <a href="{{ URL::route('scara_edit', [$scara->id, $id_imobil]) }}">
                                  <i class="fa fa-pencil-square-o" title="Vizualizeaza sau modifica"></i>
                                </a>                                                                                                                   
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>                                                             
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
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.tableTools.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}     
    {{ HTML::script('assets/Editor-PHP-1.4.2/js/dataTables.editor.js') }}

    <script>
        var editor;        
 
        $(document).ready(function() {    
            $('#dataTables-incasari').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"desc"]]
            });

            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });
               
            $('#dataTables-incasari').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_scara", type: "text" },
                  { sSelector: "#_col_observatii", type: "text" },
                  { sSelector: "#_col_ap", type: "select" },                
                ]
            }); 

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id'); 
                var url_delete = "{{ URL::route('incasare_factura_delete') }}";               
                bootbox.confirm({
                    title: "Sunteti sigur de stergerea inregistrarii?",
                    message: ' ',
                    buttons: {
                        'confirm': {
                            label: "Da, sterge!",
                            className: "btn-success"
                        },
                        'cancel': {
                            label: "Nu, renunta!",
                            className: "btn-danger"
                        }
                    },
                    callback: function(result){
                        if(result) {
                            $.ajax({
                                type: "POST",
                                url : url_delete,
                                data : {
                                    "_token": '<?= csrf_token() ?>',
                                    "id": id
                                },
                                success : function(data){
                                    $('tr[data-id='+id+']').fadeOut();
                                }
                            });
                        }
                    }
                });
            });
        });
        $('[title]:not([data-placement])').tooltip({'placement': 'top'});
    </script>
@stop