@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}   
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }} 
@stop

@section('title')
    Tipuri de atribute ale imobilelor 
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
                                <label class="control-label">Denumire tip atribut</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                    </table>
                </div>
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista tipuri atribute
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('tip_atribut_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-imobil">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Denumire tip atribut</th>                      
                            <th class="text-center">Numar atribute</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Denumire tip atribut</th>                      
                            <th class="text-center">Numar atribute</th>                            
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($tipuri_atribute as $tip)
                            <tr data-id="{{ $tip->id }}">                              
                              <td class="text-left">{{ stripslashes($tip->denumire) }}</td>
                              <td class="text-center">{{ $tip->numar_atribute }}</td>
                              <td class="center action-buttons">           
                                <a href="{{ URL::route('tip_atribut_edit', $tip->id) }}">                                
                                  <i class="fa fa-pencil-square-o" 
                                  title="Vizualizeaza sau modifica"></i>
                                </a>
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>                                
                                <a href="{{ URL::route('atribute_imobil_list', [$tip->id, htmlspecialchars($tip->denumire, ENT_COMPAT, 'UTF-8')]) }}"><i class="fa fa-sitemap" title="Atribute"></i></a>
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
            $('#dataTables-imobil').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-imobil').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" }
                ]
            });                       

            $('.fa-trash-o').click(function(){
                var url_delete = "{{ URL::route('tip_atribut_delete') }}";
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