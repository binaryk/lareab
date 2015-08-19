@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }} 
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}   
@stop

@section('title')
    Serii de facturare
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
                                <label class="control-label">Denumire entitate</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Serie</label></td>
                            <td width="75%"><p id="_col_serie"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar</label></td>
                            <td width="75%"><p id="_col_numar"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Serii de facturare ale firmelor ce apartin grupului
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        @if (Entrust::can('manage_serie_facturare') || Entrust::can('administrare_platforma'))
                          <a href="{{ URL::route('serie_facturare_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                        @endif
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-serii_facturare">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire entitate</th>                      
                            <th class="text-center">Serie</th>
                            <th class="text-center">Numar</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Denumire entitate</th>                      
                            <th class="text-center">Serie</th>
                            <th class="text-center">Numar</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($serii as $serie)
                            <tr data-id="{{ $serie->id }}">
                              <td class="text-left">{{ $serie->entitate }}</td>
                              <td class="text-center">{{ $serie->serie }}</td>
                              <td class="text-center">{{ $serie->numar }}</td>
                                                         
                              <td class="center action-buttons">
                                @if (Entrust::can('manage_serie_facturare') || Entrust::can('administrare_platforma'))
                                  <a href="{{ URL::route('serie_facturare_edit', $serie->id) }}">
                                    <i class="fa fa-pencil-square-o" 
                                    title="Vizualizeaza sau modifica"></i>
                                  </a>
                                @endif
                                @if (Entrust::can('manage_serie_facturare') || Entrust::can('administrare_platforma'))
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
            $('#dataTables-serii_facturare').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-serii_facturare').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_serie", type: "text" },             
                  { sSelector: "#_col_numar", type: "text" }
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var url_delete = "{{ URL::route('serie_facturare_delete') }}";  
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