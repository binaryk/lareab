@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
    Informatii statistice @if(isset($entitate)) {{ $entitate }} @endif
     
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
                                <label class="control-label">An</label></td>
                            <td width="75%"><p id="_col_an"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar angajati</label></td>
                            <td width="75%"><p id="_col_num_angajati"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Cifra afaceri</label></td>
                            <td width="75%"><p id="_col_cifra_afaceri"></p></td>
                        </tr>                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Profit exploatare</th</label></td>
                            <td width="75%"><p id="_col_profit_exploatare"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Venituri</label></td>
                            <td width="75%"><p id="_col_venituri"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Active totale</label></td>
                            <td width="75%"><p id="_col_active_totale"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Cheltuieli cercetare</label></td>
                            <td width="75%"><p id="_col_cheltuieli_cercetare"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Informatii statistice
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('informatii_statistice_add', [$id_entitate, $entitate]) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-informatii_statistice">
                        <thead>
                          <tr>                                   
                            <th class="text-center">An</th>                      
                            <th class="text-center">Numar angajati</th>
                            <th class="text-center">Cifra afaceri</th>
                            <th class="text-center">Profit exploatare</th>
                            <th class="text-center">Venituri</th>
                            <th class="text-center">Active totale</th>
                            <th class="text-center">Cheltuieli cercetare</th>  
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tbody>                             
                          @foreach ($informatii_statistice as $informatie)
                            <tr data-id="{{ $informatie->id }}">
                              <td class="text-center">{{ $informatie->an }}</td>
                              <td class="text-center">{{ $informatie->num_angajati }}</td>
                              <td class="text-right">{{ number_format($informatie->cifra_afaceri, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($informatie->profit_exploatare, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($informatie->venituri, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($informatie->active_totale, 2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($informatie->cheltuieli_cercetare, 2, ',', '.') }}</td>

                              <td class="center action-buttons">
                                <a href="{{ URL::route('informatii_statistice_edit', [$informatie->id, $id_entitate, $entitate]) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
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
            $('#dataTables-informatii_statistice').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-informatii_statistice').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_an", type: "text" },
                  { sSelector: "#_col_num_angajati", type: "text" },             
                  { sSelector: "#_col_cifra_afaceri", type: "text" },                                         
                  { sSelector: "#_col_profit_exploatare", type: "text" },
                  { sSelector: "#_col_venituri", type: "text" },
                  { sSelector: "#_col_active_totale", type: "text" },          
                  { sSelector: "#_col_cheltuieli_cercetare", type: "text" },
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');    
                var url_delete = "{{ URL::route('entitati_publice_delete') }}";            
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