@extends('layouts.appnew')



@section('content')

<div class="container-fluid padding0">        
  
    <div class="sliderContainer">

                   <div class="wrap">

                      <div class="type-wrap">

                         <div id="typed-strings">

                            <p>{{ trans('messages.i_am_a_frieght_forwarder') }}</p>

                            <p>{{ trans('messages.i_am_an_importer_exporter') }}</p>

                            <p>{{ trans('messages.i_am_a_frieght_forwarder') }}</p>

                            <p>{{ trans('messages.i_am_an_importer_exporter') }}</p>

                        </div>

                      <span id="typed" style="white-space:pre;"></span>

                    </div>

                  </div>

            <?php //echo url('/'.App::getLocale()); 

                  //echo newurl();

            ?>                

            <div class="frieghtForwarder">

              <?php $impID= $id=""; $ff_url = newurl('/admin/login'); 
              if(Auth::check() && Auth::user()->group_id == '3'){$impID= "imp";}
              if(Auth::check() && Auth::user()->group_id == '2'){ $ff_url = newurl('/admin/dashboard'); $id="opener";}?>

                 <div class="inputButtons zoomit"> <div class="innerBgs"> <a class="buttonSlide" id="<?php echo $impID; ?>" href="<?php echo $ff_url;?>"><span>{{ trans('messages.i_am_a_frieght_forwarder') }}</span> </a> </div></div>

                 <div class="inputButtons zoomit"> <div class="innerBgs"><a class="buttonSlide" id="<?php echo $id;?>" href="{{ newurl('/importexport') }}"><span>{{ trans('messages.i_am_an_importer_exporter') }}</span></a> </div></div>  

            </div>

    </div>

</div>



<div class="container-fluid tracking">

  <div class="container">

    <div class="row">

      <div class="col-md-offset-3 col-md-6 tracklist">
      <form method="post" action="{{ newurl('/quote/track') }}">
        {!! csrf_field() !!} 
        
        <span class="{{ $errors->has('last_name') ? ' has-error' : '' }}">
          <input type="text" placeholder="{{ trans('messages.insert_quote_number_here') }}" name="quote" id="quote" value="" class="trackinput"/>
          <input id="track-it" type="submit" value="{{ trans('messages.track_it') }}" name="submit" class="trackbtn">
        </span>
      </form>
      </div>
      <div class="col-md-offset-3"></div>
  </div>

</div>

</div>



<div class="container-fluid airShpmain">        

    <div class="container">

        <div class="airShipping">

            <div class="col-xs-12 col-sm-6">

                <img src="{{ URL::asset('assets/img/leftimages.png') }}" class="img-responsive" />

            </div>

            <div class="col-xs-12 col-sm-6 airShippings">

                <h2>{{ trans('messages.air_shipping_and_freight_transport') }}</h2>

                <p>{{ trans('messages.the_world_is_changing_all_around_us._to_continue_to_thrive_as_a_business_over_the_next_ten_years_and_beyond,_we_must_look_ahead,_understand_the_trends_and_forces_that_will_shape.') }}</p>

                <p>{{ trans('messages.our_mission_is_to_offer_high-quality_services_to_our_customers') }}</p>

                <p>{{ trans('messages.we_must_look_ahead,_understand_the_trends_and_forces_that_will_shape_our_business_in_the_future.') }}</p>

                <a class="buttonSlide1" href="javascript:void(0);">{{ trans('messages.read_more') }} </a>

            </div>

        </div>

    </div>

</div>

@endsection