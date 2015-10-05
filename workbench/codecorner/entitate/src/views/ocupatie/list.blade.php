@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
  Clasificarea ocupatiilor din Romania
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
                                <label class="control-label">Cod ocupatie</label></td>
                            <td width="75%"><p id="_col_cod"></p></td>
                        </tr>                    
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire ocupatie</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista ocupatii (COR 2015)             
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                     
                      <a href="{{ URL::route('ocupatie_add') }}">                       
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-ocupatii">
                        <thead>
                          <tr>
                            <th class="text-center">Cod ocupatie</th>
                            <th class="text-center">Denumire ocupatie</th>                   
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th class="text-center">Cod ocupatie</th>                                   
                            <th class="text-center">Denumire ocupatie</th>                   
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($ocupatii as $ocupatie)
                            <tr data-id="{{ $ocupatie->id }}">         
                              <td class="text-left">{{ $ocupatie->id }}</td>
                              <td class="text-left">{{ $ocupatie->denumire }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('ocupatie_edit', $ocupatie->id) }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>
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
            $('#dataTables-ocupatii').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-ocupatii').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_cod", type: "text" },
                  { sSelector: "#_col_denumire", type: "text" },
                ]
            }); 
            

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');
                var url_delete = "{{ URL::route('ocupatie_delete') }}";
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
    </script>
@stop