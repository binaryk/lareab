@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    <p>Detalii factura
        @if(isset($factura->serie)) {{ $factura->serie . '/' . $factura->numar }} din data {{ $factura->data_facturare }} @endif
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
                                        <div class="fpanel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-star-o fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-print fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <div class="col-lg-10">
                                                <i class="fa fa-print fa-2x"></i>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('incasari_factura', $factura->id_factura) }}" class="btn btn-primary" role="button">Modifica sau vizualizeaza</a>
                                        </div>
                                    </th>                
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('livrabile_factura', $factura->id_factura) }}" class="btn btn-primary" role="button" style="width:100%">Vizualizeaza</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="{{ URL::route('detalii_factura_client', $factura->id_factura) }}" class="btn btn-primary" role="button" style="width:100%">Modifica sau vizualizeaza</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="#" class="btn btn-primary" role="button" style="width:100%">Imprima</a>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-footer">
                                            <a href="#" class="btn btn-primary" role="button" style="width:100%">Imprima</a>
                                        </div>
                                    </th>                
                                </tr>
                            </tfoot>

                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Incasari</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Desfasurator</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Detalii factura</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Imprima factura</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <div class="col-lg-10">
                                                <h4><u><b>Imprima desfasurator</b></u></h4>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista incasarilor partiale ale facturii cu datele aferente (data incasarii, valoare incasata, valoare virata in contul de garantie).</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p>Lista livrabilelor atasate facturii curente. Desfasuratorul este un document intern dar se va putea emite de asemenea la cererea clientului.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">                                                
                                                <p>Lista conceptelor ce se vor factura unui client. Aceste concepte, precum si cantitatea, unitatea de masura, pretul unitar se vor introduce manual. La totalul calculat se va aplica TVA-ul introdus la crearea obiectivului.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="col-lg-10">
                                                <p></p>
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