@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Registru de intrare
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
                                <label class="control-label">Numar de inregistrare</label></td>
                            <td width="75%"><p id="_col_numar_inregistrare"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Data inregistrare</label></td>
                            <td width="75%"><p id="_col_data_inregistrare"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Expeditor</label></td>
                            <td width="75%"><p id="_col_expeditor"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar de inregistrare expeditor</label></td>
                            <td width="75%"><p id="_col_numar_inregistrare_expeditor"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar anexe</label></td>
                            <td width="75%"><p id="_col_numar_anexe"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Continut</label></td>
                            <td width="75%"><p id="_col_continut"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Destinatar</label></td>
                            <td width="75%"><p id="_col_destinatar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Observatii</label></td>
                            <td width="75%"><p id="_col_observatii"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                   Registru de intrare al documentelor 
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::to('registru_intrare_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-registru-intrare">
                           <thead>
                               <tr>                                   
                                   <th class="text-center">Nr. inreg.</th>
                                   <th class="text-center">Data</th>
                                   <th>Expeditor</th>
                                   <th class="text-center">Nr.inreg. expeditor</th>
                                   <th class="text-center">Nr. anexe</th>
                                   <th class="text-center">Continut</th>
                                   <th class="text-center">Destinatar</th>
                                   <th class="text-center">Observatii</th>
                               </tr>
                           </thead>
                            <tfoot>
                               <tr>                                   
                                   <th class="text-center">Nr. inreg.</th>
                                   <th class="text-center">Data</th>
                                   <th>Expeditor</th>
                                   <th class="text-center">Nr.inreg. expeditor</th>
                                   <th class="text-center">Nr. anexe</th>
                                   <th class="text-center">Continut</th>
                                   <th class="text-center">Destinatar</th>
                                   <th class="text-center">Observatii</th>
                               </tr>
                           </tfoot>
                           <tbody>                             
                              @foreach ($intrari as $intrare)
                                <tr>                                          
                                    <td class="text-center">{{ $intrare->numar_inregistrare }}</td>
                                    <td class="text-center">{{ $intrare->data_inregistrare }}</td>
                                    <td>{{ $intrare->expeditor }}</td>
                                    <td class="text-center">{{ $intrare->numar_inregistrare_expeditor }}</td>
                                    <td class="text-center">{{ $intrare->numar_anexe }}</td>
                                    <td>{{ $intrare->continut }}</td>
                                    <td>{{ $intrare->destinatar }}</td>
                                    <td title="{{$intrare->observatii}}">
                                        {{ substr($intrare->observatii, 0, 40) . " ... " }}
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
            $('#dataTables-registru-intrare').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-registru-intrare').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_numar_inregistrare", type: "text" },
                  { sSelector: "#_col_data_inregistrare", type: "date" },             
                  { sSelector: "#_col_expeditor", type: "text" },             
                  { sSelector: "#_col_numar_inregistrare_expeditor", type: "text" },             
                  { sSelector: "#_col_numar_anexe", type: "number" },
                  { sSelector: "#_col_continut", type: "text" },
                  { sSelector: "#_col_destinatar", type: "text" },          
                  { sSelector: "#_col_observatii", type: "text" }         
                ]
            });      
        });
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        $('[title]:not([data-placement])').tooltip({'placement': 'top'});
    </script>
@stop