@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
	<a href="{{ URL::route('investitie_por_axa12_list') }}"><i class="fa fa-arrow-circle-left"></i></a>
	Date investitie	
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
                                            <a href="{{ URL::route('investitie_por_axa12_obiecte_list', $id_investitie) }}"><h4><u><b>Definire atribute</b></u></h4></a>
                                        </div>
                                    </td>                                           
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">                                            
                                            <a href="@if (Entrust::can('manage_finance')) {{ URL::route('investitie_por_axa12_articol_valori_list', $id_investitie) }} @endif"><h4><u><b>Centralizator lucrari</b></u></h4></a>
                                        </div>
                                    </td>
                                    <td class="text-center"> 
                                        <div style="width:100%" class="panel-body">
                                            <a href="#"><h4><u><b>Repartizare devize</b></u></h4></a>                                         
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="#"><h4><u><b>Raport financiar</b></u></h4></a>                                            
                                        </div>
                                    </td>                              
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="#"><h4><u><b>Cereri de rambursare</b></u></h4></a>                                                                                        
                                        </div>
                                    </td>                              
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">
                                            <a href="#"><h4><u><b>Repartizare cheltuieli</b></u></h4></a>
                                        </div>
                                    </td>                              
                                    <td class="text-center">
                                        <div style="width:100%" class="panel-body">                                            
                                            <a href="#"><h4><u><b>Lucrari individuale</b></u></h4></a>                                         
                                        </div>
                                    </td>                              
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="display:inline-block" class="panel-body">
                                            <p>Constituirea garantiei de buna executie a contractului de achizitie publica are drept scop asigurarea autoritatii contractante de indeplinirea cantitativa, calitativa si in perioada convenita in contract. Cuantumul garantiei nu trebuie sa depaseasca 10% din pretul contractului, fara TVA.</p>
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