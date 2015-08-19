@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Lista livrabile
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
                            <td width="20%">
                                <label class="control-label">Denumire livrabil</label></td>
                            <td width="80%"><p id="_col_denumire_livrabil"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Stadiu</label></td>
                            <td width="80%"><p id="_col_stadiu"></p></td>
                        </tr>                      
                    </table>
                </div>                        
            </div>

           <div class="panel panel-default">
               <div class="panel-heading">
                    Lista livrabile asociate etapei curente
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('livrabile_etapa_add', $id_etapa) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>                   
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                        <div class="form-group">                        
                       </div>
                       <table class="table table-striped table-bordered table-hover" id="dataTables-livrabile">
                           <thead>                                                       
                               <tr>                                   
                                   <th class="text-center">Denumire livrabil</th>
                                   @if (Entrust::can('manage_finance')) <th class="text-center">Pret fara TVA</th>@endif
                                   <th class="text-center">Stadiu</th>
                                   <th class="text-center">Actiuni</th>
                               </tr>
                           </thead>
                           <tfoot>
                               <tr>                                   
                                   <th class="text-center">Denumire livrabil</th>
                                   @if (Entrust::can('manage_finance'))<th class="text-center">Pret fara TVA</th>@endif
                                   <th class="text-center">Stadiu</th>
                                   <th class="text-center">Actiuni</th>
                               </tr>
                           </tfoot>
                           <tbody>
                                @foreach ($livrabile as $livrabil)
                                    <tr data-id="{{ $livrabil->id }}">
                                        <td>{{ $livrabil->livrabil }}</td> 
                                        @if (Entrust::can('manage_finance'))                                                                                 
                                          <td class="text-right">{{ number_format($livrabil->pret_fara_tva, 2, ',', '.') }}</td>
                                        @endif
                                        <td class="text-center">{{ $livrabil->stadiu }}</td>
                                        <td class="center action-buttons">                                                            
                                          @if (intval($livrabil->id_factura) == 0)
                                            <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>
                                          @endif                                            
                                        </td>                                         
                                    </tr>
                                @endforeach
                           </tbody>
                       </table>
                       <label class="label label-danger">*Un livrabil facturat nu se mai poate sterge</label>
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
        $(document).ready(function() 
        {         
            $('#dataTables-livrabile').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"asc"]]
            });
            
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });

            var table = $('#dataTables-livrabile').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire_livrabil", type: "text" },                      
                  { sSelector: "#_col_stadiu", type: "select" },           
                ]
            });                  

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('livrabile_etapa_delete') }}";              
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
    </script>
@stop