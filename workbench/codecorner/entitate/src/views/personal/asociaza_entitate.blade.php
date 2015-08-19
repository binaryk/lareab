@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
    Personal @if(isset($entitate)) {{ $entitate }} @endif
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
                                <label class="control-label">Nume</label></td>
                            <td width="75%"><p id="_col_nume1"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">CNP</label></td>
                            <td width="75%"><p id="_col_cnp1"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista personal entitate
                  <div class="pull-right">                      
                      <a href="{{ URL::route('personal_add') }}">
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-personal1">
                        <thead>
                          <tr>                                                     
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">CNP</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">CNP</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($personal_all as $persoana)
                            <tr data-id1="{{ $persoana->id }}">         
                              <td class="text-left"><a href="{{ URL::route('personal_edit', $persoana->id) }}">{{ $persoana->nume }}</a></td>
                              <td class="text-left">{{ $persoana->cnp }}</td>
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
                                <label class="control-label">Nume</label></td>
                            <td width="75%"><p id="_col_nume2"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">CNP</label></td>
                            <td width="75%"><p id="_col_cnp2"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista personal @if(isset($entitate)) ai {{ $entitate }} @endif             
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-personal2">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">CNP</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">CNP</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($personal_entitate as $persoana)
                            <tr data-id2="{{ $persoana->id }}">         
                              <td class="text-left"><a href="{{ URL::route('personal_edit', $persoana->id_personal) }}">{{ $persoana->nume }}</a></td>
                              <td class="text-left">{{ $persoana->cnp }}</td>
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
            $('#dataTables-personal1').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $('#dataTables-personal2').dataTable({
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
            var table1 = $('#dataTables-personal1').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_nume1", type: "text" },            
                  { sSelector: "#_col_cnp1", type: "text" },
                ]
            });
            var table2 = $('#dataTables-personal2').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_nume2", type: "text" },            
                  { sSelector: "#_col_cnp2", type: "text" },
                ]
            });

            function asociaza_dezasociaza(asociaza, id)
            {
                var id_entitate = $('#id_entitate').val();

                var mesaj = (asociaza === true) ? "Sunteti sigur ca doriti adaugarea persoanei la entitate?" : "Sunteti sigur de stergerea inregistrarii?";
                var url = (asociaza === true) ? "{{ URL::route('asociaza_personal') }}" : "{{ URL::route('dezasociaza_personal') }}"; 
                var titlu = (asociaza === true) ? "Adauga..." : "Sterge...";
                var btn_yes = (asociaza === true) ? "Da, adauga!" : "Da, sterge!";

                bootbox.confirm({
                    title: titlu,
                    message: mesaj,
                    buttons: {
                        'confirm': {
                            label: btn_yes,
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
                                    "id_entitate": id_entitate
                                },
                                success : function(data){
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            }

            $('.fa-hand-o-left').click(function(){
                var id = $(this).closest('tr').data('id2');
                asociaza_dezasociaza(false, id);
            });
            $('.fa-hand-o-right').click(function(){
                var id = $(this).closest('tr').data('id1');                 
                asociaza_dezasociaza(true, id);
            });        
        });
    </script>
@stop