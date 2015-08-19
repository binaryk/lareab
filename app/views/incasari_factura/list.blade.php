@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
    {{ HTML::style('Editor-PHP-1.4.2/css/dataTables.editor.css') }}
@stop

@section('title')
    <p>Incasari factura
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
                            <td width="25%">
                                <label class="control-label">Data incasarii</label></td>
                            <td width="75%"><p id="_col_data_incasarii"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Valoare incasata</label></td>
                            <td width="75%"><p id="_col_valoare_incasata"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Valoare virata in contul de garantie</label></td>
                            <td width="75%"><p id="_col_valoare_virata_cont_garantie"></p></td>
                        </tr>                                     
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Incasari asociate facturii curente
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                              
                        <a href="{{ URL::route('incasare_factura_add', [$factura->id]) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-incasari">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Data incasarii</th>                      
                            <th class="text-center">Valoare incasata</th>
                            <th class="text-center">Valoare virata in contul de garantie</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Data incasarii</th>                      
                            <th class="text-center">Valoare incasata</th>
                            <th class="text-center">Valoare virata in contul de garantie</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($incasari as $incasare)
                            <tr data-id="{{ $incasare->id_incasare }}">                              
                              <td class="text-center">{{ $incasare->data_incasarii }}</td>                            
                              <td class="text-right">{{ number_format($incasare->valoare_incasata, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($incasare->valoare_virata_CG, 2, ',', '.') }}</td>
                              <td class="center action-buttons"> 
                                <a href="{{ URL::route('incasare_factura_edit', $incasare->id_incasare) }}">
                                  <i class="fa fa-pencil-square-o" title="Vizualizeaza sau modifica"></i>
                                </a>                                                          
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>                                                             
                              </td>                                  
                            </tr>
                          @endforeach                             
                        </tbody>
                      </table>
                      <div align="right" class="alert alert-warning">
                        <table width="100%">
                          <tbody>
                            <tr>
                              <td width="90%" align="right">
                                <h5 style="font-weight:bold;margin-top:6px;" class="media-heading">Total factura:</h5>
                              </td>
                              <td width="10%" align="right"><span style="font-weight:bold;" class="media-heading" id="total_factura">{{ number_format($factura->total, 2, ',', '.') }}</span></td>
                            </tr>                                                                       
                            <tr>
                              <td width="90%" align="right">
                                <h5 style="margin-top:6px;" class="media-heading">Total incasat:</h5>
                              </td>
                              <td width="10%" align="right"><span class="media-heading" id="total_incasat">0,00</span></td>
                            </tr>
                            <tr>
                              <td width="90%" align="right">
                                <h5 style="margin-top:6px;" class="media-heading">Total virat in contul de garantie:</h5>
                              </td>
                              <td width="10%" align="right"><span class="media-heading" id="total_virat">0,00</span></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
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
                  { sSelector: "#_col_data_incasarii", type: "text" },
                  { sSelector: "#_col_valoare_incasata", type: "text" },
                  { sSelector: "#_col_valoare_virata_cont_garantie", type: "text" },                
                ]
            }); 
            calculeaza_total();
            editor = new $.fn.dataTable.Editor( {
                //ajax: "../php/staff.php",
                table: "#dataTables-incasari",
                fields: [{
                        name: 1
                    }, {
                        name: 2
                    }, {
                        name: 3
                    }]
            });
            /*$('#dataTables-incasari').on( 'click', 'tbody td:not(:last-child)', function (e) {              
              editor.inline( this );            
            });*/

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
                                    "_token": $(this).find('input[name=_token]').val(),
                                    "id_incasare": id
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

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        $('[title]:not([data-placement])').tooltip({'placement': 'top'});
        $(function() {
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"
            });         
        });

        var calculeaza_total = function() {
            var total_incasat = 0;
            var total_virat = 0;
            var rows = $("#dataTables-incasari").dataTable().fnGetNodes();
            for(var i = 0; i < rows.length; i++)
            {
                var tmp = $(rows[i]).find("td:eq(1)").html();
                try{
                  tmp = parseFloat(tmp.replace('.','').replace(',','.'));
                  total_incasat += tmp;              
                }
                catch (err){}
                tmp = $(rows[i]).find("td:eq(2)").html();
                try{
                  tmp = parseFloat(tmp.replace('.','').replace(',','.'));
                  total_virat += tmp;              
                }
                catch (err){}                           
            }            
  

            $('#total_incasat').text(formato_numero(total_incasat.toString(), 2, ',', '.'));
            $('#total_virat').text(formato_numero(total_virat.toString(), 2, ',', '.'));
            /*if (total_incasat === total_virat)
            {
                $("#diferenta").hide();
            }
            else
            {
                $("#diferenta").show();  
            }*/
        }

    </script>
@stop