@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Lista template-uri
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
                            <td width="20%">
                                <label class="control-label">Denumire template</label></td>
                            <td width="80%"><p id="_col_denumire_template"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Tip contract</label></td>
                            <td width="80%"><p id="_col_tip_contract"></p></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <label class="control-label">Observatii</label></td>
                            <td width="80%"><p id="_col_observatii"></p></td>
                        </tr>                   
                    </table>
                </div>                        
            </div>

           <div class="panel panel-default">
               <div class="panel-heading">
                    Lista template-uri
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>
                        <a href="{{ URL::route('template_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                    </div>                   
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                        <div class="form-group">                        
                       </div>
                       <table class="table table-striped table-bordered table-hover" id="dataTables-templates">
                           <thead>                                                       
                               <tr>                                   
                                   <th class="text-center">Denumire template</th>
                                   <th class="text-center">Tip contract</th>
                                   <th class="text-center">Observatii</th>
                                   <th class="text-center">Actiuni</th>
                               </tr>
                           </thead>
                           <tfoot>
                               <tr>                                   
                                   <th class="text-center">Denumire template</th>
                                   <th class="text-center">Tip contract</th>
                                   <th class="text-center">Observatii</th>
                                   <th class="text-center">Actiuni</th>
                               </tr>
                           </tfoot>
                           <tbody>
                                @foreach ($templates as $template)
                                    <tr data-id="{{ $template->id }}">
                                        <td>{{ $template->denumire }}</td>
                                        <td>{{ $template->tip_contract }}</td>
                                        <td>{{ $template->observatii }}</td>
                                        <td class="center action-buttons"> 
                                          <a href="{{ URL::to('template_add/'.$template->id) }}">
                                            <i class="fa fa-pencil-square-o" title="Vizualizeaza sau modifica"></i>
                                          </a>                                                          
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
        $(document).ready(function() 
        {         
            $('#dataTables-templates').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"asc"]]
            });
            
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
              });
            var table = $('#dataTables-templates').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire_template", type: "text" },             
                  { sSelector: "#_col_observatii", type: "text" },             
                  { sSelector: "#_col_tip_contract", type: "text" },             
                ]
            });
			
			
			$('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('template_delete') }}";              
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