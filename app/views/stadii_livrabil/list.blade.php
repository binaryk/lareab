@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    Istoric de stadii livrabil
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   Istoric de stadii livrabil 
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
                                   <th class="text-center">Data</th>
                                   <th class="text-center">Utilizator</th>
                               </tr>
                           </thead>
                           <tbody>
                                <span style="visibility: hidden">
                                    {{ $cnt = 0; $ultimul_stadiu = ""; $id_ultimul_stadiu = -1; }}
                                </span>
                                @foreach ($stadii as $stadiu)                                    
                                    @if ($cnt == 0) 
                                        <span style="visibility: hidden">
                                            {{ $ultimul_stadiu = $stadiu->stadiu; 
                                                $id_ultimul_stadiu = $stadiu->id;}}
                                        </span>
                                    @endif
                                    <span style="visibility: hidden">{{ $cnt++ }}</span>
                                    <tr>                                                    
                                        <td>{{ $stadiu->stadiu }}</td>
                                        <td>{{ $stadiu->data_stadiu }}</td>
                                        <td>{{ $stadiu->nume_utilizator }}</td>
                                    </tr>
                                @endforeach                             
                           </tbody>
                        </table>
                        <form role="form" action="{{ URL::to('stadiu_livrabil/add') }}" method="post">
                            <fieldset>
                                @if(Session::has('message'))
                                  <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                                @endif 
                                <input type="hidden" name="id_livrabil_etapa" value="{{ $id_livrabil_etapa }}" />                           
                                
                                <div class="col-lg-6">
                                    <label>Schimba stadiu</label>
                                    <select class="form-control" name="stadiu_selectionat">
                                        <option>Selectioneaza un stadiu</option>
                                        @foreach($stadii_livrabil as $stadiu_livrabil)
                                            @if ($stadiu_livrabil->id > $id_ultimul_stadiu)
                                            <option value="{{ $stadiu_livrabil->id }}">{{ $stadiu_livrabil->denumire }}</option>
                                            @endif
                                        @endforeach                                   
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>Numarul de ore lucrate pe acest livrabil:</label>
                                    <input type="number" class="form-control" name="ore_lucrate" value="{{ $ore_lucrate }}" />
                                </div>
                                <div class="col-lg-12 text-center top24">
                                    <input type="submit" name="btn_submit" class="btn btn-lg btn-primary" value="Salvare"/>
                                </div>                                    
                                {{ Form::token() }}
                            </fieldset>
                        </form>
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
            $('#dataTables-stadii').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });

            $('#stadiu_selectionat').change(function () {
                var optionSelected = $(this).find("option:selected");
                var valueSelected  = optionSelected.val();
                var textSelected   = optionSelected.text(); 
                //alert(textSelected);
            });                
        });

    </script>
@stop