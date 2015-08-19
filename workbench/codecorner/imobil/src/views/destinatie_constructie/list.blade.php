@extends('layouts.master')

@section('title')   
    <p>
        @if(isset($categorie_constructie)) Destinatie cladiri din categoria "{{ $categorie_constructie->denumire }}" @else Destinatie constructii @endif
    </p>     
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
                                <label class="control-label">Categorie constructie</label></td>
                            <td width="75%"><p id="_col_cat_const"></p></td>
                        </tr>                    
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista tipuri constructie
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="{{ URL::route('destinatie_constructie_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-tip_constructie">
                        <thead>
                          <tr>                              
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Categorie constructie</th>
                            <th class="text-center">Actiuni</th>                      
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                                                                 
                            <th class="text-center">Denumire</th>
                            <th class="text-center">Categorie constructie</th>
                            <th class="text-center">Actiuni</th>                      
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($tipuri_constructie as $t_const)
                            <tr data-id="{{ $t_const->id }}">
                              <td class="text-left">{{ $t_const->denumire_tip_const }}</td>
                              <td class="text-left">{{ $t_const->denumire_cat_const }}</td>
                              <td class="center action-buttons">
                                <a href="{{ URL::route('destinatie_constructie_edit', $t_const->id) }}">
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
        $(document).ready(function() {    
            
            $('#dataTables-tip_constructie').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[1,"asc"]]
                //"aaSorting": [[ 0, "asc" ]],
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-tip_constructie').dataTable().columnFilter({
              aoColumns: [                    
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_cat_const", type: "text" },
                ]
            });
            //table.column( '0:visible' ).order( 'asc' );                       

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');                  
                var url_delete = "{{ URL::route('destinatie_constructie_delete') }}";              
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