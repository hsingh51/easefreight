@extends('layouts.newadmin')



@section('content')

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">



  <?php $data = $stats['data'];?>

  <!-- Main content -->

  <div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.route_afr') }}</div>

 <!-- <ol class="breadcrumb headtags">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/routeAFR/View') }}">Route AFR </a></li>

      <li class="active">Add</li>

    </ol>-->

    

  <section class="content routeedit">

    <div class="row Rowaire">

      

      <div class="col-md-12 route-edit">

        <!-- Horizontal Form -->



          <!-- form start -->

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeAFR/Edit') }}">

            {!! csrf_field() !!}

            <input type='hidden' name="terminal_rates" value="<?php echo $data->afr_route_id; ?>"/>

             <div id="accordion">

             <h3 class="box-title">{{ trans('messages.origin') }}</h3>

            <div class="box-body">

            

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control origin_change_country" name="country_id">

                      <?php foreach ($stats['countries'] as $value) { $selected ='';

                        if($value->country_id == $data->origin_country_id){ $selected = 'selected="selected"';}

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

              

              <div class="form-group has-feedback{{ $errors->has('city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="city_id" class="col-sm-6 col-md-4 control-label ">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control origin_change_city" name="city_id">

                      <?php foreach ($stats['ocities'] as $value) { $selected ='';

                        if($value->city_id == $data->origin_city_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->city_id."' ".$selected." >".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('air') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="air" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_airport_iata_code') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                 <select class="form-control origin_change_airport" name="air">

                      <?php foreach ($stats['oairports'] as $value) { $selected ='';

                        if($value->airport_id == $data->origin_airport_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->airport_id."' ".$selected." >".$value->name.'('.$value->iata_code.')'

                          ."</option>";

                      }?>

                  </select>

                  @if ($errors->has('air'))

                      <span class="help-block">

                          <strong>{{ $errors->first('air') }}</strong>

                      </span>

                  @endif

                </div>

              </div>
              <div class="box-footer box-footers">
                    <div class="left_footer">
                      <button class="btn btn-info hideDiv next backbtn">Next</button>
                    </div>
                  </div>

              </div>

              

             

              <h3>{{ trans('messages.destination') }}</h3>

               <div class="box-body">

                            

              <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="des_country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control destination_change_country" name="des_country_id">

                      <?php foreach ($stats['countries'] as $value) {$selected ='';

                        if($value->country_id == $data->destination_country_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->country_id."' ".$selected." >".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('des_country_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('des_country_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('des_city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="des_city_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control destination_change_city" name="des_city_id">

                      <?php foreach ($stats['dcities'] as $value) {$selected ='';

                        if($value->city_id == $data->destination_city_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->city_id."' ".$selected." >".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('des_city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('des_city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('des_air') ? ' has-error' : '' }}">

              <div class="security-align">

               <label for="des_air" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_airport_iata_code') }}:</label>

               </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control destination_change_airport" name="des_air">

                      <?php foreach ($stats['dairports'] as $value) { $selected ='';

                        if($value->airport_id == $data->destination_airport_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->airport_id."' ".$selected." >".$value->name.'('.$value->iata_code.')'

                          ."</option>";

                      }?>

                  </select>

                  @if ($errors->has('des_air'))

                      <span class="help-block">

                          <strong>{{ $errors->first('des_air') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

           

            <div class="box-footer box-footers">

             <div class="left_footer">   

              <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.update') }}" name="submit"/>
			  
              <button class="btn btn-default back ml10">Back</button>
              
              </div>

            </div><!-- /.box-footer -->

             </div><!-- /.box-body -->

            </div>

          </form>

        </div><!-- /.box -->

    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

@endsection