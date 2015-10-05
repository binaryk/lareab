@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')    
    <p>Lista livrabile asociate facturii
        @if(isset($factura->serie)) {{ $factura->serie . '/' . $factura->numar }} din data {{ $factura->data_facturare }} @endif
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
                            <td width="20%">
                                <label class="control-label">Denumire livrabil</label></td>
                            <td width="80%"><p id="_col_denumire_livrabil"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Contract</label></td>
                            <td width="80%"><p id="_col_contract"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Obiectiv</label></td>
                            <td width="80%"><p id="_col_obiectiv"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Etapa</label></td>
                            <td width="80%"><p id="_col_etapa"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Stadiu</label></td>
                            <td width="80%"><p id="_col_stadiu"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Data limita predare</label></td>
                            <td width="80%"><p id="_col_data_limita_predare"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>

           <div class="panel panel-default">
               <div class="panel-heading">
                   Lista livrabile nefacturate
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                     
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                        <div class="form-group">                        
                       </div>
                       <table class="table table-striped table-bordered table-hover" id="dataTables-livrabile">
                           <thead>                                                       
                               <tr>                                   
                                   <th>Denumire livrabil</th>
                                   <th>Contract</th>
                                   <th>Obiectiv</th>
                                   <th>Etapa</th>
                                   <th>Stadiu</th>                                
                                   <th>Data limita predare</th>
                                   <th>Ore lucrate</th>
                               </tr>
                           </thead>
                           <tfoot>
                               <tr>                                   
                                   <th>Denumire livrabil</th>
                                   <th>Contract</th>
                                   <th>Obiectiv</th>
                                   <th>Etapa</th>
                                   <th>Stadiu</th>
                                   <th>Data limita predare</th>                                
                                   <th>Ore lucrate</th>
                               </tr>
                           </tfoot>
                           <tbody>
                                @foreach ($livrabile as $livrabil)
                                    <tr>
                                        <td>{{ $livrabil->livrabil }}</td>   
                                        <td>{{ $livrabil->contract }}</td>
                                        <td><a href="{{ URL::route('obiectiv_single', $livrabil->id_obiectiv) }}">{{ $livrabil->obiectiv }}</a></td>
                                        <td class="text-center">{{ $livrabil->id_etapa }}</td>                                        
                                        <td class="text-center"><a href="{{ URL::route('stadiu_livrabil', $livrabil->id_livrabil_pentru_facturat) }}">{{ $livrabil->stadiu }}</td>
                                        <td class="text-center">{{ $livrabil->data_limita }}</td>
                                        <td class="text-right">{{ $livrabil->ore_lucrate }}</td>                                    
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
        $(document).ready(function() 
        {         
            $('#dataTables-livrabile').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
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
                  { sSelector: "#_col_contract", type: "text" },             
                  { sSelector: "#_col_obiectiv", type: "text" },             
                  { sSelector: "#_col_etapa", type: "number" },
                  { sSelector: "#_col_stadiu", type: "text" },
                  { sSelector: "#_col_data_limita_predare", type: "date" },          
                ]
            });        
        });
    </script>
@stop