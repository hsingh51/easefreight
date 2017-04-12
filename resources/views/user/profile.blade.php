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
                                <?php echo $stats['user']['name']; ?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.username') }}</label>
                            <div class="col-md-6">
                                <?php echo $stats['user']['username']?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.E-Mail address') }}</label>
                            <div class="col-md-6">
                                <?php echo $stats['user']['email']?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cell_phone') ? ' has-error' : '' }} {{ $errors->has('phone_ext') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.cell_phone') }}</label>
                            <div class="col-md-2" style="padding-right:0px;">
                                <?php echo $stats['user']['phone_ext']?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $stats['user']['mobile'];?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.country') }}</label>
                            <div class="col-md-6">
                                <?php foreach ($stats['countries'] as $value) { 
                                    if($stats['user']['country_id'] == $value->country_id){
                                    echo $value->title; }
                                } ?>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('company_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.company') }}</label>
                            <div class="col-md-6">
                                <?php echo $stats['user']['company_name']; ?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.position') }}</label>
                            <div class="col-md-6">
                                <?php echo $stats['user']['position']; ?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.website') }}</label>
                            <div class="col-md-6">
                                <?php echo $stats['user']['website']; ?>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('messages.message') }}</label>
                            <div class="col-md-6">
                                <?php echo $stats['user']['message']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ newurl('/user/profile')}}" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> {{ trans('messages.update') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection