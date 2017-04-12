@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

<div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.aereo_Itineraries') }}</div>

 <!-- <ol class="breadcrumb headtags">

        <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/route/View') }}">Itinerarios Aereo </a></li>

      <li class="active">Add Itinerarios Aereo</li>

    </ol>  -->  

  <section class="content Itinerariosadd"> 

    <div class="row Rowaire">

      <div class="col-md-12">

      <!-- /.box-header -->

          <!-- form start -->

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeItinerary/getAirRoute') }}">

            {!! csrf_field() !!}

            <div id="accordion">           

              <h3>{{ trans('messages.origin') }}</h3>

               <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control" id="country_id" name="country_id">

                      <?php foreach ($stats['countries'] as $value) {

                        echo "<option value='".$value->country_id."' >".$value->title."</option>";

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

                <label for="city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control" id="city_id"  name="city_id">

                    <?php foreach ($stats['cities'] as $value) {

                      echo "<option value='".$value->city_id."' >".$value->title."</option>";

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

                <label for="air" class="col-sm-3 control-label">{{ trans('messages.select_airport_iata_code') }}:</label>

                </div>

                <div class="col-sm-9">

                 <select class="form-control" id="air" name="air">

                      <?php foreach ($stats['airports'] as $value) { 

                        echo "<option value='".$value->airport_id."'>".$value->name.'('.$value->iata_code.')'

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

              </div>

             

              <h3>DESTINATION</h3>

               <div class="box-body">

               

              <div class="form-group has-feedback{{ $errors->has('destination_country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="destination_country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control" id="destination_country_id" name="destination_country_id">

                      <?php foreach ($stats['countries'] as $value) {

                        echo "<option value='".$value->country_id."' >".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('destination_country_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('destination_country_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('destination_city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="destination_city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label></div>

                <div class="col-sm-9">

                  <select class="form-control" id="destination_city_id"  name="destination_city_id">

                    <?php foreach ($stats['cities'] as $value) {

                      echo "<option value='".$value->city_id."' >".$value->title."</option>";

                    }?>

                  </select>

                  @if ($errors->has('destination_city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('destination_city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('destination_airport_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="destination_airport_id" class="col-sm-3 control-label">{{ trans('messages.select_airport_iata_code') }}:</label>

                </div>

                <div class="col-sm-9">

                 <select class="form-control" id="destination_airport_id" name="destination_airport_id">

                      <?php foreach ($stats['airports'] as $value) { 

                        echo "<option value='".$value->airport_id."'>".$value->name.'('.$value->iata_code.')'

                          ."</option>";

                      }?>

                  </select>

                  @if ($errors->has('destination_airport_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('destination_airport_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

            

            

            <div class="box-footer box-footers">

            <div class="left_footer">

            <button type="Reset" class="btn btn-default pull-right ml10">{{ trans('messages.reset') }}</button>

            <input type="submit" name="next" value="Next" class="btn btn-info pull-right hideDiv backbtn">

            </div>

            </div><!-- /.box-footer -->

            </div><!-- /.box-body -->

            </div>

          </form>

          

          <br/>

       <!-- Horizontal Form -->



  </section><!-- /.content -->

  </div>

  

     <script>

	$(document).ready(function(){

		$('.section-header').click(function(){

			 $(this).next().slideToggle();	

		});				

	});

</script>

  

@endsection

