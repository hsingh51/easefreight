@extends('layouts.newadminlogin')



@section('content')



	<!-- /.login-logo -->

	<div class="col-md-offset-4 col-md-5 col-md-offset-3">

        <div class="login-box">

			<div class="panel panel-default">

        		<div class="panel-heading">{{ trans('messages.log_in') }} </div>

				<!-- /.box-header -->

				<!-- form start -->

             	<div class="login-box-body forminput">

					<form action="{{ newurl('/admin/login') }}" role="form" method="POST">

						{!! csrf_field() !!}

						<div class="form-group has-feedback{{ $errors->has('email') ? ' has-error':'' }}">

							<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('messages.email') }}" >

							<span class="glyphicon glyphicon-envelope form-control-feedback message">

							</span>

							@if ($errors->has('email'))

		                        <span class="help-block">

		                            <strong>{{ $errors->first('email') }}</strong>

		                        </span>

		                    @endif

						</div>

						<div class="form-group has-feedback error {{ $errors->has('password') ? ' has-error' : '' }}">

							<input type="password" class="form-control" name="password" 

								placeholder="{{ trans('messages.password') }}" >

							<span class="glyphicon glyphicon-lock form-control-feedback lock-error">

							</span>

							@if ($errors->has('password'))

		                        <span class="help-block">

		                            <strong>{{ $errors->first('password') }}</strong>

		                        </span>

		                    @endif

						</div>

						<div class="row">

		                   <div class="col-md-12 col-sm-12 col-xs-12 user-btn">

		                       <div class="checkbox icheck col-md-6 col-sm-6 col-xs-6">

									<label class="user-label"> <input type="checkbox" name="remember"> 

										{{ trans('messages.remember_me') }}

									</label>

								</div>

                                <div class="col-md-6 col-sm-6 col-xs-6 forgot"><a href="{{ newurl('/password/reset') }}">{{ trans('messages.i_forgot_my_password') }}?</a></div>

		                    </div>

							<div class="sign-in">

		                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('messages.sign_in') }}</button>						

							</div><!-- /.col -->

							

                            

                            <div class="col-md-12 col-sm-12 col-xs-12 line"></div>

                            

                            

                            <div class="new-user">

		                    <!-- <button onclick="window.location='{{ URL::to('/freight/register') }}'" class="btn btn-primary btn-block btn-flat"></button> -->
                            

		                    <a href="{{ newurl('/freight/register') }}" class="btn btn-primary btn-block btn-flat text-center backbtn">{{ trans('messages.I AM NEW_FREIGHT FORWARDER') }}</a>

							</div><!-- /.col -->

						</div>

                        

                        

			</form>

			<!-- <a href="{{ newurl('/password/reset') }}">I forgot my password</a><br> -->

            

			<!--<a href="{{ newurl('/freight/register') }}" class="text-center">Register a new membership</a>-->



		</div><!-- /.login-box-body -->

	</div>

    </div>

    </div>

    </div>

@endsection

