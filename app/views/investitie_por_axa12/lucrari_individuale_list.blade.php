@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
    {{ HTML::style('Editor-PHP-1.4.2/css/dataTables.editor.css') }}
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}
@stop

@section('title')
    <p>Centralizatorul situațiilor de lucrari și repartizarea cheltuielilor pe surse de finanțare</p> 
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
                                <label class="control-label">Nr.apartament</label></td>
                            <td width="75%"><p id="_col_nr_ap"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nume</label></td>
                            <td width="75%"><p id="_col_nume"></p></td>
                        </tr>   
						<tr>
                            <td width="25%">
                                <label class="control-label">Etaj</label></td>
                            <td width="75%"><p id="_col_etaj"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">Suprafata utila</label></td>
                            <td width="75%"><p id="_col_suprafata_utila"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">%Cota parte</label></td>
                            <td width="75%"><p id="_col_cota_parte"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nr.membri familie</label></td>
                            <td width="75%"><p id="_col_nr_membri"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">Destinatie spatiu</label></td>
                            <td width="75%"><p id="_col_destinatie"></p></td>
                        </tr> 
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar cadastral</label></td>
                            <td width="75%"><p id="_col_nr_cadastral"></p></td>
                        </tr>                                                                                                                                           
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Locatarii imobilului @if(isset($imobil)) {{ $imobil->adresa }}@endif
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-locatari">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nr.ap.</th>                      
                            <th class="text-center">Nume proprietar</th>
                            <th class="text-center">Etaj</th>
                            <th class="text-center">Suprafata utila</th>
                            <th class="text-center">%Cota parte</th>
                            <th class="text-center">Nr.membri</th>
                            <th class="text-center">Destinatie spatiu</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Nr.ap.</th>                      
                            <th class="text-center">Nume proprietar</th>
                            <th class="text-center">Etaj</th>
                            <th class="text-center">Suprafata utila</th>
                            <th class="text-center">%Cota parte</th>
                            <th class="text-center">Nr.membri</th>
                            <th class="text-center">Destinatie spatiu</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($locatari as $locatar)
                            <tr data-id="{{ $locatar->id }}">                              
                              <td class="text-center">{{ $locatar->nr_apartament }}</td>                            
                              <td class="text-left">{{ $locatar->nume }}</td>                            
                              <td class="text-center">{{ $locatar->etaj }}</td>
                              <td class="text-right">{{ number_format($locatar->suprafata_utila, 2, ',', '.') }}</td>
                              <td class="text-right">@if($suprafata_utila_imobil > 0) {{ number_format($locatar->suprafata_utila * 100.0 / $suprafata_utila_imobil, 2, ',', '.') }} &#37; @endif</td>
                              <td class="text-center">{{ $locatar->nr_membri_familie }}</td>
                              <td class="text-center">{{ $locatar->destinatie_spatiu }}</td>
                              
                              <td class="center action-buttons"> 
                                <a href="{{ URL::route('locatar_edit', [$locatar->id, $imobil->id]) }}">
                                  <i class="fa fa-pencil-square-o" title="Vizualizeaza sau modifica"></i>
                                </a>                                                                                                                   
                                <a href="#"><i class="fa fa-calculator" title="Calcul devize"></i></a>
                                <a href="#"><i class="fa fa-random" title="Repartizare cheltuieli"></i></a>
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
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.tableTools.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}     
    {{ HTML::script('assets/Editor-PHP-1.4.2/js/dataTables.editor.js') }}

    <script>
        var editor;        
 
        $(document).ready(function() {    
            $('#dataTables-locatari').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"asc"]]
            });

            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });
               
            $('#dataTables-locatari').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_nr_ap", type: "text" },
                  { sSelector: "#_col_nume", type: "text" },
                  { sSelector: "#_col_etaj", type: "text" },  
                  { sSelector: "#_col_suprafata_utila", type: "text" },
                  { sSelector: "#_col_cota_parte", type: "text" },
                  { sSelector: "#_col_nr_membri", type: "text" },
                  { sSelector: "#_col_destinatie", type: "select" }
                ]
            }); 

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id'); 
                var url_delete = "{{ URL::route('locatar_delete') }}";               
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