@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Etape si termene pe etape 
    @if ($obiectiv !== null) 
      ale obiectivului {{ $obiectiv[0]->numar }} din {{ $obiectiv[0]->data_semnare }}
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
                                <label class="control-label">Numar etapa</label></td>
                            <td width="75%"><p id="_col_numar"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Data inceperii</label></td>
                            <td width="75%"><p id="_col_data_incepere"></p></td>
                        </tr>                                
                        <tr>
                            <td width="25%">
                                <label class="control-label">Termen predare</label></td>
                            <td width="75%"><p id="_col_termen_predare"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Instiintare contractor</label></td>
                            <td width="75%"><p id="_col_instiintare"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista etape
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('etapa_add', $obiectiv[0]->id_obiectiv) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-etape">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Numar etapa</th>                      
                            <th class="text-center">Data inceperii</th>
                            <th class="text-center">Termen predare</th>
                            <th class="text-center">Necesita ordin de <br>incepere de la contractor</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Numar etapa</th>                      
                            <th class="text-center">Data inceperii</th>
                            <th class="text-center">Termen predare</th>
                            <th class="text-center">Necesita ordin de <br>incepere de la contractor</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($etape as $etapa)
                            <tr data-id="{{ $etapa->id_etapa }}">
                              <td class="text-center">{{ $etapa->nr_etapa }}</td>
                              <td class="text-center">{{ $etapa->data_start }}</td>
                              <td class="text-center">{{ $etapa->termen_predare }}</td>                              
                              <td class="text-center">{{ $etapa->instiintare_contractor }}</td>                                                         
                              <td class="center action-buttons">
                                <a href="{{ URL::route('etapa_edit', $etapa->id_etapa) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="{{ URL::route('livrabile_etapa_list', $etapa->id_etapa) }}">
                                  <i class="fa fa-archive" 
                                  title="Livrabile"></i>
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
    

    <script>
        $(document).ready(function() {    
            $('#dataTables-etape').dataTable({
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
            var table = $('#dataTables-etape').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_numar", type: "text" },
                  { sSelector: "#_col_data_incepere", type: "text" },             
                  { sSelector: "#_col_termen_predare", type: "text" },
                  { sSelector: "#_col_instiintare", type: "select" },                 
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('etapa_delete') }}";              
                bootbox.confirm({
                    title: 'Sterge inregistrare ...',
                    message: 'Sunteti sigur de stergerea inregistrarii?',
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
                                    "id_etapa": id
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
    </script>
@stop


