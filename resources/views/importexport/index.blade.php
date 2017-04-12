@extends('layouts.app')

@section('content')
  <div class="container-fluid airShpmain">        
    <div class="container importtype col-sm-12 col-md-offset-3 col-md-6 col-md-offset-3">
      <div class="airShipping zoomit3">
        <div class="col-xs-12 col-sm-6 zooming-effect">
          <center> 
            <div class="inputButtons zoomit visible animated zoomIn">
              <div class="innerBgs">
                <a rel="Export" class="buttonSlide1 impext importbtn" href="javascript:void(0);">{{ trans('messages.export') }}</a> 
              </div>
            </div>
          </center>
        </div>
        <div class="col-xs-12 col-sm-6 zooming-effect1">
          <center>
            <div class="inputButtons zoomit visible animated zoomIn">
              <div class="innerBgs">
                <a rel="Import"  class="buttonSlide1 impext exportbtn" href="javascript:void(0);">
                  {{ trans('messages.import') }}</a>
              </div>
            </div>
          </center>
        </div>
      </div>
    </div>
    <div class="container servicetype col-sm-12 col-md-offset-3 col-md-6 col-md-offset-3">
      <form action="{{ newurl('/importexport') }}" id="target" method="post">
        {!! csrf_field() !!} 
        <div class="airShipping zoomit3">
          <div class="col-xs-12 col-sm-6 zooming-effect">
            <center>
              <div class="inputButtons zoomit visible animated zoomIn">
                <div class="innerBgs">
                  <input type="submit" class="buttonSlide1 impext importbtn Service" name="submit" rel="Maritime" value="{{ trans('messages.maritime') }}">
                </div>
              </div>
            </center>
          </div>
          <div class="col-xs-12 col-sm-6 zooming-effect1">
            <center>
              <div class="inputButtons zoomit visible animated zoomIn">
                <div class="innerBgs">
                  <input type="submit" class="buttonSlide1 impext exportbtn Service" rel="Air Freight" name="submit" value="{{ trans('messages.air_freight') }}">
                </div>
              </div>
            </center>
          </div>
        </div>
        <input type="hidden" name="servicetype" id="servicetype" value=""/>
        <input type="hidden" name="importtype" id="importtype" value="">
      </form>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".importtype a").on('click',function(){
        var rel = $(this).attr('rel');
        $("#importtype").val(rel);
        $(".importtype").slideToggle();
        $(".servicetype").slideToggle();
        //alert(rel);  
      });
      $(".Service").on('click',function(){
        var rel = $(this).attr('rel');
        $("#servicetype").val(rel);
      });
    });
  </script>
@endsection