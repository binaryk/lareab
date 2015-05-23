@extends('layouts.master')

@section('title')
    Imobile
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
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Regiune</label></td>
                            <td width="75%"><p id="_col_regiune"></p></td>
                        </tr>                                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Judet</label></td>
                            <td width="75%"><p id="_col_judet"></p></td>
                        </tr>                                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Localitate</label></td>
                            <td width="75%"><p id="_col_localitate"></p></td>
                        </tr>                                                                        
                        <tr>
                            <td width="25%">
                                <label class="control-label">Lot</label></td>
                            <td width="75%"><p id="_col_lot"></p></td>
                        </tr>                                                                                                       
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar lot</label></td>
                            <td width="75%"><p id="_col_numar_lot"></p></td>
                        </tr>                                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar apartamente</label></td>
                            <td width="75%"><p id="_col_numar_apartamente"></p></td>
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
                    Lista imobile
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('imobil_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-incasari">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Adresa</th>                      
                            <th class="text-center">Regiune</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Lot</th>
                            <th class="text-center">Numar lot</th>
                            <th class="text-center">Numar apartamente</th>
                            <th class="text-center">Observatii</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Adresa</th>                      
                            <th class="text-center">Regiune</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Lot</th>
                            <th class="text-center">Numar lot</th>
                            <th class="text-center">Numar apartamente</th>
                            <th class="text-center">Observatii</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($imobile as $imobil)
                            <tr data-id="{{ $imobil->id_imobil }}">                              
                              <td class="text-left">{{ $imobil->adresa }}</td>
                              <td class="text-left">{{ $imobil->regiune }}</td>
                              <td class="text-left">{{ $imobil->judet }}</td>
                              <td class="text-left">{{ $imobil->localitate }}</td>
                              <td class="text-center">{{ $imobil->lot }}</td>
                              <td class="text-center">{{ $imobil->numar_lot }}</td>
                              <td class="text-center">{{ $imobil->numar_apartamente }}</td>
                              <td class="text-left">{{ $imobil->observatii }}</td>
                                {{ substr($imobil->observatii, 0, 40) . " ... " }}
                              </td>                              
                              <td class="center action-buttons">           
                                <a href="{{ URL::route('imobil_edit', $imobil->id_imobil) }}">                                
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>
                                <a href="#"><i class="fa fa-trash-o" title="Asociatii proprietari"></i></a>
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
            $('#dataTables-incasari').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-incasari').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_adresa", type: "text" },
                  { sSelector: "#_col_regiune", type: "text" },
                  { sSelector: "#_col_judet", type: "text" },
                  { sSelector: "#_col_localitate", type: "text" },
                  { sSelector: "#_col_lot", type: "text" },
                  { sSelector: "#_col_numar_lot", type: "text" },
                  { sSelector: "#_col_numar_apartamente", type: "text" },
                  { sSelector: "#_col_observatii", type: "text" }
                ]
            });                       

            $('.fa-trash-o').click(function(){
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
                                url : "entitati_publice/delete",
                                data : {
                                    "_token": $(this).find('input[name=_token]').val(),
                                    "id_imobil": id
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