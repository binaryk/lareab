@extends('layouts.master')

@section('title')
    Clienti organizatie
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
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">CIF</label></td>
                            <td width="75%"><p id="_col_cif"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Localitate</label></td>
                            <td width="75%"><p id="_col_localitate"></p></td>
                        </tr>                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Cod postal</label></td>
                            <td width="75%"><p id="_col_cod_postal"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Telefon</label></td>
                            <td width="75%"><p id="_col_telefon"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Fax</label></td>
                            <td width="75%"><p id="_col_fax"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Clienti cu care lucreaza organizatia
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('clienti_organizatie_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-clienti_organizatie">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                      
                            <th class="text-center">CIF</th>
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Adresa</th>
                            <th class="text-center">CP</th>
                            <th class="text-center">Telefon</th>
                            <th class="text-center">Fax</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Denumire</th>                      
                            <th class="text-center">CIF</th>
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Adresa</th>
                            <th class="text-center">CP</th>
                            <th class="text-center">Telefon</th>
                            <th class="text-center">Fax</th>        
                            <th class="text-center">Actiuni</th>                              
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($clienti as $client)
                            <tr data-id="{{ $client->id_entitate }}">
                              <td class="text-center">{{ $client->denumire }}</td>
                              <td class="text-center">{{ $client->cif }}</td>
                              <td>{{ $client->localitate }}</td>
                              <td class="text-center">{{ $client->adresa }}</td>
                              <td>{{ $client->cod_postal }}</td>
                              <td>{{ $client->telefon }}</td>
                              <td>{{ $client->fax }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('clienti_organizatie_edit', $client->id_entitate) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>
                                <a href="{{ URL::route('reprezentant_legal_list_entitate', [$client->id_entitate, $client->denumire]) }}">
                                  <i class="fa fa-male" title="Reprezentanti legali"></i>
                                </a>
                                <a href="{{ URL::route('personal_entitate_list', [$client->id_entitate, $client->denumire]) }}"><i class="fa fa-users" title="Personal"></i></a>
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
            $('#dataTables-clienti_organizatie').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-clienti_organizatie').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_cif", type: "text" },             
                  { sSelector: "#_col_localitate", type: "text" },                                         
                  { sSelector: "#_col_adresa", type: "text" },
                  { sSelector: "#_col_cod_postal", type: "text" },
                  { sSelector: "#_col_telefon", type: "text" },          
                  { sSelector: "#_col_fax", type: "text" },
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var url_delete = "{{ URL::route('clienti_organizatie_delete') }}";  
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
                                    "id_entitate": id
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