@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
  Personal grup de firme
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
                                <label class="control-label">Nume</label></td>
                            <td width="75%"><p id="_col_nume"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">CNP</label></td>
                            <td width="75%"><p id="_col_cnp"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Firma</label></td>
                            <td width="75%"><p id="_col_firma"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Telefon</label></td>
                            <td width="75%"><p id="_col_telefon"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Mail</label></td>
                            <td width="75%"><p id="_col_mail"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista personal              
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                     
                      <a href="{{ URL::route('personal_add') }}">                       
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-personal">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">CNP</th>
                            <th class="text-center">Firma</th>
                            <th class="text-center">Telefon</th>
                            <th class="text-center">Mail</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">CNP</th>
                            <th class="text-center">Firma</th>
                            <th class="text-center">Telefon</th>
                            <th class="text-center">Mail</th>
                            <th class="text-center">Actiuni</th>                                                        
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($personal as $persoana)
                            <tr data-id="{{ $persoana->id }}">         
                              <td class="text-center">{{ $persoana->nume }}</td>
                              <td class="text-center">{{ $persoana->cnp }}</td>
                              <td class="text-center">{{ $persoana->entitati }}</td>
                              <td class="text-center">{{ $persoana->telefon_1 }} @if(!empty($persoana->telefon_1)&&!empty($persoana->telefon_2)) / @endif {{ $persoana->telefon_2 }}</td>
                              <td class="text-center">{{ $persoana->mail_1 }} @if(!empty($persoana->mail_1)&&!empty($persoana->mail_2)) / @endif {{ $persoana->mail_2 }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('personal_edit', $persoana->id) }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>
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
            $('#dataTables-personal').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-personal').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_nume", type: "text" },
                  { sSelector: "#_col_cnp", type: "text" },
                  { sSelector: "#_col_firma", type: "text" },
                  { sSelector: "#_col_telefon", type: "text" },
                  { sSelector: "#_col_mail", type: "text" },
                ]
            }); 
            

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');
                var url_delete = "{{ URL::route('personal_delete') }}";
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