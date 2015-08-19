<form role="form" class="form-horizontal" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <fieldset>
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Autentificare</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a></div>
					</div>     

					<div style="padding-top:30px" class="panel-body" >
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>                            
															
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" placeholder="{{{ Lang::get('confide::confide.username_e_mail') }}}" name="username" id="username" value="{{{ Input::old('email') }}}" autofocus>                                        
						</div>
									
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" name="password" id="password">
						</div>
																	 
						<div class="input-group">
							<div class="checkbox">
								<label>
									<input type="hidden" name="remember" value="0">
									<input id="login-remember" type="checkbox" name="remember" value="1"> {{ Lang::get('confide::confide.login.remember') }}
								</label>
							</div>
						</div>

						<div style="margin-top:10px" class="form-group">
							<!-- Button -->

							<div class="col-sm-12 controls">
							  <input type="submit" class="btn btn-success" value="{{ Lang::get('confide::confide.login.submit') }}" />
							  <!-- a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a-->
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12 control">
								<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
									{{ Lang::get('confide::confide.signup.dont_have_account') }} 
								<a href="create">
									{{ Lang::get('confide::confide.signup.register_here') }}
								</a>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-12 control">
								<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
									@if (Session::get('error'))
										<div class="alert alert-error alert-danger">{{ Session::get('error') }}</div>									
									@endif

									@if (Session::get('notice'))
										<div class="alert">{{ Session::get('notice') }}</div>
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
