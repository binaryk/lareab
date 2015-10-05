@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
    Bănci @if(isset($entitate)) {{ $entitate }} @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <button id="btn_show_hide1" class="btn btn-primary" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </button>  
                </div>
                                                                        
                <div id="div_cautare1" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire1"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa1"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Cod IBAN</label></td>
                            <td width="75%"><p id="_col_iban1"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista totală de bănci
                  <div class="pull-right">                      
                      <a href="{{ URL::route('banca_add') }}">
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-banca1">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                   
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Cod IBAN</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                   
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Cod IBAN</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($banci_all as $banca)
                            <tr data-id1="{{ $banca->id }}">         
                              <td class="text-left"><a href="{{ URL::route('banca_edit', $banca->id) }}">{{ $banca->denumire }}</a></td>
                              <td class="text-left">{{ $banca->adresa }}</td>
                              <td class="text-left">{{ $banca->iban }}</td>                              
                              <td class="center action-buttons">                                                                
                                <a href="#"><i class="fa fa-hand-o-right" title="Adauga la entitate"></i></a>
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
        <div class="col-lg-6">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <button id="btn_show_hide2" class="btn btn-primary" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </button>  
                </div>
                                                                        
                <div id="div_cautare2" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire2"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Adresa</label></td>
                            <td width="75%"><p id="_col_adresa2"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Cod IBAN</label></td>
                            <td width="75%"><p id="_col_iban2"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista bănci @if(isset($entitate)) cu care lucreaza {{ $entitate }} @endif             
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-banca2">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                   
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Cod IBAN</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Denumire</th>                   
                            <th class="text-center">Adresa</th>
                            <th class="text-center">Cod IBAN</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($banci_entitate as $banca)
                            <tr data-id2="{{ $banca->id }}">         
                              <td class="text-left"><a href="{{ URL::route('banca_edit', $banca->id_banca) }}">{{ $banca->denumire }}</a></td>
                              <td class="text-left">{{ $banca->adresa }}</td>
                              <td class="text-left">{{ $banca->iban }}</td>                              
                              <td class="center action-buttons">                                                                
                                <a href="#"><i class="fa fa-hand-o-left" title="Sterge"></i></a>
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
        <input class="hidden" id="id_entitate" value="{{$id_entitate}}">
        <input class="hidden" id="entitate" value="{{$entitate}}">
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
            $('#dataTables-banca1').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $('#dataTables-banca2').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide1").click(function(){
                $("#div_cautare1").toggle();             
            });   
            $("#btn_show_hide2").click(function(){
                $("#div_cautare2").toggle();             
            });   
            var table1 = $('#dataTables-banca1').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire1", type: "text" },            
                  { sSelector: "#_col_adresa1", type: "select" },
                  { sSelector: "#_col_iban1", type: "select" },             
                ]
            });
            var table2 = $('#dataTables-banca2').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire2", type: "text" },            
                  { sSelector: "#_col_adresa2", type: "select" },
                  { sSelector: "#_col_iban2", type: "select" },             
                ]
            });

            $('.fa-hand-o-left').click(function(){
                var id = $(this).closest('tr').data('id2');
                var id_entitate = $('#id_entitate').val();
                var entitate = $('#entitate').val();
                var url = "{{ URL::route('dezasociaza_banca') }}";
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
                                url : url,
                                data : {
                                    "_token": '<?= csrf_token() ?>',
                                    "id": id,
                                    "id_entitate": id_entitate,
                                    "entitate": entitate
                                },
                                success : function(data){
                                    //$('tr[data-id2='+id+']').fadeOut();
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            });
            $('.fa-hand-o-right').click(function(){
                var id = $(this).closest('tr').data('id1');
                var id_entitate = $('#id_entitate').val();
                var entitate = $('#entitate').val();
                var url = "{{ URL::route('asociaza_banca') }}";
                bootbox.confirm({
                    title: "Sterge ...",
                    message: "Sunteti sigur ca doriti adaugarea bancii la entitate?",
                    buttons: {
                        'confirm': {
                            label: "Da, vreau!",
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
                                url : url,
                                data : {
                                    "_token": '<?= csrf_token() ?>',
                                    "id": id,
                                    "id_entitate": id_entitate,
                                    "entitate": entitate
                                },
                                success : function(data){
                                    //$('tr[data-id2='+id+']').fadeOut();
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            });        
        });
    </script>
@stop