@extends('layouts.newadmin')



@section('content')

<?php

  //dd($stats);

?>

<div class="panel panel-default">

  <div class="panel-heading">{{ trans('messages.itineraries OFR LCL / FCL') }}</div>

   <!-- <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/ofrItinerary/View') }}">Itinerarios OFR LCL/FCL </a></li>

      <li class="active">Add Itinerarios OFR LCL/FCL</li>

    </ol>-->



  <!-- Main content -->

  <section class="content">

    <div class="row Rowaire">

        <div class="box box-info no-result-js">

          <div class="box-header with-border">

          </div>

        </div>



        <!-- Horizontal Form -->

      <!--  <div class="box box-info">

          <div class="box-header with-border">

            <h3 class="box-title">Itinerarios OFR LCL/FCL Edit </h3>

          </div>--><!-- /.box-header -->

          <!-- form start -->        

          

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('admin/ofrItinerary/Edit') }}">

            {!! csrf_field() !!}

            <div id="accordion">           

              <h3 class="floatalign">{{ trans('messages.edit_Itineraries OFR LCL / FCL') }} </h3>

              <div class="box-body">

              

                <div class="form-group has-feedback{{ $errors->has('frequency') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="frequency" class="col-sm-3 control-label">{{ trans('messages.frequency') }}:</label>

                  </div>

                  <div class="col-sm-9">

                  <input type="text" class="form-control" value="<?php echo $stats['data'][0]->frequency?>" id="frequency" placeholder="" name="frequency">

                    @if ($errors->has('frequency'))

                        <span class="help-block">

                            <strong>{{ $errors->first('frequency') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback">

                <div class="security-align">

                  <label for="year" class="col-sm-3 control-label">{{ trans('messages.year') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <?php $current_year = date('Y');?>

                    <select class="form-control" name="year" id="year">

                      <?php

                        for($i=$current_year;$i<=($current_year+1);$i++) {

                      ?>

                          <option value="<?php echo $i;?>"><?php echo $i;?></option>

                      <?php

                        }

                      ?>

                    </select>

                  </div>

                </div>

                <div class="form-group has-feedback">

                <div class="security-align">

                  <label for="week" class="col-sm-3 control-label">{{ trans('messages.week') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <?php $current_week = date('W');?>

                    <select class="form-control" name="week" id="week">

                      <?php

                        for($i=$current_week;$i<=52;$i++) {

                      ?>

                          <option value="<?php echo $i;?>"><?php echo $i;?></option>

                      <?php

                        }

                      ?>

                    </select>

                  </div>

                </div>

                

                <div clasv class="form-group has-feedback{{ $errors->has('departure_date') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="transit_time" class="col-sm-3 control-label">{{ trans('messages.next_departure_date') }}:</label>

                  </div>

                  <div class="col-sm-9"><div class="input-group bootstrap-datepicker ">

                    <div class="input-group-addon">

                      <i class="fa fa-calendar"></i>

                    </div>

                    <input type="text" id="departure_date" placeholder="" value="<?php echo date('d-m-Y',strtotime($stats['data'][0]->departure_date));?>" name="departure_date" class="form-control datepicker">

                    @if ($errors->has('departure_date'))

                        <span class="help-block">

                            <strong>{{ $errors->first('departure_date') }}</strong>

                        </span>

                    @endif

                  </div></div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('departure_day') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="transit_time" class="col-sm-3 control-label">{{ trans('messages.departure_day') }}:</label>

                  </div>

                  <div class="col-sm-9">

                                        

                      <input type="text" id="departure_day" readonly="readonly" value="<?php echo $stats['data'][0]->departure_day;?>" placeholder="" name="departure_day" class="form-control">

                      @if ($errors->has('departure_day'))

                          <span class="help-block">

                              <strong>{{ $errors->first('departure_day') }}</strong>

                          </span>

                      @endif

                    

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('cargo_date') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="cargo_date" class="col-sm-3 control-label"> {{ trans('messages.cargo_cut-off_date') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <div class="input-group bootstrap-datepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-calendar"></i>

                      </div>

                      <input type="text" id="cargo_date" value="<?php echo date('d-m-Y',strtotime($stats['data'][0]->cargo_date));?>" placeholder="" name="cargo_date" class="form-control datepicker">

                      @if ($errors->has('cargo_date'))

                          <span class="help-block">

                              <strong>{{ $errors->first('cargo_date') }}</strong>

                          </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('cargo_time') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="cargo_time" class="col-sm-3 control-label"> {{ trans('messages.cargo_cut-off_time') }}:</label>

                  </div>

                  <div class="col-sm-9"><div class="input-group bootstrap-timepicker ">

                    <div class="input-group-addon">

                      <i class="fa fa-clock-o"></i>

                    </div>

                    <input type="text" id="cargo_time" placeholder="" value="<?php echo date('h:i A',strtotime($stats['data'][0]->cargo_time));?>" name="cargo_time" class="form-control timepicker">

                    @if ($errors->has('cargo_time'))

                        <span class="help-block">

                            <strong>{{ $errors->first('cargo_time') }}</strong>

                        </span>

                    @endif

                  </div></div>

                </div>

                

                  <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="direct_via" class="col-sm-3 control-label">{{ trans('messages.direct/via_flight') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <input type="text" class="form-control" id="direct_via" value="<?php echo $stats['data'][0]->direct_via;?>"  placeholder="" name="direct_via">

                    @if ($errors->has('direct_via'))

                        <span class="help-block">

                            <strong>{{ $errors->first('direct_via') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                

                <div class="form-group has-feedback{{ $errors->has('voyage') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="direct_via" class="col-sm-3 control-label">{{ trans('messages.voyage') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <input type="text" class="form-control" id="voyage" value="<?php echo $stats['data'][0]->voyage?>" placeholder="" name="voyage">

                    @if ($errors->has('voyage'))

                        <span class="help-block">

                            <strong>{{ $errors->first('voyage') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>



                <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <input type="text" class="form-control" id="carrier" value="<?php echo $stats['data'][0]->carrier?>" placeholder="" name="carrier">

                    @if ($errors->has('carrier'))

                        <span class="help-block">

                            <strong>{{ $errors->first('carrier') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

              <div class="box-footer box-footers">

               <div class="left_footer">

                <input type="hidden" name="itinerary_id" value="<?php echo $stats['data'][0]->itinerary_id;?>">

                <button type="reset" style="margin-left:10px" class="btn btn-default pull-right">{{ trans('messages.reset') }}</button>

                <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.update') }}" name="submit"/>

              </div><!-- /.box-footer -->

              </div>

              </div><!-- /.box-body -->

            </div>  

          </form>

        </div><!-- /.box -->



    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

<script>

  $(document).ready(function(){

    $('.datepicker2').datepicker()

    .on('changeDate', function(ev){

        var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        var date = $(this).datepicker('getDate');

        var day = days[ date.getDay() ];

        $("#departure_day").val(day);                

        $('.datepicker2').datepicker('hide');

    });

  });

</script>

@endsection

