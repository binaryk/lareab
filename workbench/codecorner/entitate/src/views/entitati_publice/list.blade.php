@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
    Entitati publice
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
                    Entitati publice
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::to('entitati_publice_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-entitati_publice">
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
                          @foreach ($entitati as $entitate)
                            <tr data-id="{{ $entitate->id }}">
                              <td class="text-center">{{ $entitate->denumire }}</td>
                              <td class="text-center">{{ $entitate->cif }}</td>
                              <td>{{ $entitate->localitate }}</td>
                              <td class="text-center">{{ $entitate->adresa }}</td>
                              <td>{{ $entitate->cod_postal }}</td>
                              <td>{{ $entitate->telefon }}</td>
                              <td>{{ $entitate->fax }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('entitati_publice_edit', $entitate->id) }}">
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>
                                <a href="{{ URL::route('reprezentant_legal_list_entitate', [$entitate->id, $entitate->denumire]) }}">
                                  <i class="fa fa-male" title="Reprezentanti legali"></i>
                                </a>
                                
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
            $('#dataTables-entitati_publice').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-entitati_publice').dataTable().columnFilter({
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
                var id = $(this).closest('tr').data('id');    
                var url_delete = "{{ URL::route('entitati_publice_delete') }}";            
                bootbox.confirm({
                    title: "Sterge ...",
                    message: "Sunteti sigur de stergerea inregistrarii?",
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