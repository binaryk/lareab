@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop

@section('title')
  Utilizatori
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
                                <label class="control-label">Nume de utilizator</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Email</label></td>
                            <td width="75%"><p id="_col_descriere"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nume si prenume</label></td>
                            <td width="75%"><p id="_col_entitate"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Grupuri</label></td>
                            <td width="75%"><p id="_col_grupuri"></p></td>
                        </tr>                        
                        <tr>
                            <td width="25%">
                                <label class="control-label">Departamente</label></td>
                            <td width="75%"><p id="_col_departamente"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista utilizatori              
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                     
                      <a href="{{ URL::to('admin/users/create') }}">
                        <i class="fa fa-plus-circle fa-fw" id="nou" name="nou"></i> Nou
                      </a>                      
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-user">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nume de utilizator</th>                   
                            <th class="text-center">Email</th>
                            <th class="text-center">Nume si prenume</th> 
                            <th class="text-center">Grupuri</th>                  
                            <th class="text-center">Departamente</th>
                            <th class="text-center">Creat in</th>
                            <th class="text-center">Confirmat</th>
                            <th class="text-center">Blocat</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                   
                            <th class="text-center">Nume de utilizator</th>                   
                            <th class="text-center">Email</th>
                            <th class="text-center">Nume si prenume</th>                   
                            <th class="text-center">Grupuri</th>
                            <th class="text-center">Departamente</th>
                            <th class="text-center">Creat in</th>
                            <th class="text-center">Confirmat</th>
                            <th class="text-center">Blocat</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($users as $user)
                            <tr data-id="{{ $user->id }}">         
                              <td class="text-left">{{ $user->username }}</td>
                              <td class="text-left">{{ $user->email }}</td>                              
                              <td class="text-left">{{ $user->full_name }}</td>
                              <td class="text-center">{{ $user->grupuri }}</td>
                              <td class="text-center">{{ $user->departamente }}</td>
                              <td class="text-center">{{ $user->created_at }}</td>
                              <td class="text-center">{{ $user->confirmed_da_nu }}</td>      
                              <td class="text-center">{{ $user->blocked_da_nu }}</td>                        
                              <td class="center action-buttons"> 
                                @if (((Confide::user()->id === $user->id) && ($user->id === 1)) || ($user->id !== 1))
                                    <a href="{{ URL::to('admin/users/' . $user->id . '/edit') }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>
                                @endif
                                @if ($user->id !== 1)
                                    <a href="#" @if (!$user->blocked) title="Blocheaza" @else title="Activeaza" @endif>
                                        @if (Confide::user()->id != $user->id)
                                            @if (!$user->blocked)
                                              <i class="fa fa-unlock"></i>
                                            @else 
                                              <i class="fa fa-lock"></i>
                                            @endif
                                        @endif
                                @endif
                                @if ($user->id !== 1)
                                    <a href="{{ URL::to('admin/departamente_utilizator/' . $user->id . '') }}"><i class="fa fa-sitemap" title="Departamente"></i></a>
                                @endif
                                @if ((Confide::user()->id != $user->id) && ($user->id !== 1))
                                    <a href="#" class="connectAs" title="Conexiune cu datele utilizatorului"><i class="fa fa-user-secret"></i></a>
                                @endif
                              </td>                                                         
                            </tr>
                          @endforeach                             
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
    <!-- DataTables JavaScript -->
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }} 

    <script>
        $(document).ready(function() {          
            $('#dataTables-user').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-user').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" },            
                  { sSelector: "#_col_descriere", type: "text" },
                  { sSelector: "#_col_entitate", type: "text" },             
                  { sSelector: "#_col_grupuri", type: "text" },
                  { sSelector: "#_col_departamente", type: "text" },
                ]
            });

            $('.fa-unlock').click(function(){
                lock_unlock_user(this, "Sunteti sigur de blocarea utilizatorului?");
            });
            $('.fa-lock').click(function(){
                lock_unlock_user(this, "Sunteti sigur de activarea utilizatorului?");
            });

            function lock_unlock_user(sender, titlu)
            {
                var id = $(sender).closest('tr').data('id');
                var url_delete = "{{ URL::route('user_lock') }}";
                bootbox.confirm({
                    title: titlu,
                    message: ' ',
                    buttons: {
                        'confirm': {
                            label: "Da, sterge!",
                            className: "btn-success"
                        },
                        'cancel': {
                            label: "Nu, renunta!",
                            className: "btn-danger"
                        }
                    },
                    callback: function(result){
                        if(result) {
                            $.ajax({
                                type: "POST",
                                url : url_delete,
                                data : {
                                    "_token": '<?= csrf_token() ?>',
                                    "id": id
                                },
                                success : function(data){
                                    //$('tr[data-id='+id+']').fadeOut();
                                    window.location="{{ URL::to('admin/users/list') }}";
                                }
                            });
                        }
                    }
                });
            };
            
            $('.connectAs').click(function(){
                var id = $(this).closest('tr').data('id');
                
                $.ajax({
                    type: "POST",
                    url : "{{ URL::to('/session/change_session_user') }}",
                    data : {
                        "id": id
                    },
                    success : function(data){
                        window.location.href = "{{ URL::to('/dashboard') }}";
                    },
                    error : function(data) {
                        console.log(data);
                    }
                });
            });            
        });
    </script>
@stop