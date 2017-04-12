@extends('layouts.newadmin')



@section('content')

<!--    <h1> User Profile </h1>

    <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">User profile</li>

    </ol>-->

  <!-- Main content -->

   <div class="panel panel-default">         

<div class="panel-heading">{{ trans('messages.user_profile') }}</div>



  <section class="content profile">

    <div class="row">

      <div class="col-md-3">

      <!-- Profile Image -->

        <div class="box box-primary border-head">

          <div class="box-body box-profile ">

            <?php if(Auth::user()->picture): ?>

              <img class="profile-user-img img-responsive img-circle" 

                src="{{ URL::asset('uploads/'.Auth::user()->picture) }}" alt="{{ Auth::user()->username }}">

            <?php endif ?>

            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

            <p class="text-muted text-center"><?php echo $stats['company'];?></p>

          </div><!-- /.box-body -->

          <div class="tab-pane active" id="uploadPicture">

            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/updatePicture') }}">

                {!! csrf_field() !!}                

                <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">

                    <div class="col-sm-offset-2 col-sm-10 fontsize">

                    <label  class="custom-file-input file-blue"><input type="file" class="custom-file-input file-blue"></label>                        

                        @if ($errors->has('picture'))

                            <span class="help-block">

                                <strong>{{ $errors->first('picture') }}</strong>

                            </span>

                        @endif

                    </div>

                </div>

                 <div class="form-group">

                  <div class="col-sm-offset-7 col-sm-2">

                   <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.submit') }}" name="submit"/>

                  </div>

                </div>

              </form>

            </div>

      </div><!-- /.col -->

       </div><!-- /.box -->

      

      

      

      <div class="col-md-9">

        <div class="nav-tabs-custom">

          <ul class="nav nav-tabs profile-nav">

            <li class="active"><a href="#settings" data-toggle="tab">{{ trans('messages.profile_information') }}</a></li>

            <li><a href="#changePassword" data-toggle="tab">{{ trans('messages.change_password') }}</a></li>

            <!-- <li><a href="#financial_information" data-toggle="tab">Financial Information</a></li> -->

          </ul>

          <div class="tab-content">

            

            <!--<div class="tab-pane active" id="uploadPicture">

              <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/updatePicture') }}">

                {!! csrf_field() !!}

                

                <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">

                    <label class="col-sm-3 control-label upload">Profile Picture</label>

                    <div class="col-sm-9">

                        <input type="file" name="picture" >

                        @if ($errors->has('picture'))

                            <span class="help-block">

                                <strong>{{ $errors->first('picture') }}</strong>

                            </span>

                        @endif

                    </div>

                </div>

                <div class="form-group">

                  <div class="col-sm-offset-3 col-sm-2">

                   <input type="submit" class="btn btn-info pull-right backbtn" value="Submit" name="submit"/>

                  </div>

                </div>

              </form>

            </div>--><!-- /.tab-pane -->



            <div class="tab-pane active" id="settings">

              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/update') }}">

                {!! csrf_field() !!}

                <input type="hidden" name="com_id" value="{{ Auth::user()->company_id }}"/>

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                    <label class="col-sm-3 control-label formleft">{{ trans('messages.username') }}</label>

                    <div class="col-sm-9">

                        <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" placeholder="{{ trans('messages.username') }}">

                        @if ($errors->has('username'))

                            <span class="help-block">

                                <strong>{{ $errors->first('username') }}</strong>

                            </span>

                        @endif

                    </div>

                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                  <label for="inputName" class="col-sm-3 control-label formleft">{{ trans('messages.name') }}</label>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" id="inputName" name="name" value="{{ Auth::user()->name }}" placeholder="{{ trans('messages.name') }}">

                    @if ($errors->has('name'))

                        <span class="help-block">

                            <strong>{{ $errors->first('name') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                  <label for="inputEmail" class="col-sm-3 control-label formleft">{{ trans('messages.email') }}</label>

                  <div class="col-sm-9">

                    <input type="email" class="form-control" id="inputEmail" name="email" value="{{ Auth::user()->email }}" placeholder="{{ trans('messages.email') }}">

                    @if ($errors->has('email'))

                        <span class="help-block">

                            <strong>{{ $errors->first('email') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                  <label for="inputName" class="col-sm-3 control-label formleft">{{ trans('messages.username') }}</label>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" id="inputName" name="username" value="{{ Auth::user()->username }}" placeholder="{{ trans('messages.username') }}">

                    @if ($errors->has('username'))

                        <span class="help-block">

                            <strong>{{ $errors->first('username') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">

                  <label for="inputExperience" class="col-sm-3 control-label formleft">{{ trans('messages.company') }}</label>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="company" value="<?php echo $stats['company'];?>" placeholder="{{ trans('messages.company') }}">

                     @if ($errors->has('company'))

                          <span class="help-block">

                              <strong>{{ $errors->first('company') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('company_ID') ? ' has-error' : '' }}">

                    <label for="inputExperience" class="col-sm-3 control-label formleft">{{ trans('messages.company_id') }}</label>



                    <div class="col-sm-9">

                        <input type="text" class="form-control" name="company_ID" value="<?php echo $stats['com_id'];?>">



                        @if ($errors->has('company_ID'))

                            <span class="help-block">

                                <strong>{{ $errors->first('company_ID') }}</strong>

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

                  <label class="col-sm-2 control-label">Password Confirmation</label>

                  <div class="col-sm-10">

                      <input type="password" class="form-control" name="password confirmation" placeholder="Password Confirmation">

                      @if ($errors->has('password_confirmation'))

                          <span class="help-block">

                              <strong>{{ $errors->first('password_confirmation') }}</strong>

                          </span>

                      @endif

                  </div>

                </div> -->

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                    <label class="col-sm-3 control-label formleft">{{ trans('messages.phone_number') }}</label>



                    <div class="col-sm-9">

                        <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" placeholder="{{ trans('messages.phone_number') }}">



                        @if ($errors->has('phone'))

                            <span class="help-block">

                                <strong>{{ $errors->first('phone') }}</strong>

                            </span>

                        @endif

                    </div>

                </div>

                <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.mobile_number') }}</label>

                  <div class="col-sm-9">

                      <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}" placeholder="{{ trans('messages.mobile_number') }}">



                      @if ($errors->has('mobile'))

                          <span class="help-block">

                              <strong>{{ $errors->first('mobile') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.position') }}</label>

                  <div class="col-sm-9">

                      <input type="text" class="form-control" name="position" value="{{ Auth::user()->position }}" placeholder="{{ trans('messages.position') }}">

                      @if ($errors->has('position'))

                          <span class="help-block">

                              <strong>{{ $errors->first('position') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.address') }}</label>

                  <div class="col-sm-9">

                      <textarea class="form-control" name="address" placeholder="{{ trans('messages.address') }}">{{ Auth::user()->address }}</textarea>

                      @if ($errors->has('address'))

                          <span class="help-block">

                              <strong>{{ $errors->first('address') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.country') }}</label>

                  <div class="col-sm-9">

                      <select class="form-control" name="country_id">

                          <?php foreach ($stats['countries'] as $value) { $selected='';

                              if($value->country_id == Auth::user()->country_id){ $selected = "selected='selected'";}

                              echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";

                          }?>

                      </select>

                      @if ($errors->has('country_id'))

                          <span class="help-block">

                              <strong>{{ $errors->first('country_id') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.city') }}</label>

                  <div class="col-sm-9">

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

                <div class="form-group{{ $errors->has('branches') ? ' has-error' : '' }}">

                    <label for="inputExperience" class="col-sm-3 control-label formleft">{{ trans('messages.branches') }}</label>



                    <div class="col-sm-9">

                        <select class="form-control" name="branches">

                          <?php foreach ($stats['cities'] as $value) { $selected='';

                                if($value->city_id == $stats['branches']){ $selected = "selected='selected'";}

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

                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.website') }}</label>

                  <div class="col-sm-9">

                      <input type="text" class="form-control" name="website" value="{{ Auth::user()->website }}" placeholder="{{ trans('messages.website') }}">

                      @if ($errors->has('website'))

                          <span class="help-block">

                              <strong>{{ $errors->first('website') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>             

                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.message') }}</label>

                  <div class="col-sm-9">

                      <textarea class="form-control" name="message" placeholder="{{ trans('messages.message') }}">{{ Auth::user()->message }}</textarea>

                      @if ($errors->has('message'))

                          <span class="help-block">

                              <strong>{{ $errors->first('message') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('dangerous_good') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label formleft">{{ trans('messages.Handle_Dangerous Goods') }}?</label>
                  <div class="col-sm-9">
                    <input type="checkbox" class="pull-left" name="dangerous_good" value="1" <?php if(Auth::user()->dangerous_good == 1){ echo "checked=checked";}?> > 
                    @if ($errors->has('dangerous_good'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dangerous_good') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group">

                  <div class="col-sm-offset-3 col-sm-2">

                    <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.submit') }}" name="submit"/>

                  </div>

                </div>

              </form>

            </div><!-- /.tab-pane -->

          



            <div class="tab-pane" id="changePassword">

              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/changePassword') }}">

                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.password') }}</label>

                  <div class="col-sm-9">

                      <input type="password" class="form-control" name="password" placeholder="{{ trans('messages.password') }}">

                      @if ($errors->has('password'))

                          <span class="help-block">

                              <strong>{{ $errors->first('password') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                  <label class="col-sm-3 control-label formleft">{{ trans('messages.confirm_password') }}</label>

                  <div class="col-sm-9">

                      <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('messages.confirm_password') }}">

                      @if ($errors->has('password_confirmation'))

                          <span class="help-block">

                              <strong>{{ $errors->first('password_confirmation') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group">

                  <div class="col-sm-offset-3 col-sm-2">

                    <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.submit') }}" name="submit"/>

                  </div>

                </div>

              </form>

            </div><!-- /.tab-pane -->



            <!-- <div class="tab-pane" id="financial_information">

              <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/finantialInformation') }}">

               {!! csrf_field() !!}

                <div class="col-md-12"> 

                  <!-- Horizontal Form -->

                  <!-- /.box-header --> 

                  <!-- form start -->

                  <!-- <div class="form-horizontal">

                    <div class="box-body">

                      <div class="form-group has-feedback">

                        <div class="security-align">

                          <label for="inputPassword3" class="col-sm-5 control-label">Economic Activity</label>

                        </div>

                        <div class="col-sm-7 shareleft"> <?php echo $stats['financial_information']->economic_activity;?> </div>

                      </div>

                      <div class="form-group has-feedback">

                        <div class="security-align">

                          <label for="inputPassword3" class="col-sm-5 control-label">Registered Capital</label>

                        </div>

                        <div class="col-sm-7 shareleft"> <?php echo $stats['financial_information']->registered_capital;?> </div>

                      </div>

                      <div class="form-group has-feedback">

                        <div class="security-align">

                          <label for="inputPassword3" class="col-sm-5 control-label">Source Of Funds</label>

                        </div>

                        <div class="col-sm-7 shareleft"> <?php echo $stats['financial_information']->funds_source;?> </div>

                      </div>

                      <div class="form-group has-feedback">

                        <div class="security-align">

                          <label for="inputPassword3" class="col-sm-5 control-label">Way To Pay</label>

                        </div>

                        <div class="col-sm-7 shareleft"> <?php echo $stats['financial_information']->pay_way;?> </div>

                      </div>

                      <div class="form-group has-feedback">

                        <div class="security-align">

                          <label for="inputPassword3" class="col-sm-5 control-label">Financial Institution(Payments)</label>

                        </div>

                        <div class="col-sm-7 shareleft"> <?php echo $stats['financial_information']->financial_institution;?> </div>

                      </div>

                    </div> -->

                    <!-- /.box-body -->

                    <!-- <div class="box-footer box-footers">

                      <div class="left_footer leftfloat">  

                        <a href="<?php echo URL::to('/');?>/admin/finantialInformation/Edit/<?php echo $stats['financial_information']->finantial_information_id; ?>" 

                          class="btn btn-info pull-right backbtn">Update</a>

                      </div>

                    </div> -->

                    <!-- /.box-footer --> 

                  <!-- </div>

                </div>  -->

              <!-- /.box --> 

              <!-- </form>

            </div> --> <!-- /.tab-pane -->

          </div><!-- /.tab-content -->



        </div><!-- /.nav-tabs-custom -->

      </div><!-- /.col -->

    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

@endsection