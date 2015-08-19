@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }} 
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}   
@stop

@section('title')
    @if($tip_entitate == 1)
      Firme din grup
    @elseif($tip_entitate == 2)
      Clienti din grup
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
                                <label class="control-label">Judet</label></td>
                            <td width="75%"><p id="_col_judet"></p></td>
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
                    @if($tip_entitate == 1)
                      Firme ce apartin organizatiei
                      <div class="pull-right">                      
                          <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                              
                          @if (Entrust::can('edit_firme_grup'))
                            <a href="{{ URL::route('entitate_organizatie_add', $tip_entitate) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                          @endif
                      </div>                      
                    @elseif($tip_entitate == 2)
                      Clienti cu care lucreaza organizatia
                      <div class="pull-right">                      
                          <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                              
                          @if (Entrust::can('edit_clienti_grup'))
                            <a href="{{ URL::route('entitate_organizatie_add', $tip_entitate) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                          @endif
                      </div>
                    @endif                                                   
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-firme_organizatie">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                      
                            <th class="text-center">CIF</th>
                            <th class="text-center">Localitate</th>
                            <th class="text-center">Judet</th>
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Cod postal</th>
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
                            <th class="text-center">Judet</th>
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Cod postal</th>
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
                              <td class="text-center">{{ $entitate->judet }}</td>
                              <td class="text-center">{{ $entitate->adresa }}</td>
                              <td>{{ $entitate->cod_postal }}</td>
                              <td>{{ $entitate->telefon }}</td>
                              <td>{{ $entitate->fax }}</td>                                     
                              <td class="center action-buttons">
                                @if (Entrust::can('edit_firme_grup') || Entrust::can('administrare_platforma'))
                                  <a href="{{ URL::route('entitate_organizatie_edit', [$entitate->id,$tip_entitate]) }}">
                                    <i class="fa fa-pencil-square-o" 
                                    title="Vizualizeaza sau modifica"></i>
                                  </a>
                                @endif
                                @if (Entrust::can('sterge_firme_grup') || Entrust::can('administrare_platforma'))
                                  <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>
                                @endif

                                <a href="{{ URL::route('optiuni_entitate', $entitate->id) }}">
                                  <i class="fa fa-arrows-alt" title="Date suplimentare entitate"></i>
                                </a>
                                <a href="{{ URL::route('departament_list_entitate', [$entitate->id, $entitate->denumire]) }}"><i class="fa fa-sitemap" title="Departamente"></i></a>
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
            $('#dataTables-firme_organizatie').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-firme_organizatie').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_cif", type: "text" },             
                  { sSelector: "#_col_localitate", type: "text" },             
                  { sSelector: "#_col_judet", type: "text" },             
                  { sSelector: "#_col_adresa", type: "text" },
                  { sSelector: "#_col_cod_postal", type: "text" },
                  { sSelector: "#_col_telefon", type: "text" },          
                  { sSelector: "#_col_fax", type: "text" }        
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var url_delete = "{{ URL::route('firme_organizatie_delete') }}";  
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