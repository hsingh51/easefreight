@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
               <div class="panel panel-default">
                <div class="panel-heading">Add PersonIn Charge</div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/personInCharge/Add') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('full_name') ? ' has-error' : '' }}">
                <label for="full_name" class="col-md-4 control-label">Full Name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="full_name" placeholder="Full Name" name="full_name">
                  @if ($errors->has('full_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('full_name') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('position') ? ' has-error' : '' }}">
                <label for="position" class="col-md-4 control-label">Position</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="position" placeholder="Position" name="position">
                  @if ($errors->has('position'))
                      <span class="help-block">
                          <strong>{{ $errors->first('position') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('working_email') ? ' has-error' : '' }}">
                <label for="working_email" class="col-md-4 control-label">Work E-Mail</label>
                <div class="col-md-6">
                  <input type="email" class="form-control" id="working_email" placeholder="Work E-Mail" name="working_email">
                  @if ($errors->has('working_email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('working_email') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('cell_phone') ? ' has-error' : '' }}">
                <label for="cell_phone" class="col-md-4 control-label">Cell Phone</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="cell_phone" placeholder="Cell Phone" name="cell_phone">
                  @if ($errors->has('cell_phone'))
                      <span class="help-block">
                          <strong>{{ $errors->first('cell_phone') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('picture') ? ' has-error' : '' }}">
                <label for="picture" class="col-md-4 control-label">Picture</label>
                <div class="col-md-6">
                  <input type="file" id="picture" name="picture">
                  @if ($errors->has('picture'))
                      <span class="help-block">
                          <strong>{{ $errors->first('picture') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div><!-- /.box-body -->
              <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Next
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
