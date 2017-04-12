@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container-fluid airShpmain">
 <div class="container reset">
    <div class="row">
        <div class="col-md-offset-4 col-md-5 ">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('messages.reset_password') }}</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/password/email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-md-4 control-label">{{ trans('messages.email_address') }}</label>
                        </div>

                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer box-footers">
                               <div class="left_footer col-md-offset-1"> 
                                <button type="submit" class="btn btn-primary btn btn-info pull-right hideDiv next ml10 backbtn">
                                    {{ trans('messages.send_password_reset_link') }}
                                </button>
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
