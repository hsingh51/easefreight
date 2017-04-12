@extends('layouts.newadmin')



@section('content')

  

   <!-- Main content -->

    <div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.route_afr') }}</div>

  <!--<ol class="breadcrumb headtags">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/routeAFR/View') }}">Route AFR </a></li>

      <li class="active">Add</li>

    </ol>-->

    

  <section class="content routeadd">

    

    <div class="row Rowaire">

      

      <div class="col-md-12 route-add">

        <!-- Horizontal Form -->

        <div class="box box-info boxes">

          <!-- /.box-header -->

          <!-- form start -->

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeAFR/Add') }}">

            {!! csrf_field() !!}

            <div id="accordion">

             <h3 class="floatalign">{{ trans('messages.origin') }}</h3>                   

              <div class="box-body">

                      

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="country_id" class="col-sm-6 col-md-4 control-label afr-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-6  col-md-8 routeafr-add">

                  <select class="form-control origin_change_country turn-to-ac" name="country_id">

                      <option value="">{{ trans('messages.select_country') }}</option>

                      <?php foreach ($stats['countries'] as $value) {

                          echo "<option value='".$value->country_id."'>".$value->title."</option>";

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

                <label for="city_id" class="col-sm-6 col-md-4 control-label afr-label">{{ trans('messages.Airport City') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8 routeafr-add">

                  <select class="form-control origin_change_city" name="city_id">

                      <option value="">{{ trans('messages.Airport City') }}</option>

                      <?php 
                      // foreach ($stats['cities'] as $value) {

                      //     echo "<option value='".$value->city_id."'>".$value->title."</option>";

                      // }
                      ?>

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

                <label for="air" class="col-sm-6 col-md-4 control-label afr-label">{{ trans('messages.select_airport_iata_code') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8 routeafr-add">

                 <select class="form-control origin_change_airport" name="air">

                      <option value="">{{ trans('messages.select_airport_iata_code') }}</option>

                      <?php 
                    //   foreach ($stats['airports'] as $value) {

                    //     echo "<option value='".$value->airport_id."' >".$value->name.'('.$value->iata_code.')'

                    //     ."</option>";

                    // }
                    ?>

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
                      <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    </div>
                  </div>
              </div>

              

              

              <h3 class="floatalign">{{ trans('messages.destination') }}</h3>

              <div class="box-body">                            

              <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="des_country_id" class="col-sm-6 col-md-4 control-label afr-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8 routeafr-add">

                  <select class="form-control destination_change_country turn-to-ac" name="des_country_id">

                      <option value="">{{ trans('messages.select_country') }}</option>

                      <?php foreach ($stats['countries'] as $value) {

                          echo "<option value='".$value->country_id."'>".$value->title."</option>";

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

                <label for="des_city_id" class="col-sm-6 col-md-4 control-label afr-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8 routeafr-add">

                  <select class="form-control destination_change_city" name="des_city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php 
					  // if(@$stats['dcities']){
						 //  foreach ($stats['dcities'] as $value) {
	
							//   echo "<option value='".$value->city_id."'>".$value->title."</option>";
	
						 //  }
					  // }
					  ?>

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

               <label for="des_air" class="col-sm-6 col-md-4 control-label afr-label">{{ trans('messages.select_airport_iata_code') }}:</label>

               </div>

                <div class="col-sm-6 col-md-8 routeafr-add">

                 <select class="form-control destination_change_airport" name="des_air">

                    <option value="">{{ trans('messages.select_airport_iata_code') }}</option>

                    <?php 
					// if(@$stats['dairports']){
					// 	foreach ($stats['dairports'] as $value) {
	
					// 		echo "<option value='".$value->airport_id."' >".$value->name.'('.$value->iata_code.')'
	
					// 		."</option>";
	
					// 	}
					//}
                    ?>

                  </select>

                  @if ($errors->has('des_air'))

                      <span class="help-block">

                          <strong>{{ $errors->first('des_air') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

            <!-- /.box-body -->

            

            <div class="box-footer  box-footers">

            <div class="left_footer">             
			  <input type="submit" class="btn btn-info backbtn btn3" value="{{ trans('messages.save') }}" name="submit"/>
			  
              <input type="submit" class="btn btn-info backbtn ml10 btn2" value="{{ trans('messages.Save and Add Rate') }}" name="submit_add"/>
              
			  <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>

              </div>

            </div><!-- /.box-footer -->

            

            </div>

            </div>

           

          </form>

        </div><!-- /.box -->

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

@endsection

