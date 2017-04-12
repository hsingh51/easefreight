@extends('layouts.app')


@section('content')
<div class="container-fluid airShpmain">
    <div class="row userlogins">
        <div class="col-md-5 col-md-offset-4 col-sm-offset-4 col-sm-5 userlogin">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('messages.login') }} <span class="pull-right" ><a href="{{ newurl('/user/register') }}">{{ trans('messages.rEGISTER_AS_USER') }}</a></li>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/user/login') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-5 col-sm-5">
                                <label class="control-label">{{ trans('messages.E-Mail address') }}</label>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-5 col-sm-5"> <label class="control-label">{{ trans('messages.password') }}</label></div>
                            <div class="col-md-7 col-sm-7">
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember">{{ trans('messages.remember_me') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <button type="submit" class="btn btn-primary backbtn">
                                    <i class="fa fa-btn fa-sign-in"></i>{{ trans('messages.login') }} 
                                </button>
                                <a class="btn btn-link" href="{{ newurl('/user/resetpassword') }}">{{ trans('messages.forgot your password') }}?</a>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 line"></div>
                        <div class="new-user">
                            <a class="btn btn-primary btn-block btn-flat text-center" href="{{ newurl('/admin/login') }}">{{ trans('messages.I_am_a_frieght_forwarder') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection