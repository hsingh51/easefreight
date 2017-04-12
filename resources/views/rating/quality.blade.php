@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain">  
  <div class="container">
    <div class="row">
      <div class="col-md-offset-1 col-md-10 col-md-offset-1 userview">
        <div class="panel panel-default">
          <div class="panel-heading">Additional Service</div>
            <div class="panel-body">
              <div class="col-md-12 addition">
                <div class="col-md-12 progressbar">
                  <ol class="progtrckr" data-progtrckr-steps="5">
                   <li class="progtrckr-done istLi">Request</li>
                   <li class="progtrckr-done scndLi activeProgressBar">Additional Services</li>
                   <li class="progtrckr-todo thrdLi">Additional Info</li>
                   <li class="progtrckr-todo frthLi">International Insurance</li>
                   <li class="progtrckr-todo ffthLi">Quote</li>
                   <li class="progtrckr-todo sxthLi">Booking</li>
                   <li class="progtrckr-todo svthLi">Payment</li>
                 </ol>
                </div>
                <div class="col-md-12 checkboxes">
                  <div class="checkbox">
                    <label><input type="checkbox" value="">TARIFF CLASSIFICATION</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">FOREIGN CUSTOMS</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">LOCAL CUSTOMS</label>
                  </div>
                 <div class="checkbox">
                    <label><input type="checkbox" value="">ICA CERTIFICATE</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">TOTALIZE PL</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">ORIGIN AUTOGRADE AND CERTIFICATION</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">DIAN APPROVAL</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">INVIMA APPROVAL</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">DTA/OTM</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">INSURANCE</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">PLANT HEALTH CERTIFICATE</label>
                  </div>                
                  <div class="checkbox">
                    <label><input type="checkbox" value="">COLLECT FREIGHT</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" value="">SHIPPING PL</label>
                  </div>
                </div>
                <div class=" col-md-3 box-body table-responsive userfont">  
                  <div class = "pull-left">  
                    <input type="submit" class="btn btn-info btncolor nextbtn" value="Back" name="submit"/>
                  </div>
                  <div class = "pull-right">
                    <input type="submit" class="btn btn-info btncolor" value="Continue" name="submit"/>
                  </div>
                </div>
                <div class="col-md-12 box-body table-responsive userfont footerbtns">
                  <a href="#" class="inputtype">Questions?</a>   
                  <input type="submit" class="btn btn-info btncolor" value="CONTACT US" name="submit"/>    
                </div>                  
              </div><!-- col-md-12 -->
            </div><!-- panel body -->
          </div><!-- panel -->
        </div><!-- col-md-10-->
    </div><!--close ROW-->
  </div><!-- Close container -->
</div><!-- Close container-fluid -->

<div class="container-fluid airShpmain">  
  <div class="container">
    <div class="row">
      <div class="col-md-offset-1 col-md-10 col-md-offset-1 userview">
        <div class="panel panel-default">
          <div class="panel-heading">Upload Documents</div>
          <div class="panel-body">
            <div class="col-md-12">
              <div class="col-md-12 progressbar">
                <ol class="progtrckr" data-progtrckr-steps="5">
                  <li class="progtrckr-done istLi">Request</li>
                  <li class="progtrckr-done scndLi activeProgressBar">Additional Services</li>
                  <li class="progtrckr-todo thrdLi">Additional Info</li>
                  <li class="progtrckr-todo frthLi">International Insurance</li>
                  <li class="progtrckr-todo ffthLi">Quote</li>
                  <li class="progtrckr-todo sxthLi">Booking</li>
                  <li class="progtrckr-todo svthLi">Payment</li>
                </ol>
              </div>
              <div class="col-md-12 ">
              </div>
              <div class=" col-md-3 box-body table-responsive userfont">  
                <div class = "pull-left">  
                  <input type="submit" class="btn btn-info btncolor nextbtn" value="Back" name="submit"/>
                </div>
                <div class = "pull-right">
                  <input type="submit" class="btn btn-info btncolor" value="Continue" name="submit"/>
                </div>
              </div>
              <div class="col-md-12 box-body table-responsive userfont footerbtns">
                <a href="#" class="inputtype">Questions?</a>   
                <input type="submit" class="btn btn-info btncolor" value="CONTACT US" name="submit"/>    
              </div>                  
            </div><!--col-md-12-->
          </div><!--panel body-->
        </div><!--panel-->
      </div><!--col-md-10-->
    </div><!--close ROW-->
  </div><!-- Close container -->
</div>
@endsection