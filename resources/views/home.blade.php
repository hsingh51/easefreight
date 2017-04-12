@extends('layouts.appnew')



@section('content')

<div class="container-fluid padding0 content"> 

     

    <div class="sliderContainer">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">

            

            <!--<ol class="carousel-indicators">

              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

              <li data-target="#myCarousel" data-slide-to="1"></li>

              <li data-target="#myCarousel" data-slide-to="2"></li>

              <li data-target="#myCarousel" data-slide-to="3"></li>

            </ol>-->

        



            <!--<div class="carousel-inner" role="listbox">

              <div class="item active">

                <img src="{{ URL::asset('assets/img/slider1.png') }}"  />

              </div>

        

              <div class="item">

                <img src="{{ URL::asset('assets/img/slider1.png') }}"  />

              </div>

            

              <div class="item">

                <img src="{{ URL::asset('assets/img/slider1.png') }}"  />

              </div>

        

              <div class="item">

                <img src="{{ URL::asset('assets/img/slider1.png') }}"  />

              </div>

            </div>-->

        

             <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">

              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

              <span class="sr-only">Previous</span>

            </a>

            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">

              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

              <span class="sr-only">Next</span>

            </a>

          </div>

       

            <div class="frieghtForwarder">

              <?php $impID= $id=""; $ff_url = newurl('/admin/login'); 
              if(Auth::check() && Auth::user()->group_id == '3'){$impID= "imp";}
              if(Auth::check() && Auth::user()->group_id == '2'){ $ff_url = newurl('/admin/dashboard'); $id="opener"; }?>

                <div class="inputButtons zoomit"> <div class="innerBgs"> 
                  <a class="buttonSlide" id="<?php echo $impID; ?>" href="<?php echo $ff_url;?>">
                  i am a frieght forwarder</a> </div></div>

               <div class="inputButtons zoomit"> <div class="innerBgs">
                <a class="buttonSlide" id="<?php echo $id;?>" href="{{ newurl('/importexport') }}">
                  i am an importer / exporter</a> </div></div>                        

            </div>

        

    </div>

</div>

<div class="container-fluid ourservices">        

    <div class="container">

        <div class="ourServices">

            <h1>Our Services</h1>

            <div class="services">

                <div class="col-xs-12 col-sm-6 zoomit">

                    <div class="frieghtForward">

                        <h2>frieght forwarder</h2>

                        <p>Lighteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire</p>

                        <a class="buttonSlide1" href="javascript:void(0);">READ MORE &gt;</a>

                    </div>

                </div>

                <div class="col-xs-12 col-sm-6 zoomit1">

                    <div class="imporExport">

                        <h2>import export</h2>

                        <p>Lighteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire</p>

                        <a class="buttonSlide1" href="javascript:void(0);">READ MORE &gt;</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="container-fluid airShpmain">        

    <div class="container">

        <div class="airShipping zoomit3">

            <div class="col-xs-12 col-sm-6 ">

                <img src="{{ URL::asset('assets/img/leftimage.png') }}" class="img-responsive" />

            </div>

            <div class="col-xs-12 col-sm-6 airShippings">

                <h2>Air Shipping and <br/>Freight Transport</h2>

                <p>The world is changing all around us. To continue to thrive as a business over the next ten years and beyond, we must look ahead, understand the trends and forces that will shape.</p>

                <p>Our mission is to offer high-quality Services to our customers</p>

                <p>we must look ahead, understand the trends and forces that will shape our business in the future.</p>

                <a class="buttonSlide1" href="javascript:void(0);">READ MORE </a>

            </div>

        </div>

    </div>

</div>

<div class="container">

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

                <div class="panel-heading">Dashboard</div>



                <div class="panel-body">

                    You are logged in!

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

