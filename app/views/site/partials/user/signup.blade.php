<form role="form" class="form-horizontal" method="POST" action="{{{ URL::to('user') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Inregistrare</div>
					<div style="float:right; font-size: 85%; position: relative; top:-10px"></div>
				</div>  
				<div style="padding-top:30px" class="panel-body" >										
					<div id="signupalert" style="display:none" class="alert alert-danger">
						<p>Error:</p>
						<span></span>
					</div>
															
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" name="username" id="username" value="{{{ Input::old('username') }}}">
					</div>
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input type="text" class="form-control" placeholder="{{ Lang::get('confide::confide.e_mail') }} {{ Lang::get('confide::confide.signup.confirmation_required') }}" name="email" id="email" value="{{{ Input::old('email') }}}">
					</div>

					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" name="password" id="password">
					</div>

					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" name="password_confirmation" id="password_confirmation">					
					</div>
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
						<button type="submit" class="btn btn-success">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
						<a href="{{ URL::to('/') }}" class="btn btn-primary">Conecteaza</a>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12 control">
							<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
								@if (Session::get('error'))
									<div class="alert alert-error alert-danger">
										@if (is_array(Session::get('error')))
											{{ head(Session::get('error')) }}
										@endif
									</div>
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
    </fieldset>
</form>