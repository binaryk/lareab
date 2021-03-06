@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Facturi primite de firmele din grup
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
                                <label class="control-label">Factura</label></td>
                            <td width="75%"><p id="_col_serie_numar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Data facturare</label></td>
                            <td width="75%"><p id="_col_data_facturare"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Scadenta</label></td>
                            <td width="75%"><p id="_col_scadenta"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Zile scadenta</label></td>
                            <td width="75%"><p id="_col_zile_scadenta"></p></td>
                        </tr> 
                        <tr>
                            <td width="25%">
                                <label class="control-label">Total desfasurator fara TVA</label></td>
                            <td width="75%"><p id="_col_total_desf"></p></td>
                        </tr>                                            
                        <tr>
                            <td width="25%">
                                <label class="control-label">Total fara TVA</label></td>
                            <td width="75%"><p id="_col_total"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Platit</label></td>
                            <td width="75%"><p id="_col_platit"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Beneficiar</label></td>
                            <td width="75%"><p id="_col_beneficiar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Furnizor</label></td>
                            <td width="75%"><p id="_col_furnizor"></p></td>
                        </tr>                       
                        <tr>
                            <td width="25%">
                                <label class="control-label">Contract</label></td>
                            <td width="75%"><p id="_col_contract"></p></td>
                        </tr>                       
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista facturi furnizori
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-entitati_publice">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Factura</th>                      
                            <th class="text-center">Data<br>facturare</th>
                            <th class="text-center">Scadenta</th>
                            <th class="text-center">Zile<br>scadenta</th>
                            <th class="text-center">Total desf.<br>fara TVA</th>
                            <th class="text-center">Total fara<br>TVA</th>
                            <th class="text-center">Platit</th>  
                            <th class="text-center">Beneficiar</th>
                            <th class="text-center">Furnizor</th>
                            <th class="text-center">Contract</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Factura</th>
                            <th class="text-center">Data facturare</th>
                            <th class="text-center">Scadenta</th>
                            <th class="text-center">Zile scadenta</th>
                            <th class="text-center">Total desf.<br>fara TVA</th>
                            <th class="text-center">Total fara TVA</th>
                            <th class="text-center">Platit</th>  
                            <th class="text-center">Beneficiar</th>
                            <th class="text-center">Furnizor</th>  
                            <th class="text-center">Contract</th>                         
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($facturi as $factura)
                            <tr data-id="{{ $factura->id }}">                                                          
                              <td class="text-center">{{ $factura->serie . '/' . $factura->numar }}</td>
                              <td class="text-center">{{ $factura->data_facturare }}</td>
                              <td class="text-center">{{ $factura->scadenta }}</td>
                              <td class="text-center">{{ $factura->zile_scadenta }}</td>
                              <td class="text-right">{{ number_format($factura->total_desfasurator, 2, ',', '.') }}</td>
                              <td class="text-right"><a href="{{ URL::route('detalii_factura_furnizor', $factura->id) }}">{{ number_format($factura->total_detalii, 2, ',', '.') }}</a></td>
                              <td class="text-right"><a href="{{ URL::route('plati_factura', $factura->id) }}">{{ number_format($factura->platit, 2, ',', '.') }}</td>
                              <td>{{ $factura->beneficiar }}</td>
                              <td>{{ $factura->furnizor }}</td>
                              <td class="text-center">{{ $factura->contract }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::to('factura_furnizor_edit/'. $factura->id) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>                                                             
                                <a href="{{ URL::route('factura_furnizor_optiuni', $factura->id) }}">
                                  <i class="fa fa-arrows-alt" title="Detalii factura"></i>
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
            $('#dataTables-entitati_publice').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-entitati_publice').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_serie_numar", type: "text" },
                  { sSelector: "#_col_data_facturare", type: "text" },
                  { sSelector: "#_col_scadenta", type: "text" },             
                  { sSelector: "#_col_zile_scadenta", type: "text" },                                         
                  { sSelector: "#_col_total_desf", type: "text" },
                  { sSelector: "#_col_total", type: "text" },
                  { sSelector: "#_col_platit", type: "text" },
                  { sSelector: "#_col_beneficiar", type: "text" },          
                  { sSelector: "#_col_furnizor", type: "text" },                 
                  { sSelector: "#_col_contract", type: "text" },                 
                ]
            });                       

            $('.fa-trash-o').click(function(){
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
                                url : "factura_furnizor_delete",
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