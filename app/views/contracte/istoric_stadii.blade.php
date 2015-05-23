@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    <p>Istoric stadii contract</p>
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
                            <label class="control-label">Stadiu</label>
                        </td>
                        <td width="75%">
                        	<p id="_col_stadiu"></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">
                            <label class="control-label">Data stadiu</label>
                        </td>
                        <td width="75%">
                        	<p id="_col_data_stadiu"></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">
                            <label class="control-label">Utilizator</label>
                        </td>
                        <td width="75%">
                        	<p id="_col_utilizator"></p>
                        </td>
                    </tr>                     
                </table>
            </div>                        
        </div>

		<div class="panel panel-default">
			<div class="panel-heading">
                    Stadii contract
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>
                    </div>
            </div>
		

			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-stadii">
		                <thead>
		                  <tr>                                   
		                    <th class="text-center">Stadiu</th>                      
		                    <th class="text-center">Data stadiu</th>
		                    <th class="text-center">Utilizator</th>
		                  </tr>
		                </thead>
		                <tfoot>
		                  <tr>                                                               
		                    <th class="text-center">Stadiu</th>                      
		                    <th class="text-center">Data stadiu</th>
		                    <th class="text-center">Utilizator</th>
		                  </tr>
		                </tfoot>
		                <tbody>                             
		                  @foreach ($stadiu_contract as $stadii)
		                    <tr data-id="{{ $stadii->IdIstoric }}">
		                      <td class="text-center">{{ $stadii->denumire }}</td>
		                      <td class="text-center">{{ $stadii->data_stadiu }}</td>
		                      <td class="text-center">// trebuie implementat utilizatorul in baza</td>                                
		                    </tr>
		                  @endforeach                             
		                </tbody>
	                </table>
				</div>
			</div>
		</div>

	</div>
</div>

@stop

@section('footer_scripts')

	<!-- DataTables JavaScript -->
	{{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}
   	
   	<script>

        $(document).ready(function() {    
            
            $('#dataTables-stadii').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"desc"]]
            });

            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });

            var table = $('#dataTables-stadii').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_stadiu", type: "text" },
                  { sSelector: "#_col_data_stadiu", type: "text" },             
                  { sSelector: "#_col_utilizator", type: "text" },
                ]
            });
        }); 	      
    </script>
    
@stop