@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}    
@stop

@section('title')
    Obiective
    @if ($contract !== null) 
      contract {{ $contract[0]->numar }} din {{ $contract[0]->data_semnarii }}
    @endif
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
                                <label class="control-label">Numar curent</label></td>
                            <td width="75%"><p id="_col_numar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire obiectiv</label></td>
                            <td width="75%"><p id="_col_denumire_obiectiv"></p></td>
                        </tr>                                
                        <tr>
                            <td width="25%">
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Contract</label></td>
                            <td width="75%"><p id="_col_num_contract"></p></td>
                        </tr>                   
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista obiective
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        @if (Entrust::can('add_obiectiv'))
                        <a href="
                          @if($contract === null)
                            {{ URL::route('obiectiv_add') }}
                          @else
                            {{ URL::route('obiectiv_add_contract', $contract[0]->id) }}
                          @endif"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                        @endif
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-obiective">
                        <thead>
                          <tr>
                            <th class="hidden">Order</th>                             
                            <th class="text-center">Nr.Crt.</th>                             
                            <th class="text-center">Denumire obiectiv</th>                      
                            <th class="text-center">Adresa</th>                            
                            <th class="text-center">Contract</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                
                            <th class="hidden">Order</th>                               
                            <th class="text-center">Nr.Crt.</th>                             
                            <th class="text-center">Denumire obiectiv</th>                      
                            <th class="text-center">Adresa</th>                            
                            <th class="text-center">Contract</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($obiective as $obiectiv)
                            <tr data-id="{{ $obiectiv->id }}">                            
                              <td class="hidden">{{ $obiectiv->ord_data_semnare_contract }}</td>                              
                              <td class="text-center">{{ $obiectiv->numar_obiectiv }}</td>                              
                              <td class="text-left">{{ $obiectiv->denumire_obiectiv }}</td>
                              <td class="text-left">{{ $obiectiv->adresa_obiectiv }}</td>                              
                              <td class="text-left">
                                  @if(isset($obiectiv->numar_contract))
                                    {{ '(' 
                                    . $obiectiv->numar_contract 
                                    .'/'
                                    . $obiectiv->data_semnare_contract
                                    . ') ' 
                                    . $obiectiv->denumire_contract }}
                                  @endif
                              </td>
                              <td class="center action-buttons">
                                @if (Entrust::can('edit_obiectiv'))
                                <a href="{{ URL::route('obiectiv_edit', $obiectiv->id) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                @endif
                                <a href="{{ URL::route('etapa_list', $obiectiv->id) }}">
                                  <i class="fa fa-calendar" 
                                  title="Etape si termene"></i>
                                </a>
                                @if (Entrust::can('delete_obiectiv'))                                
                                  <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>
                                @endif                                  
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
            $('#dataTables-obiective').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"desc"],[1,"asc"]]
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-obiective').dataTable().columnFilter({
              aoColumns: [ 
                  null,
                  { sSelector: "#_col_numar", type: "text" },
                  { sSelector: "#_col_denumire_obiectiv", type: "text" },
                  { sSelector: "#_col_adresa", type: "text" },             
                  { sSelector: "#_col_num_contract", type: "select" },
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('obiectiv_delete') }}";              
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


