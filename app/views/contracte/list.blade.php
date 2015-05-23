@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}    
@stop

@section('title')
    Contracte
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
                                <label class="control-label">Numar</label></td>
                            <td width="75%"><p id="_col_numar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Data semnarii</label></td>
                            <td width="75%"><p id="_col_data_semnarii"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Tip contract</label></td>
                            <td width="75%"><p id="_col_tip_contract"></p></td>
                        </tr>                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Stadiu contract</label></td>
                            <td width="75%"><p id="_col_stadiu_contract"></p></td>
                        </tr>                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Valoare fara TVA</label></td>
                            <td width="75%"><p id="_col_valoare_fara_tva"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">%TVA</label></td>
                            <td width="75%"><p id="_col_procent_tva"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Valoare TVA</label></td>
                            <td width="75%"><p id="_col_valoare_tva"></p></td>
                        </tr>                     
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Contracte cu (C)lientii si (F)urnizorii
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('contract_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-contracte">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Numar</th>                      
                            <th class="text-center">Data semnarii</th>
                            <th class="text-center">Tip contract</th>
                            <th class="text-center">Stadiu</th>
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Valoare fara TVA</th>
                            <th class="text-center">%TVA</th>
                            <th class="text-center">Valoare TVA</th>  
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Numar</th>                      
                            <th class="text-center">Data semnarii</th>
                            <th class="text-center">Tip contract</th>
                            <th class="text-center">Stadiu</th>
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Valoare fara TVA</th>
                            <th class="text-center">%TVA</th>
                            <th class="text-center">Valoare TVA</th>  
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($contracte as $contract)
                            <tr data-id="{{ $contract->id_contract }}">
                              <td class="text-center">{{ $contract->numar }} @if($contract->id_tip_nivel_contractare == 1) (F) @elseif ($contract->id_tip_nivel_contractare == 2) (C) @endif</td>
                              <td class="text-center">{{ $contract->data_semnarii }}</td>
                              <td>{{ $contract->tip_contract }}</td>
                              <td>{{ $contract->stadiu_contract }}</td>
                              <td class="text-left">{{ $contract->denumire_contract }}</td>
                              <td class="text-right">{{ number_format($contract->valoare, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($contract->procent_tva, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($contract->valoare_tva, 2, ',', '.') }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('contract_edit', $contract->id_contract) }}">
                                  <i class="fa fa-pencil-square-o" title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="{{ URL::route('obiectiv_list_contract', $contract->id_contract) }}">
                                  <i class="fa fa-building" title="Obiective contract"></i>
                                </a>                                
                                <a href="{{ URL::route('contract_optiuni', $contract->id_contract) }}">
                                  <i class="fa fa-arrows-alt" title="Date contract"></i>
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
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }} 

    <script>
        $(document).ready(function() {    
            $('#dataTables-contracte').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"desc"]]
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-contracte').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_numar", type: "text" },
                  { sSelector: "#_col_data_semnarii", type: "text" },             
                  { sSelector: "#_col_tip_contract", type: "text" },
                  { sSelector: "#_col_stadiu_contract", type: "text" }, 
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_valoare_fara_tva", type: "text" },
                  { sSelector: "#_col_procent_tva", type: "text" },
                  { sSelector: "#_col_valoare_tva", type: "text" }, 
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('contract_delete') }}";              
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
                                    "id_contract": id
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