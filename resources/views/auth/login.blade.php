@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain">
<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-5  col-sm-offset-4 col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('messages.login') }}  @if (Auth::guest()) <span class="pull-right" ><a href="{{ newurl('/register') }}">{{ trans('messages.register') }}</a></li> @endif        </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                         <div class="security-align">
                            <label class="col-md-4 control-label">{{ trans('messages.E-Mail address') }}</label>
                            </div>

                            <div class="col-md-8">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                         <div class="security-align">
                            <label class="col-md-4 control-label">{{ trans('messages.password') }}</label>
                            </div>

                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ trans('messages.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group logged">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary backbtn">
                                   {{ trans('messages.login') }}
                                </button>
                                <a class="btn btn-link forgotbtn" href="{{ newurl('/password/reset') }}">{{ trans('messages.forgot your password') }}?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
