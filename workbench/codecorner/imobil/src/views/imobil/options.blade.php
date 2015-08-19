@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    <p>Date imobil
        @if(isset($imobil)) {{ $imobil->adresa }} @endif
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
                                            <h3>I</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>II</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>III</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <h3>IV</h3>
                                        </div>
                                    </th>                                    
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <h3>V</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>VI</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>VII</h3>
                                        </div>
                                    </th>                                   
                                </tr>
                            </thead>

                            <tbody>                             
                                <tr>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('scari_list', $imobil->id) }}"><h4><u><b>Scari</b></u></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Locatari</u></b></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Date identificative</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Date constructive</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('scari_list', $imobil->id) }}"><h4><u><b>Structura de rezistenta</b></u></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Instalatii</u></b></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Functionalitate</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista scarilor ce apartin imobilului.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista locatarilor ce locuiesc in acest imobil.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Date identificative ale cladirii.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista de rezistente termice corectate si ariile elementelor constructive ale imobilului.</p>
                                            </div>
                                        </div>
                                    </td>                                                                
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Date privind elemente din structura de rezistenta a imobilului.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista instalatiilor electrice, sanitare, termice din imobil.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Descrierea imobilului din punct de vedere functional. Se vor introduce numarul apartamentelor cu 1..5 camere cu suprafetele aferente, suprafelele locuibile, destinatia incaperilor. </p>
                                            </div>
                                        </div>
                                    </td>                                                               
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered" style="table-layout:fixed">
                            <thead>
                                <tr>     
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <h3>VIII</h3>
                                        </div>
                                    </th>                                                             
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <h3>IX</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>X</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>XI</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <h3>XII</h3>
                                        </div>
                                    </th>                                    
                                    <th class="text-center">
                                        <div class="panel-heading">
                                            <h3>XIII</h3>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="panel-heading">                                            
                                            <h3>XIV</h3>
                                        </div>
                                    </th>                                   
                                </tr>
                            </thead>

                            <tbody>                             
                                <tr>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('scari_list', $imobil->id) }}"><h4><u><b>Arhitectura</b></u></h4></a>
                                        </div>
                                    </td>                                
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('scari_list', $imobil->id) }}"><h4><u><b>Expertiza tehnica structura rezistenta</b></u></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Audit energetic</u></b></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Propuneri reabilitare (grosimi)</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Propuneri reabilitare (cantitati)</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Interventii realizate</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="{{ URL::route('locatari_list_imobil', $imobil->id) }}"><h4><u><b>Dosar imobil</u></b></h4></a>                                        
                                        </div>                                        
                                    </td>                                                                    
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Descrierea imobilului din punct de vedere arhitectural.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Expertiza tehnica pentru analiza structurii de rezistenta</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Auditul energetic al unei clădiri urmărește identificarea principalelor caracteristici termice și energetice ale construcției și ale instalațiilor aferente acesteia și stabilirea, din punct de vedere tehnic și economic a soluțiilor de reabilitare sau modernizare termică și energetică a construcției, pe baza rezultatelor obținute din activitatea de analiză.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Grosimile materialelor termoizolante propuse pentru reabilitarea imobilului</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista elementelor propuse pentru reabilitarea imobilului. Sunt incluse suprafetele, pretul unitar pe unitatea de masura si preturile finale.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista interventiilor realizate in trecut, motivele interventiilor, descrierea lucrarilor realizate precum si recomandari.</p>
                                            </div>
                                        </div>
                                    </td>                                                                                           
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <div class="">
                                                <p>Lista fotografiilor, documentelor si tot ceea ce tine de imobil in format electronic.</p>
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