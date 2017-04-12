@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain">  
<div class="container">
    <div class="row">
       <div class="col-md-offset-1 col-md-10 col-md-offset-1 userview">
            <div class="panel panel-default">
                <div class="panel-heading">Search</div>
                <div class="panel-body">
                  
               <div class="col-md-12 progressbar">
                  <ol class="progtrckr" data-progtrckr-steps="5">
                   <li class="progtrckr-done istLi activeProgressBar">Request</li>
                     <li class="progtrckr-todo scndLi">Additional Services</li>
                        <li class="progtrckr-todo thrdLi">Additional Info</li>
                           <li class="progtrckr-todo frthLi">International Insurance</li>
                        <li class="progtrckr-todo ffthLi">Quote</li>
                    <li class="progtrckr-todo sxthLi">Booking</li>
                 <li class="progtrckr-todo svthLi">Payment</li>
              </ol>
               
               
               </div>
                    
              <div class="col-md-offset-2 col-md-8 col-md-offset-2 box-body table-responsive">
             <table class="table table-hover">
              <tr>
                <th class="border borders userfont">Type of Fright</th>
                <th class="border borders userfont">Port of Origin</th>
                <th class="border borders userfont">Port of Destination</th>
                <th class="border borders userfont">Postal Code of Origin </th>
                <th class="border borders userfont">Postal Code of Destination</th>               
              </tr>
              
               <tr>
                <th class="border borders userfont"><p>Maritime</p></th>
                <th class="border borders userfont"><p>Sri Lanka</p></th>
                <th class="border borders userfont"><p>GOA</p></th>
                <th class="border borders userfont"><p>CO10732</p></th>
                <th class="border borders userfont"><p>403206</p></th>    
                      
              </tr>
            </table>

          </div>
          
              <div class="col-md-12 box-body table-responsive tabeltop">
             <table class="table table-hover">            
              <tr>
                <th class="border borders userfont">FORWADER</th>
                <th class="border borders userfont">FF RATING</th>                 
                <th class="border borders userfont">SELECT</th>                               
              </tr>              
             
                <tr>
                <th class="border borders userfont">
                	<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_1">FF1</a>
                  </th>
                <th class="border borders userfont"><p><span class="glyphicon glyphicon-star"></span> <span class="glyphicon glyphicon-star"></span> <span class="glyphicon glyphicon-star"></span> <span class="glyphicon glyphicon-star"></span></p> </th>
                <th class="border borders userfont"> <input type="submit" class="btn btn-info btncolor" value="Select" name="submit"/>
                </tr>
    
                <tr>
                <th class="border borders userfont"><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_1">FF2</a></th>
                <th class="border borders userfont"><p><span class="glyphicon glyphicon-star"></span> <span class="glyphicon glyphicon-star"></span> <span class="glyphicon glyphicon-star"></span></p> </th>
                <th class="border borders userfont"><input type="submit" class="btn btn-info btncolor" value="Select" name="submit"/></th>
              </tr>
              
               <tr>
                <th class="border borders userfont"><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_1">FF3</a></th>
                <th class="border borders userfont"><p><span class="glyphicon glyphicon-star"></span> <span class="glyphicon glyphicon-star"></span></p> </th>
                 
                <th class="border borders userfont"><input type="submit" class="btn btn-info btncolor" value="Select" name="submit"/></th>                             
              </tr>
            </table>           

          </div>
                   
          

            <div class="col-md-12 box-body table-responsive tabeltop">
				 <div class="modal fade istTable" id="myModal_1" role="dialog">
               		 <div class="modal-dialog">
	                   <!-- Modal content-->
    	               <div class="modal-content">  
                       <div class="modal-header modalhead">
                              <button type="button" class="close btnclose" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Detail</h4>
                            </div>
                            
                         
                   <div class="modal-body modaltext">     
                     <table width="100%" border="1">
                        <tr>
                           <th  scope="row" class="border borders userfont">&nbsp;</th>
                           <td  class="border borders userfont">DIRECT / VIA</td>
                           <td class="border borders userfont">&nbsp;</td>
                        </tr>
                        <tr>
                        <th scope="row" class="border borders userfont">&nbsp;</th>
                        <td class="border borders userfont">FREQUENCY</td>
                        <td class="border borders userfont">&nbsp;</td>
                        </tr>
                        <tr>
                        <th scope="row" class="border borders userfont">&nbsp;</th>
                        <td class="border borders userfont">TRANSIT TIME</td>
                        <td class="border borders userfont">&nbsp;</td>
                        </tr>
                        <tr>
                        <th scope="row" class="border borders userfont">&nbsp;</th>
                        <td class="border borders userfont">NEXT DEPATURE DATE</td>
                        <td class="border borders userfont">&nbsp;</td>
                       </tr>
                        <tr>
                        <th scope="row" class="border borders userfont">&nbsp;</th>
                        <td class="border borders userfont">CARRIER</td>
                        <td class="border borders userfont">&nbsp;</td>
                       </tr>
                        <tr>
                        <th scope="row" class="border borders userfont"><a href="javascript:void(0);">FCL</a></th>
                        <td class="border borders userfont">20'</td>
                        <td class="border borders userfont">&nbsp;</td>
                        </tr>
                        <tr>
                        <th scope="row" class="border borders userfont"></th>
                        <td class="border borders userfont">40'</td>
                        <td class="border borders userfont">&nbsp;</td>
                       </tr>
                        <tr>
                        <th scope="row" class="border borders userfont"></th>
                        <td class="border borders userfont">40' HC</td>
                        <td class="border borders userfont">&nbsp;</td>
                        </tr>
                        <tr>
                       <th scope="row" class="border borders userfont"><a href="javascript:void(0);">LCL</a></th>
                       <td class="border borders userfont">LCL</td>
                       <td class="border borders userfont">&nbsp;</td>
                       </tr>
                        <tr>
                        <th scope="row" class="border borders userfont"><a href="javascript:void(0);">BB</a></th>
                        <td class="border borders userfont">BB</td>
                        <td class="border borders userfont">&nbsp;</td>
                        </tr>  
                      </table>
                   </div>
                   
                       <div class="modal-footer modalfoot footerbtn">
                          <button type="button" class="btn btn-default btncolor" data-dismiss="modal">Close</button>
                       </div>
                       
                		</div>
                     </div>
                  </div>    
                </div>          
                    
         
           <div class="col-md-12 box-body table-responsive userfont">      
           <a href="#" class="inputtype">Questions?</a>        
               <input type="submit" class="btn btn-info btncolor" value="CONTACT US" name="submit"/>
           </div>
                    
                    
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
 </div>
</div>
@endsection
