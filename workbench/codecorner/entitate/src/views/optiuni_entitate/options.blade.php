@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    <p>Date suplimentare
        @if(isset($entitate[0]->id)) {{ $entitate[0]->entitate }}, {{ $entitate[0]->localitate }} @endif
    </p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
        
            <div class="panel panel-default">
               <div class="panel-body">
                   <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="table-layout:fixed">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-male fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="fpanel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-users fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-sitemap fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-bank fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>                                    
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-info-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>                                    
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('reprezentant_legal_list_entitate', [$entitate[0]->id, $entitate[0]->entitate]) }}" class="btn btn-primary" role="button" style="width:100%">Modifică sau vizualizează</a>
                                        </div>                      
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('personal_list_entitate', [$entitate[0]->id, $entitate[0]->entitate]) }}" class="btn btn-primary" role="button" style="width:100%">Modifică sau vizualizează</a>
                                        </div>                      
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('departament_list_entitate', [$entitate[0]->id, $entitate[0]->entitate]) }}" class="btn btn-primary" role="button" style="width:100%">Modifică sau vizualizează</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('banci_list_entitate', [$entitate[0]->id, $entitate[0]->entitate]) }}" class="btn btn-primary" role="button" style="width:100%">Modifică sau vizualizează</a>
                                        </div>
                                    </th>                                    
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('informatii_statistice_list', [$entitate[0]->id, $entitate[0]->entitate, true]) }}" class="btn btn-primary" role="button" style="width:100%">Modifică sau vizualizează</a>
                                        </div>
                                    </th>                                    
                                </tr>
                            </tfoot>

                            <tbody>                             
                                <tr>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Reprezentanti legali</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Personal entitate</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"> 
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Departamente</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Bănci</b></u></h4>
                                            </div>
                                        </div>
                                    </td>                              
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Informatii statistice</b></u></h4>
                                            </div>
                                        </div>
                                    </td>                              
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>În vederea asigurării răspunderii societăţii faţă de terţi, un administrator trebuie să fie desemnat reprezentant legal al societăţii, având astfel dreptul de a exprima voinţa juridică a societăţii.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista angajatilor entitatii curente.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista departamentelor din care care este formata entitatea.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista bancilor cu care lucreaza entitatea.</p>
                                            </div>
                                        </div>
                                    </td> 
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Situatie financiara care prezinta imaginea activelor, pasivelor si capitalurile proprii a unei societati comerciale, pe o perioada de timp.</p>
                                            </div>
                                        </div>
                                    </td> 

                                </tr>
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

    <script>
    
    </script>
@stop