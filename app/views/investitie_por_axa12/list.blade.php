@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}    
@stop

@section('title')
    Lista investitiilor de reabilitare termica
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
                                <label class="control-label">Denumire investitie</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Localitate</label></td>
                            <td width="75%"><p id="_col_localitate"></p></td>
                        </tr>                                
                        <tr>
                            <td width="25%">
                                <label class="control-label">Judet</label></td>
                            <td width="75%"><p id="_col_judet"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa"></p></td>
                        </tr>                   
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista investitii POR (Axa 1.2 Sprijinirea investiţiilor în eficienţa energetică a blocurilor de locuinţe)
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        @if (Entrust::can('add_por_axa12'))
                          <a href="{{ URL::route('investitie_por_axa12_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                        @endif
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-investitie">
                        <thead>
                          <tr>
                            <th class="hidden">Order</th>                                                          
                            <th class="text-center">Denumire investitie</th>                      
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Adresa</th>                                                        
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                
                            <th class="hidden">Order</th>                               
                            <th class="text-center">Denumire investitie</th>                      
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Adresa</th>                                                        
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($investitii as $investitie)
                            <tr data-id="{{ $investitie->id }}">                            
                              <td class="hidden">{{ $investitie->id }}</td>                              
                              <td class="text-left">{{ $investitie->denumire }}</td>                              
                              <td class="text-center">{{ $investitie->localitate }}</td>
                              <td class="text-center">{{ $investitie->judet }}</td>
                              <td class="text-left">{{ $investitie->adresa }}</td>                             
                              <td class="center action-buttons">
                                @if (Entrust::can('edit_por_axa12'))
                                <a href="{{ URL::route('investitie_por_axa12_edit', $investitie->id) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="{{ URL::route('investitie_por_axa12_optiuni', [$investitie->id, $investitie->id_imobil]) }}">
                                  <i class="fa fa-arrows-alt" title="Date investitie"></i>
                                </a>
                                @endif
                                @if (Entrust::can('delete_por_axa12'))                                
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
            $('#dataTables-investitii').dataTable({
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
            var table = $('#dataTables-investitii').dataTable().columnFilter({
              aoColumns: [ 
                  null,
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_localitate", type: "text" },
                  { sSelector: "#_col_judet", type: "text" },             
                  { sSelector: "#_col_adresa", type: "select" },
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('investitie_por_axa12_delete') }}";              
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


