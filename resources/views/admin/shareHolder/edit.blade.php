@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

  <div class="panel panel-default">

    <div class="panel-heading">{{ trans('messages.legal_representative') }}</div>

      <section class="content sharecontent">

        <div class="row Rowaire">

          <div class="col-md-12 legal-edit">

            <!-- Horizontal Form -->

            <!-- form start -->          

            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data"  action="{{ newurl('/admin/shareHolders/Edit') }}">

              {!! csrf_field() !!}

              <div id="accordion">

                <h3 class="floatalign">{{ trans('messages.edit') }}</h3>

                <div class="box-body">

                  <input type='hidden' name="representative" value="<?php echo $data->representative_id; ?>"/>

                  <div class="box-body">

                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">

                      <div class="security-align">

                        <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('messages.name') }}</label>

                      </div>

                      <div class="col-sm-9">

                        <input type="text" class="form-control" id="inputEmail3" placeholder="{{ trans('messages.name') }}" name="name"

                           value="<?php echo $data->name;?>">

                        @if ($errors->has('name'))

                            <span class="help-block">

                                <strong>{{ $errors->first('name') }}</strong>

                            </span>

                        @endif

                      </div>

                    </div>

                    <!-- <div class="form-group has-feedback {{ $errors->has('type') ? ' has-error' : '' }}">

                      <div class="security-align">

                        <label for="inputPassword3" class="col-sm-3 control-label">Type</label>

                      </div>

                      <div class="col-sm-9">

                        <input type="text" class="form-control" id="inputPassword3" placeholder="Type" name="type"

                           value="<?php echo $data->type;?>">

                        @if ($errors->has('type'))

                            <span class="help-block">

                                <strong>{{ $errors->first('type') }}</strong>

                            </span>

                        @endif

                      </div>

                    </div> -->

                    <div class="form-group has-feedback {{ $errors->has('identification') ? ' has-error' : '' }}">

                      <div class="security-align">

                        <label for="inputPassword3" class="col-sm-3 control-label">{{ trans('messages.identification') }}</label>

                      </div>

                      <div class="col-sm-9">

                        <input type="text" class="form-control" id="inputPassword3" placeholder="{{ trans('messages.identification') }}" name="identification" 

                           value="<?php echo $data->identification;?>">

                        @if ($errors->has('identification'))

                            <span class="help-block">

                                <strong>{{ $errors->first('identification') }}</strong>

                            </span>

                        @endif

                      </div>

                    </div>

                    <div class="form-group has-feedback {{ $errors->has('identification_copy') ? ' has-error' : '' }}">

                      <div class="security-align">

                        <label for="identification_copy" class="col-sm-3 control-label">{{ trans('messages.identification_copy') }}</label>

                      </div>

                      <div class="col-sm-9">

                        <input type="file" id="identification_copy"  name="identification_copy" >

                        @if($data->identification_copy)

                           <?php 
                          $filename = URL::asset('identification_copy').'/'.$data->identification_copy;
                          $ext = pathinfo($filename, PATHINFO_EXTENSION);
                          if($ext=="png" || $ext=="jpg" || $ext=="jpeg"){
                          ?>
                            <a href="{{ URL::asset('identification_copy')}}<?php echo '/'.$data->identification_copy;?>" 

                            class="example-image-link" data-lightbox="example-set" value-lightbox="example-set">

                            <span  class="person-img">

                              <img src="{{ URL::asset('assets/images/link.png') }}"/> {{ trans('messages.preview') }}</span>

                          </a>
                          <?php  
                          }else{
                          ?>
                            <a target="_blank" class="example-image-link" href="{{ URL::asset('identification_copy')}}<?php echo '/'.$data->identification_copy;?>">

                            <span  class="person-img">

                              <img src="{{ URL::asset('assets/images/link.png') }}"/> {{ trans('messages.preview') }}</span>

                          </a>
                          <?php }?>

                        @endif

                        @if ($errors->has('identification_copy'))

                          <span class="help-block">

                            <strong>{{ $errors->first('identification_copy') }}</strong>

                          </span>

                        @endif

                      </div>

                    </div>

                  </div>

                  <div class="box-footer box-footers">

                    <div class="left_footer">   
					
					  <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.update') }}" name="submit"/>
					
                      <input type="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}" />

                    </div>

                  </div><!-- /.box-footer -->

                </div>

              </div>

            </form>

          </div><!-- /.box -->

        </div>  

      </section><!-- /.content -->

    </div>



@endsection