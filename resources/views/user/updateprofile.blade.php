@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('messages.profile') }}</div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/user/profile') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="group_id" value="3">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.full_name') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="<?php echo $stats['user']['name']; ?>">
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
                                <input type="text" class="form-control" name="username" value="<?php echo $stats['user']['username']?>">
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
                                <?php echo $stats['user']['email']?>
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
                        <?php //dd($stats['user']); ?>
                        <div class="form-group{{ $errors->has('cell_phone') ? ' has-error' : '' }} {{ $errors->has('phone_ext') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.cell_phone') }}</label>
                            <div class="col-md-2" style="padding-right:0px;">
                                <input type="text" class="form-control country_code_ext" name="phone_ext" value="<?php echo $stats['user']['phone_ext']?>">
                                @if ($errors->has('phone_ext'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_ext') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cell_phone" value="<?php echo $stats['user']['mobile'];?>">
                                @if ($errors->has('cell_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cell_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.country') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="country_id" id="country_id_js">
                                    <option value="">{{ trans('messages.select_country') }}</option>
                                    <option value="42">Colombia</option>
                                    <?php foreach ($stats['countries'] as $value) { $selected =($stats['user']['country_id'] == $value->country_id)? "selected=selected" : ""; 
                                        echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>"; }?>
                                </select>
                                @if ($errors->has('country_id'))
                                    <span class="help-block"> <strong>{{ $errors->first('country_id') }}</strong> </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('company_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.company') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_name" value="<?php echo $stats['user']['company_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.position') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="position" value="<?php echo $stats['user']['position']; ?>">
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
                                <input type="text" class="form-control" name="website"  value="<?php echo $stats['user']['website']; ?>">
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
                                <textarea class="form-control" name="message" ><?php echo $stats['user']['message']; ?></textarea>
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
                                    <i class="fa fa-btn fa-user"></i> {{ trans('messages.update') }}
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