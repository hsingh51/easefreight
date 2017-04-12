@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> User Profile </h1>
    <ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User profile</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
      <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <?php if(Auth::user()->picture): ?>
              <img class="profile-user-img img-responsive img-circle" 
                src="{{ URL::asset('uploads/'.Auth::user()->picture) }}" alt="{{ Auth::user()->username }}">
            <?php endif ?>
            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
            <p class="text-muted text-center">{{ Auth::user()->company }}</p>
            <!-- <ul class="list-group list-group-unbordered">
              <li class="list-group-item"> <b>Followers</b> <a class="pull-right">1,322</a> </li>
              <li class="list-group-item"> <b>Following</b> <a class="pull-right">543</a> </li>
              <li class="list-group-item"> <b>Friends</b> <a class="pull-right">13,287</a> </li>
            </ul>
            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border"> <h3 class="box-title">About Me</h3> </div><!-- /.box-header -->
          <div class="box-body">
            <strong><i class="fa fa-envelope margin-r-5"></i>  {{ Auth::user()->email }}</strong>
            <p class="text-muted"> {{ Auth::user()->company }} </p> <hr>
            <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
            <p class="text-muted">{{ Auth::user()->address }} , {{ Auth::user()->city }}, {{ Auth::user()->country }}</p> <hr>
            <strong><i class="fa fa-mobile margin-r-5"></i> Mobile</strong>
            <p class="text-muted"> {{ Auth::user()->mobile }} </p> <hr>
            <strong><i class="fa fa-phone margin-r-5"></i> Phone</strong>
            <p class="text-muted"> {{ Auth::user()->phone }} </p> <hr>
            <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
            <p>{{ Auth::user()->message }}</p>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <!-- <li><a href="#activity" data-toggle="tab">Activity</a></li>
            <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
            <li class="active"><a href="#uploadPicture" data-toggle="tab">Upload Picture</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
            <li><a href="#changePassword" data-toggle="tab">Change Password</a></li>
          </ul>
          <div class="tab-content">
            @include('admin.partials.errors')
            <div class="tab-pane active" id="uploadPicture">
              <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('administrator/updatePicture') }}">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label">Profile Picture</label>
                    <div class="col-sm-10">
                        <input type="file" name="picture" >
                        @if ($errors->has('picture'))
                            <span class="help-block">
                                <strong>{{ $errors->first('picture') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div><!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('administrator/update') }}">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" placeholder="Username">
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="{{ Auth::user()->name }}" placeholder="Name">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail" name="email" value="{{ Auth::user()->email }}" placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                  <label for="inputName" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="username" value="{{ Auth::user()->username }}" placeholder="Name">
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                
                <!-- <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                      <input type="password" class="form-control" name="password" placeholder="Password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Confirm Password</label>
                  <div class="col-sm-10">
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation">
                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                  </div>
                </div> -->
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label">Phone Number</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" placeholder="Phone">

                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Mobile Number</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}" placeholder="Mobile">

                      @if ($errors->has('mobile'))
                          <span class="help-block">
                              <strong>{{ $errors->first('mobile') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                
                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-10">
                      <textarea class="form-control" name="address" placeholder="Address">{{ Auth::user()->address }}</textarea>
                      @if ($errors->has('address'))
                          <span class="help-block">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                      <select class="form-control" name="country_id">
                          <?php foreach ($stats['countries'] as $value) { $selected='';
                              if($value->country_id == Auth::user()->country_id){ $selected = "selected='selected'";}
                              echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                          }?>
                      </select>
                      @if ($errors->has('country'))
                          <span class="help-block">
                              <strong>{{ $errors->first('country') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">City</label>
                  <div class="col-sm-10">
                      <select class="form-control" name="city_id">
                          <?php foreach ($stats['cities'] as $value) { $selected='';
                              if($value->city_id == Auth::user()->city_id){ $selected = "selected='selected'";}
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
                
                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Website</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="website" value="{{ Auth::user()->website }}" placeholder="Website">
                      @if ($errors->has('website'))
                          <span class="help-block">
                              <strong>{{ $errors->first('website') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>             
                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Message</label>
                  <div class="col-sm-10">
                      <textarea class="form-control" name="message" placeholder="message">{{ Auth::user()->message }}</textarea>
                      @if ($errors->has('message'))
                          <span class="help-block">
                              <strong>{{ $errors->first('message') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div><!-- /.tab-pane -->
          

            <div class="tab-pane" id="changePassword">
              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('administrator/changePassword') }}">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                      <input type="password" class="form-control" name="password" placeholder="Password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Confirm Password</label>
                  <div class="col-sm-10">
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation">
                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div><!-- /.tab-pane -->
          </div><!-- /.tab-content -->

        </div><!-- /.nav-tabs-custom -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection