@extends('layouts.master')

@section('title')
    <p>Urca document in dosarul contractului</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form  action="{{ URL::route('document_upload', $id_contract) }}" method="post" enctype="multipart/form-data">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif  
                    <div class="form-group col-lg-10                    
                        @if ($errors->has('document')) has-error 
                        @elseif(Input::old('document')) has-success 
                        @endif">
                        <label>Denumire document</label>
                        <input class="form-control" id="document" name="document" type="text" value="{{ Input::old('document') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('document') }}" 
                        @endif>
                    </div>                   
                    <div class="form-group col-lg-2 row top24">                              
                        <a class='btn btn-primary' href='javascript:;'>
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbspSelectioneaza document ... &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file" id="file" size="40"  onchange='$("#document").val($(this).val());'>
                        </a>                    
                    </div>
                    <div class="form-group col-lg-12                   
                        @if ($errors->has('observatii')) has-error 
                        @elseif(Input::old('observatii')) has-success 
                        @endif">
                        <label>Observatii</label>
                        <input class="form-control" name="observatii" type="text" value="{{ Input::old('observatii') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('observatii') }}" 
                        @endif>
                    </div>                                                                                               
                    <div class="form-group col-lg-12 text-center">
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
                    </div>
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')        
    <script>                       
    </script>
@stop