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
                                <label class="control-label">numar</label></td>
                            <td width="75%"><p id="_col_numar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Data semnarii</label></td>
                            <td width="75%"><p id="_col_data_semnarii"></p></td>
                        </tr>                                
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa"></p></td>
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
                    Lista obiective
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="
                          @if($contract === null)
                            {{ URL::route('obiectiv_add') }}
                          @else
                            {{ URL::route('obiectiv_add_contract', $contract[0]->id_contract) }}
                          @endif"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-obiective">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Numar</th>                      
                            <th class="text-center">Data semnarii</th>
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Contract</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Numar</th>                      
                            <th class="text-center">Data semnarii</th>
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Contract</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($obiective as $obiectiv)
                            <tr data-id="{{ $obiectiv->id_obiectiv }}">
                              <td class="text-center">{{ $obiectiv->numar_obiectiv }}</td>
                              <td class="text-center">{{ $obiectiv->data_semnare_obiectiv }}</td>
                              <td class="text-left">{{ $obiectiv->denumire_obiectiv }}</td>
                              <td class="text-left">{{ $obiectiv->adresa_obiectiv }}</td>                              
                              <td class="text-left">
                                  @if(isset($obiectiv->numar_contract))
                                    {{ $obiectiv->numar_contract .'/'. $obiectiv->data_semnare_contract }}
                                  @endif
                              </td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('obiectiv_edit', $obiectiv->id_obiectiv) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="{{ URL::route('etapa_list', $obiectiv->id_obiectiv) }}">
                                  <i class="fa fa-calendar" 
                                  title="Etape si termene"></i>
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
            $('#dataTables-obiective').dataTable({
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
            var table = $('#dataTables-obiective').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_numar", type: "text" },
                  { sSelector: "#_col_data_semnarii", type: "text" },             
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_adresa", type: "text" },
                  { sSelector: "#_col_contract", type: "text" },          
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
                                    "id_obiectiv": id
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


