@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    <p>Date contract
        @if(isset($contract[0]->id_contract)) {{ $contract[0]->numar }} din data {{ $contract[0]->data_semnarii }} @endif
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
                                                <i class="fa fa-star fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="fpanel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-star-o fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-cubes fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-history fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-folder-open fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>                                    
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('garantie_executie', $contract[0]->id_contract) }}" class="btn btn-primary" role="button" style="width:100%">Modifica sau vizualizeaza</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('garantie_participare', $contract[0]->id_contract) }}" class="btn btn-primary" role="button" style="width:100%">Modifica sau vizualizeaza</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('obiectiv_list_contract', $contract[0]->id_contract) }}" class="btn btn-primary" role="button" style="width:100%">Modifica sau vizualizeaza</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('stadii_contract', $contract[0]->id_contract) }}" class="btn btn-primary" role="button" style="width:100%">Vizualizeaza</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('document_list', $contract[0]) }}" class="btn btn-primary" role="button" style="width:100%">Vizualizeaza</a>
                                        </div>
                                    </th>                                    
                                </tr>
                            </tfoot>

                            <tbody>                             
                                <tr>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Garantie de buna executie</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Garantie participare</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"> 
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Obiective contract</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Istoric stadii</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Dosar contract</b></u></h4>
                                            </div>
                                        </div>
                                    </td>                              
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Pentru ca un operator economic să poată fi un potenţial câştigător într-o procedură de achiziţie publică, trebuie să respecte o primă condiţie: să depună garanţia de participare aşa cum s-a solicitat în documentaţia de atribuire.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista obiectivelor ce apartin contractului actual.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista stadiilor prin care a trecut proiectul, data la care s-a produs schimbarea de stadiu precum si utilizatorul care a realizat operatia.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Dosarul contractului contine toate documentele relationate cu contractul in format electronic. Se pot incarca documente noi, sterge existente si de asemenea se pot downloada.</p>
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