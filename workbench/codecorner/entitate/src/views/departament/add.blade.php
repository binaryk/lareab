@extends('layouts.master')

@section('title')
    Adauga departament
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success')  }}</p>
                    @endif  
                    @if(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error')  }}</p>
                    @endif  
                    <div class="col-md-12">
                        {{ Form::textField('Denumire departament', 'denumire') }}                    
                    </div>

                    <div class="col-md-12">
                        {{ Form::textField('Descriere departament', 'descriere') }}                    
                    </div>

                    <div class="hidden">
                        {{ Form::selectField('Entitati', 'entitate', isset($entitati) ? $entitati : [$id_entitate => $denumire]) }}                    
                    </div>

                    <div class="hidden">
                        {{ Form::textField('Entitati selectionate', 'selected_rows') }}                    
                    </div>
                    
                    <div class="col-md-12">
                        <div class="table-responsive">
                            {{ Form::label('', '* Selectionati entitatile pentru care se doreste crearea departamentului. Este necesara cel putin o entitate.', ['class' => 'alert alert-info alert-dismissable']) }}
                            <table class="table table-striped table-bordered table-hover" id="dataTables-entitati">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:1%;"><input type="checkbox" onchange="select_all('#dataTables-entitati', this);" /></th>                                   
                                        <th class="text-center">Denumire entitate</th>               
                                    </tr>
                                </thead>
                                <tbody>                             
                                    @foreach ($entitati as $key => $entitate)
                                    <tr data-id="{{ $key }}"> 
                                        <td class="text-center">
                                            <input type="checkbox" class="checkbox" value="{{ $key }}" @if(Session::has('arr_selected') && is_array(Session::get('arr_selected')) && in_array($key, Session::get('arr_selected'))) checked @endif/>
                                        </td>                                    
                                        <td class="text-left">{{ $entitate }}</td>
                                    </tr>
                                    @endforeach                             
                                </tbody>
                            </table>
                        </div>                 
                    </div>                                      
                  
                    <div class="col-md-12 center top24"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="getSelected();" />
                        <a href="{{ URL::route('departament_list_organizatie') }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                        </a>                                                 
                    </div>
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/cnp.js') }}
    <script>
        $(document).ready(function(){
        });

        function getSelected()
        {
            var checkedValues = $('.checkbox:checked').map(function() {
                return this.value;
            }).get();          
            $('#selected_rows').val(checkedValues);
        }
  
        $('#cnp,#nume,#entitate').bind("change keyup input",(function(){
            if (verifica_cnp($('#cnp').val()))
            {
                $("#btn_submit").removeAttr("disabled");
            } else {
                $('#btn_submit').attr("disabled", "disabled");
            }
        }));
        
        function select_all(container, el) {            
            $(container + ' tbody').find(':checkbox').each(function(){
                $(this).prop('checked', !el.checked);
                $(this).trigger('click');
            });
        }        
    </script>
@stop