@extends('layouts.master')

@section('title')
    Asociatii proprietari
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
                                <label class="control-label">Strada</label></td>
                            <td width="75%"><p id="_col_strada"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar</label></td>
                            <td width="75%"><p id="_col_numar"></p></td>
                        </tr>                                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Bloc</label></td>
                            <td width="75%"><p id="_col_bloc"></p></td>
                        </tr>                                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Scara</label></td>
                            <td width="75%"><p id="_col_scara"></p></td>
                        </tr>                                                                        
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>                                                                                                       
                        <tr>
                            <td width="25%">
                                <label class="control-label">Judet</label></td>
                            <td width="75%"><p id="_col_judet"></p></td>
                        </tr>                                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Localitate</label></td>
                            <td width="75%"><p id="_col_localitate"></p></td>
                        </tr>                                     
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista asociatii de proprietari
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('asociatie_proprietari_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-incasari">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                      
                            <th class="text-center">Strada</th>
                            <th class="text-center">Numar</th>
                            <th class="text-center">Bloc</th>
                            <th class="text-center">Scara</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Localitate</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Denumire</th>                      
                            <th class="text-center">Strada</th>
                            <th class="text-center">Numar</th>
                            <th class="text-center">Bloc</th>
                            <th class="text-center">Scara</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Localitate</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($asociatii as $asociatie)
                            <tr data-id="{{ $asociatie->id_asociatie }}">                              
                              <td class="text-left">{{ $asociatie->denumire }}</td>
                              <td class="text-left">{{ $asociatie->strada }}</td>
                              <td class="text-left">{{ $asociatie->numar }}</td>
                              <td class="text-left">{{ $asociatie->bloc }}</td>
                              <td class="text-left">{{ $asociatie->scara }}</td>
                              <td class="text-left">{{ $asociatie->judet }}</td>
                              <td class="text-left">{{ $asociatie->localitate }}</td>
                              <td class="center action-buttons">                             
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
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }} 

    <script>
        $(document).ready(function() {    
            $('#dataTables-incasari').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-incasari').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_strada", type: "text" },
                  { sSelector: "#_col_numar", type: "text" },
                  { sSelector: "#_col_bloc", type: "text" },
                  { sSelector: "#_col_scara", type: "text" },
                  { sSelector: "#_col_judet", type: "text" },
                  { sSelector: "#_col_localitate", type: "text" }
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var url_delete = "{{ URL::route('firme_organizatie_delete') }}";
                var id = $(this).closest('tr').data('id');                
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
                                    "id_asociatie": id
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