@extends('layouts.master')

@section('title')
    Date contract & Obiectiv
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">        
           <div class="panel panel-default">
               <div class="panel-heading">
                   <p class="label label-warning">CONTRACT nr. {{ $contract[0]->numar_contract }} din data {{ $contract[0]->data_semnare_contract }} </p>
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                    </div>
               </div>
               <!-- /.panel-heading -->
               <div class="panel-body">
                   <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover">
                           <tbody>                                   
                                <tr>
                                    <td>Denumire</td>
                                    <td>   
                                      {{ $contract[0]->denumire_contract }}
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>Localitate</td>
                                    <td>
                                      {{ $contract[0]->localitate_contract }}                             
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tip contract</td>
                                    <td>
                                      {{ $contract[0]->tip_contract }}                             
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Parte in contract I</td>
                                    <td>
                                      {{ $contract[0]->entitatea_mea . '&nbsp<p class="label label-primary">(' . $contract[0]->parte_in_contract . ')</p>' }}                             
                                    </td>
                                </tr>                            
                                <tr>
                                    <td>Parte in contract II</td>
                                    <td>
                                      {{ $contract[0]->entitatea_mea }}                             
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
    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <p class="label label-warning">OBIECT nr. {{ $contract[0]->numar_obiectiv }} din data {{ $contract[0]->data_semnare_obiectiv }} </p>
               </div>
               <!-- /.panel-heading -->
               <div class="panel-body">
                   <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover">
                           <tbody>                                   
                                <tr>
                                    <td>Denumire</td>
                                    <td>   
                                      {{ $contract[0]->denumire_obiectiv }}
                                    </td>
                                </tr>  
                                <tr>
                                    <td>Adresa</td>
                                    <td>
                                      {{ $contract[0]->adresa_obiectiv }}                             
                                    </td>
                                </tr>                                                              
                                <tr>
                                    <td>Localitate</td>
                                    <td>
                                      {{ $contract[0]->localitate_obiectiv }}                             
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cod postal</td>
                                    <td>
                                      {{ $contract[0]->cod_postal_obiectiv }}                             
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>Regiune</td>
                                    <td>
                                      {{ $contract[0]->regiune_obiectiv }}                             
                                    </td>
                                </tr>
                                <tr>
                                    <td>Judet</td>
                                    <td>
                                      {{ $contract[0]->judet_obiectiv }}                             
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