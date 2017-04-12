@extends('layouts.app')

@section('content')

<div class="container-fluid airShpmain">        

    <div class="container contactus">

        <div class="airShipping">



    <div class="row">

        <div class="col-md-6">

            <div class="well well-sm">
                <form class="form-horizontal" method="post" action="{{ newurl('contact_us') }}">
                    {!! csrf_field() !!} 
                    <fieldset>
                        <legend class="text-center header">{{ trans('messages.contact_us') }}</legend>
                        @include('partials.errors')
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <input id="fname" name="first_name" type="text" placeholder="{{ trans('messages.first_name') }}" class="form-control">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}"">
                            <div class="col-md-10 col-md-offset-1">
                                <input id="lname" name="last_name" type="text" placeholder="{{ trans('messages.last_name') }}" class="form-control">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <input id="email" name="email" type="text" placeholder="{{ trans('messages.email_address') }}" class="form-control">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                            <div class="col-md-10 col-md-offset-1">

                                <input id="phone" name="phone" type="text" placeholder="{{ trans('messages.phone') }}" class="form-control">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>



                        <div class="form-group{{ $errors->has('messages') ? ' has-error' : '' }}">

                            <div class="col-md-10 col-md-offset-1">

                                <textarea class="form-control" id="message" name="messages" placeholder="{{ trans('messages.your_message') }}" rows="7"></textarea>
                                @if ($errors->has('messages'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('messages') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>



                        <div class="form-group">

                            <div class="col-md-12 text-center">

                                <button type="submit" class="btn btn-primary btn-lg">{{ trans('messages.submit') }}</button>

                            </div>

                        </div>

                    </fieldset>

                </form>

            </div>

        </div>

        <div class="col-md-6">

            <div>

                <div class="panel panel-default">

                    <div class="text-center header">{{ trans('messages.our_office') }}</div>

                    <div class="panel-body address-space">

                        <h4>{{ trans('messages.address') }}</h4>

                        <div class="address">

                         Calle 121 # 18b-26 <br />

                         Bogota, Colombia<br />

                        +571 789 9232<br />

                        info@easefreight.com<br />

                        </div>

                        <br/><br/><br/><br/>

                        <hr />

                        <div id="map-canvas" class="map">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>



</div>




<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90C-7V8CltjJJstU5a6yfAEwwHIdALyo&callback=initialize"
  type="text/javascript"></script>
<script>
    // This example displays a marker at the center of Australia.
    // When the user clicks the marker, an info window opens.
    // The maximum width of the info window is set to 200 pixels.

    function initialize() {
      var myLatlng = new google.maps.LatLng(4.700845,-74.048046);
      var mapOptions = {
        zoom: 14,
        center: myLatlng
      };

      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

      var contentString = '<p><b>EaseFreight</b></p><p>Calle 121, # 18b-26, Bogota, Colombia</p>';

      var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 200
      });

      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'EF - EaseFreight'
      });
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
      });
    }

</script>



@endsection

