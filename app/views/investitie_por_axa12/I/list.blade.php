@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
  Obiecte investitie
@stop

@section('content')
    <div class="row">
        <div class="col-lg-5">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <a href="#" class="pull-right btn-primary" id="btn_show_hide_obiect" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </a>                      
                </div>
                                                                        
                <div id="div_cautare_obiect" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="35%">
                                <label class="control-label">Denumire obiect investitie</label></td>
                            <td width="65%"><p id="_col_denumire"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista obiecte investitie           
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                     
                      <a href="{{ URL::route('investitie_por_axa12_obiect_add', $id_investitie) }}">                       
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <span class="hidden">
                 {{ $selected_object = -1; $first_time = true; $denumire_selected_object = ""; }}
               </span>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-obiect">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire obiect investitie</th>                   
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Denumire obiect investitie</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($obiecte as $obiect)
                            <span class="hidden">
                              @if ($first_time)
                                {{ $selected_object = $obiect->id; }}
                                {{ $denumire_selected_object = $obiect->denumire; }}
                                {{ $first_time = false; }}
                              @endif
                            </span>
                            <tr data-id="{{ $obiect->id }}">         
                              <td class="text-left">{{ $obiect->denumire }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('investitie_por_axa12_obiect_edit', [$obiect->id, $id_investitie]) }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>
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
        <!-- /.col-lg-5 -->
        <div class="col-lg-7">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <a href="#" class="pull-right btn-primary" id="btn_show_hide_articol" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </a>  
                </div>
                                                                        
                <div id="div_cautare_articol" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista articole de deviz          
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                     
                      <a href="{{ URL::route('investitie_por_axa12_articol_add', [$id_investitie, $selected_object, $denumire_selected_object]) }}">                       
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-articol">
                        <thead>
                          <tr> 
                            <td class="hidden"></td>                                  
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Dest. spatiu</th>
                            <th class="text-center">Tip lucrari</th>
                            <th class="text-center" title="Eligibil spatii de locuit">ESL</th>
                            <th class="text-center" title="Neeligibil spatii de locuit">NSL</th>
                            <th class="text-center" title="Neeligibil spatii cu alta destinatie">NSAD</th>
                            <th class="text-center" title="Eligibil spatii cu alta destinatie">ESAD</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>         
                            <td class="hidden"></td>                          
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Dest. spatiu</th>
                            <th class="text-center">Tip lucrari</th>
                            <th class="text-center" title="Eligibil spatii de locuit">ESL</th>
                            <th class="text-center" title="Neeligibil spatii de locuit">NSL</th>
                            <th class="text-center" title="Neeligibil spatii cu alta destinatie">NSAD</th>
                            <th class="text-center" title="Eligibil spatii cu alta destinatie">ESAD</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($articole as $articol)
                            
                              <tr data-id="{{ $articol->id }}">         
                                <td class="hidden">{{ $articol->id_obiect }}</td>
                                <td class="text-center">{{ $articol->denumire }}</td>
                                <td class="text-center">{{ $articol->destinatie_spatiu }}</td>
                                <td class="text-center">{{ $articol->tip_lucrare }}</td>                                
                                <td class="text-center">{{ $articol->eligibil_spatii_locuit?'DA':'NU' }}</td>
                                <td class="text-center">{{ $articol->neeligibil_spatii_locuit?'DA':'NU' }}</td>
                                <td class="text-center">{{ $articol->neeligibil_spatii_alta_destinatie?'DA':'NU' }}</td>
                                <td class="text-center">{{ $articol->eligibil_spatii_alta_destinatie?'DA':'NU' }}</td>
                                <td class="center action-buttons">
                                  <a href="{{ URL::route('investitie_por_axa12_articol_edit', [$id_investitie, $articol->id]) }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>
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

    <script>
        var selected_obj = -1;
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                // Se executa pentru fiecare DataTable din pagina
                // Prima data preiau id-ul primului obiect din grid pt a filtra articolele
                // ce apartin de acest obiect.
                // Apoi pastra valoarea obiectului selectionat intr-o variabila JS
                if (selected_obj == -1) selected_obj = parseInt( {{ json_encode($selected_object) }}, 10 );                
                var obj = parseInt( data[0] );

                // Permit filtrarea doar pt. gridul de articole
                if (settings.nTable.getAttribute('id') == 'dataTables-articol')
                {
                  if (selected_obj == obj)
                  {
                      return true;
                  }
                  else
                      return false;
                }
                return true;
            }
        );
 
        $(document).on('click','#dataTables-obiect tbody tr', function () {
            // Se executa cand fac click intr-un row din gridul de obiecte
            selected_obj = parseInt($(this).data('id')); 
            var table = $('#dataTables-articol').DataTable();
            MessageBox('INFO', 'Obiectul selectionat ... ', {{ json_encode($denumire_selected_object)}});            
            table.draw();
        });

        $(document).ready(function() {          
            $('#dataTables-obiect,#dataTables-articol').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide_obiect").click(function(){
                $("#div_cautare_obiect").toggle();             
            });   
            $("#btn_show_hide_articol").click(function(){
                $("#div_cautare_articol").toggle();             
            });   
            var table = $('#dataTables-obiect').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" }         
                ]                
            });             




            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');
                var url_delete = "{{ URL::route('aplicatie_delete') }}";
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
    </script>
@stop