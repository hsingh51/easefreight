@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('messages.register') }}</div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/user/register') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="group_id" value="3">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.full_name') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.username') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.E-Mail address') }}</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.password') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.confirm_password') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.phone_number') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-group{{ $errors->has('cell_phone') ? ' has-error' : '' }} {{ $errors->has('phone_ext') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.cell_phone') }}</label>
                            <div class="col-md-2" style="padding-right:0px;">
                                <input type="text" class="form-control country_code_ext" name="phone_ext" value="{{ old('phone_ext') }}">
                                @if ($errors->has('phone_ext'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_ext') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cell_phone" value="{{ old('cell_phone') }}">
                                @if ($errors->has('cell_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cell_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.address') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="address" value="{{ old('address') }}"></textarea>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.country') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="country_id" id="country_id_js">
                                    <option value="">{{ trans('messages.select_country') }}</option>
                                    <option value="42">Colombia</option>
                                    <?php foreach ($stats['countries'] as $value) { $selected='';
                                        echo "<option value='".$value->country_id."' >".$value->title."</option>"; }?>
                                </select>
                                @if ($errors->has('country_id'))
                                    <span class="help-block"> <strong>{{ $errors->first('country_id') }}</strong> </span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.city') }}</label>
                            <div class="col-md-6">
                                <div class="cities-js">
                                    <select class="form-control" name="city_id">
                                        <option value=''>{{ trans('messages.please_select_city') }}</option>
                                    </select>
                                </div>
                                @if ($errors->has('city_id'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-group {{ $errors->has('company_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.company') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.position') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="position" value="{{ old('position') }}">
                                @if ($errors->has('position'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.website') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                                @if ($errors->has('website'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.message') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="message" value="{{ old('message') }}"></textarea>
                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> {{ trans('messages.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection