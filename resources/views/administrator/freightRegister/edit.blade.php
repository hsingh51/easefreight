@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Freight Forwarder </h1>
    <ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ newurl('/administrator/freight-forwarder/View') }}">Freight Forwarder </a></li>
      <li class="active">Edit</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      @include('administrator.partials.errors')
      <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add </h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('administrator/freight-forwarder/Edit') }}">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="group_id" value="2">
            <input type="hidden" class="form-control" name="company_id" value="<?php echo $stats['data']->company_id;?>">
            <input type="hidden" class="form-control" name="id" value="<?php echo $stats['data']->id;?>">
            <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
              <label for="inputExperience" class="col-md-4 control-label">Company</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="company" value="<?php echo $stats['data']->company;?>" placeholder="Company">
                 @if ($errors->has('company'))
                      <span class="help-block">
                          <strong>{{ $errors->first('company') }}</strong>
                      </span>
                  @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('company_ID') ? ' has-error' : '' }}">
                <label for="inputExperience" class="col-md-4 control-label">Company ID</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="company_ID" value="<?php echo $stats['data']->com_id;?>">

                    @if ($errors->has('company_ID'))
                        <span class="help-block">
                            <strong>{{ $errors->first('company_ID') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Username</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="username" value="<?php echo $stats['data']->username;?>">

                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $stats['data']->name;?>">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $stats['data']->email;?>">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Website</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="website" value="<?php echo $stats['data']->website;?>">

                    @if ($errors->has('website'))
                        <span class="help-block">
                            <strong>{{ $errors->first('website') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Country</label>

                <div class="col-md-6">
                    <select class="form-control" name="country_id">
                        <?php foreach ($stats['countries'] as $value) {$selected='';
                                if($value->country_id == $stats['data']->country_id){ $selected = "selected='selected'";}
                            echo "<option value='".$value->country_id."' ".$selected." >".$value->title."</option>";
                        }?>
                    </select>
                    @if ($errors->has('country'))
                        <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Phone Number</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $stats['data']->phone;?>">

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Address</label>

                <div class="col-md-6">
                    <textarea class="form-control" name="address" ><?php echo $stats['data']->address;?></textarea>

                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">City</label>

                <div class="col-md-6">
                    <select class="form-control" name="city_id">
                        <?php foreach ($stats['cities'] as $value) {$selected='';
                                if($value->city_id == $stats['data']->city_id){ $selected = "selected='selected'";}
                            echo "<option value='".$value->city_id."' ".$selected.">".$value->title."</option>";
                        }?>
                    </select>

                    @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('branches') ? ' has-error' : '' }}">
                <label for="inputExperience" class="col-md-4 control-label">Branches</label>

                <div class="col-md-6">
                    <select class="form-control" name="branches">
                      <?php foreach ($stats['cities'] as $value) { $selected='';
                            if($value->city_id == $stats['data']->branches){ $selected = "selected='selected'";}
                            echo "<option value='".$value->city_id."' ".$selected.">".$value->title."</option>";
                        }?>
                    </select>
                    @if ($errors->has('branches'))
                        <span class="help-block">
                            <strong>{{ $errors->first('branches') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Message</label>

                <div class="col-md-6">
                    <textarea class="form-control" name="message" ><?php echo $stats['data']->message;?></textarea>

                    @if ($errors->has('message'))
                        <span class="help-block">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                <label for="is_active" class="col-md-4 control-label">Status</label>

                <div class="col-md-6">
                    <select class="form-control" name="is_active" id="status-js">
                      <?php foreach ($stats['status'] as $value) { $selected='';

                            if($value->status_id == $stats['data']->is_active){ $selected = "selected='selected'";}
                            echo "<option value='".$value->status_id."' ".$selected.">".$value->title."</option>";
                        }?>
                    </select>
                    @if ($errors->has('is_active'))
                        <span class="help-block">
                            <strong>{{ $errors->first('is_active') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div id="appointment-js" style="display:none;">
                <div class="form-group{{ $errors->has('appointment_date') ? ' has-error' : '' }}">
                    <label for="appointment_date" class="col-md-4 control-label">Appointment Date</label>
                    <div class="col-md-6 bootstrap-datepicker">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control datepicker" name="appointment_date" value="<?php echo $stats['data']->appointment_date;?>">
                        @if ($errors->has('appointment_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('appointment_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('appointment_time') ? ' has-error' : '' }}">
                    <label for="appointment_time" class="col-md-4 control-label ">Appointment Time</label>
                    <div class="col-md-6 bootstrap-timepicker">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" class="form-control timepicker" name="appointment_time" value="<?php echo $stats['data']->appointment_time;?>">
                        @if ($errors->has('appointment_time'))
                            <span class="help-block">
                                <strong>{{ $errors->first('appointment_time') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i> Update
                    </button>
                </div>
            </div>
          </form>
        </div><!-- /.box -->
      </div>

    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection