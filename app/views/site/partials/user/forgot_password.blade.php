<form role="form" class="form-horizontal" method="POST" action="{{ URL::to('user/forgot-password') }}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	<fieldset>
		<div class="container">    
			<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">{{{ Lang::get('confide::confide.e_mail') }}}</div>
					</div>     

					<div style="padding-top:30px" class="panel-body" >
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>                            
															
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" name="email" id="email" value="{{{ Input::old('email') }}}" autofocus>                                        
						</div>

						<div style="margin-top:10px" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
							  <input type="submit" class="btn btn-success" value="{{{ Lang::get('confide::confide.forgot.submit') }}}" />
							  <a href="{{ URL::to('/') }}" class="btn btn-primary">Conecteaza</a>
							</div>
						</div>	
										
						<div class="form-group">
							<div class="col-md-12 control">
								<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
									@if (Session::get('error'))
										<div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
									@endif							
									@if (Session::get('notice'))
										<div class="alert">{{{ Session::get('notice') }}}</div>
									@endif							
								</div>
							</div>
						</div>									
					</div>
				</div>  
			</div>		
		</div>
	</fieldset>
</form>

