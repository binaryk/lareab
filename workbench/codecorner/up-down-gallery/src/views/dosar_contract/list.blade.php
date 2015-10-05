@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Dosar
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
                                <label class="control-label">Nume document</label></td>
                            <td width="75%"><p id="_col_nume"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Tip</label></td>
                            <td width="75%"><p id="_col_tip"></p></td>
                        </tr>                                
                        <tr>
                            <td width="25%">
                                <label class="control-label">Urcat de</label></td>
                            <td width="75%"><p id="_col_utilizator"></p></td>
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
                    Lista de documente asociata contractului actual
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('document_upload', $contract[0]->id) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-documente">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nr.Ord</th>                      
                            <th class="text-center">Nume document</th>
                            <th class="text-center">Tip</th>
                            <th class="text-center">Marime</th>
                            <th class="text-center">Urcat de</th>
                            <th class="text-center">Observatii</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Nr.Ord</th>                      
                            <th class="text-center">Nume document</th>
                            <th class="text-center">Tip</th>
                            <th class="text-center">Marime</th>
                            <th class="text-center">Urcat de</th>
                            <th class="text-center">Observatii</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($documente as $key => $document)
                            <tr data-id="{{ $document->id_file }}">
                              <td class="text-center">{{ $key + 1 }}</td>
                              <td class="text-left">{{ $document->filename }}</td>
                              <td class="text-center">{{ $document->filetype }}</td>
                              <td class="text-right" title="{{ number_format($document->size / 1024, 2, ',', '.') }} Kb">{{ number_format($document->size / 1024 / 1024, 2, ',', '.') }} Mb</td>
                              <td class="text-left">{{ $document->utilizator }}</td>
                              <td title="{{$document->observatii}}" class="text-left">
                                  {{ substr($document->observatii, 0, 40) . " ... " }}
                              </td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('document_download', [$document->filename, $document->guid, $contract[0]->id]) }}">
                                  <i class="fa fa-download" 
                                  title="Descarca document"></i>
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
            $('#dataTables-documente').dataTable({
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
                  { sSelector: "#_col_nume", type: "text" },
                  { sSelector: "#_col_tip", type: "text" },             
                  { sSelector: "#_col_utilizator", type: "text" },
                  { sSelector: "#_col_observatii", type: "text" },        
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('document_delete') }}";              
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
                                    "IdObiectiv": id
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


