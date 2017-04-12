@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain">
<div class="container pre-signup">
    <div class="row Rowaire">
        <div class="col-md-offset-2 col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('messages.Pre- Sign Up') }}  @if (Auth::guest()) <span class="pull-right" ><!--<a href="{{ URL::to('user/pre-sign-up') }}">REGISTER</a>--></li> @endif        </div>
                   <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/user/pre-sign-up') }}">
                        {!! csrf_field() !!}
                        <div class="form-group has-feedback {{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <div class="security-align">
                            <label class="col-md-4 col-sm-4 control-label">{{ trans('messages.full_name') }}</label>
                            </div>

                            <div class="col-md-8 col-sm-8">
                                <input type="text" class="form-control" name="full_name">
                                 @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                           <div class="security-align">
                            <label class="col-md-4 col-sm-4 control-label">{{ trans('messages.E-Mail address') }}</label>
                            </div>

                            <div class="col-md-8 col-sm-8">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                          <div class="box-footer box-footers">
                               <div class="left_footer"> 
                                     <button type="submit" class="btn btn-primary btn btn-info pull-right hideDiv next ml10 backbtn">{{ trans('messages.Pre-sign Up') }}</button>
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
