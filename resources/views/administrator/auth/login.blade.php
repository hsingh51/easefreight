@extends('layouts.adminlogin')

@section('content')
	<div class="login-box">
		<div class="login-logo">
			<img src="{{ URL::asset('assets/img/logo.png') }}" alt="Logo" height='50'>
			<a href="{{ newurl('/administrator/login') }}"><b>EaseFreight</b></a>
			<h3>Administrator</h3>
		</div><!-- /.login-logo -->
		@include('administrator.partials.errors')
		<div class="login-box-body">
			<form action="{{ newurl('/administrator/login') }}" role="form" method="POST">
				{!! csrf_field() !!}
				<div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
					<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					@if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
				</div>
				<div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
					<input type="password" class="form-control" placeholder="Password" name="password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					@if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
								<input type="checkbox" name="remember"> Remember Me
							</label>
						</div>
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
					</div><!-- /.col -->
				</div>
			</form>

		</div><!-- /.login-box-body -->
	</div>
@endsection
