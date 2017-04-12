@extends('layouts.app')
@section('content')
<?php //dd($data->routes);
	$routes = json_decode($data->routes);
	//dd($routes);
?>
<div class="container-fluid airShpmain">        
	<div class="container contactus">
		<div class="airShipping">
			<div class="row">
			  <div class="panel panel-default"> 
				  <div class="panel-heading">Track Qoute</div>
					<div class="panel-body">
						<div class="col-md-12 about-us">	
							<table class="table table-striped track-qoute">
							  <thead class="quote-back">
							    <tr>
								  <th>Quote Number</th>
								  <th><?php echo $data->search_id;?></th>								 								  
								</tr>
								<tr>
								  <th>STEP</th>
								  <th>STATUS</th>								  
								</tr>
							  </thead>
							  <?php $n = 1; ?>
							  <tbody>
							  	<?php if($routes->include_pickup=="Yes"){?>
								  	<?php
				                        if($data->status1 == "PENDING"){
				                          $stp1 = "pending";
				                        }elseif($data->status1 == "COLLECTED / IN TRANSIT"){
				                          $stp1 = "transit";
				                        }elseif($data->status1 == "STANDING BY"){
				                          $stp1 = "standing-by";
				                        }else{
				                          $stp1 = "";
				                        }
				                    ?>
	                                <tr>							  
									  <td>{{trans('messages.step_origin_pick_up')}}</td>
									  <td class="<?php echo $stp1;?>">
									  	<label>
									  		<?php if(@$data->status1){ echo $data->status1;}?>
									  	</label>
									  </td>
									</tr>
									<?php $n++;?>
									<?php
				                        if($data->status2 == "IN TRANSIT"){
				                          $stp2 = "pending";
				                        }elseif($data->status2 == "ARRIVED"){
				                          $stp2 = "transit";
				                        }elseif($data->status2 == "STANDING BY"){
				                          $stp2 = "standing-by";
				                        }else{
				                          $stp2 = "";
				                        }
				                      ?>
				                    <tr>
									  <td>{{trans('messages.step_pre_carriage')}}</td>
									  <td class="<?php echo $stp2;?>">
									  	<label>
									  		<?php if(@$data->status2){ echo $data->status2;}?>
									  	</label>
									  	</td>								  		  
									</tr> 
									<?php $n++;?> 



								<?php }?>
								
								
								<?php
			                        if($data->status3 == "AT WAREHOUSE"){
			                          $stp3 = "pending";
			                        }elseif($data->status3 == "ON BOARD"){
			                          $stp3 = "transit";
			                        }elseif($data->status3 == "STANDING BY"){
			                          $stp3 = "standing-by";
			                        }else{
			                          $stp3 = "";
			                        }
			                      ?>
								<tr>
								  <td>{{trans('messages.step_departure')}}</td>
								  <td class="<?php echo $stp3;?>">
								  	<label>
								  		<?php if(@$data->status3){ echo $data->status3;}?>
								  	</label>
								  </td>								
								</tr>
								<?php $n++;?> 

								<?php
			                        if($data->status4 == "IN TRANSIT"){
			                          $stp4 = "pending";
			                        }elseif($data->status4 == "ARRIVED"){
			                          $stp4 = "transit";
			                        }elseif($data->status4 == "STANDING BY"){
			                          $stp4 = "standing-by";
			                        }else{
			                          $stp4 = "";
			                        }
			                      ?>
								<tr>
								  <td>{{trans('messages.step_destination_arrival')}}</td>
								  <td class="<?php echo $stp4;?>">
								  	<label>
								  		<?php if(@$data->status4){ echo $data->status4;}?>
								  	</label>
								  	</td>								
								</tr>
								<?php $n++;?> 

								<?php
			                        
			                        if($data->status5 == "AT WAREHOUSE"){
			                          $stp5 = "pending";
			                        }elseif($data->status5 == "COLLECTED"){
			                          $stp5 = "transit";
			                        }elseif($data->status5 == "STANDING BY"){
			                          $stp5 = "standing-by";
			                        }else{
			                          $stp5 = "";
			                        }
			                      ?>
								<tr>
								  <td>{{ trans('messages.step_terminal_pick_up') }}</td>
								  <td class="<?php echo $stp5;?>">
								  	<label>
								  		<?php if(@$data->status5){ echo $data->status5;}?>
								  	</label>
								  </td>								
								</tr>
								<?php $n++;?> 

								<?php if($routes->include_delivery=="Yes"){ ?>

										<?php
					                        if($data->status6 == "IN TRANSIT"){
					                          $stp6 = "pending";
					                        }elseif($data->status6 == "ARRIVED"){
					                          $stp6 = "transit";
					                        }elseif($data->status6 == "STANDING BY"){
					                          $stp6 = "standing-by";
					                        }else{
					                          $stp6 = "";
					                        }
					                      ?>
										<tr>
										  <td>{{ trans('messages.step_on_carriage') }}</td>
										  <td class="<?php echo $stp6;?>">
										  	<label>
										  		<?php if(@$data->status6){ echo $data->status6;}?>
										  	</label>
										  </td>								
										</tr>
										<?php $n++;?>

										<?php
					                        if($data->status7 == "DELIVERED"){
					                          $stp7 = "transit";
					                        }elseif($data->status7 == "STANDING BY"){
					                          $stp7 = "standing-by";
					                        }else{
					                          $stp7 = "";
					                        }
					                      ?> 

					                      <tr>
											  <td>{{ trans('messages.step_destination_delivery') }}</td>
											  <td class="<?php echo $stp7;?>">
											  	<label>
											  		<?php if(@$data->status7){ echo $data->status7;}?>
											  	</label>
											  </td>								
											</tr>
											<?php $n++;?>

								<?php }?>

								<?php
			                        if($data->document_flow_document == "PENDING"){
			                          $stp4 = "pending";
			                        }elseif($data->document_flow_document == "RECEIVED"){
			                          $stp4 = "transit";
			                        }elseif($data->document_flow_document == "STANDING BY"){
			                          $stp4 = "standing-by";
			                        }else{
			                          $stp4 = "";
			                        }
			                      ?>
								<tr>
								  <td>DOCUMENT FLOW REPORT</td>
								  <td class="<?php echo $stp4;?>">
								  	<label>
								  		<?php if(@$data->document_flow_document){ echo $data->document_flow_document;}?>
								  	</label>
								  </td>								 								  
								</tr>
								<?php
			                        if($data->origin_impo_expo_custom == "PENDING"){
			                          $stp5 = "pending";
			                        }elseif($data->origin_impo_expo_custom == "COMPLETED"){
			                          $stp5 = "transit";
			                        }elseif($data->origin_impo_expo_custom == "STANDING BY"){
			                          $stp5 = "standing-by";
			                        }else{
			                          $stp5 = "";
			                        }
			                      ?>
								<tr>
								  <td>ORIGIN IMPO / EXPO CUSTOMS</td>
								  <td class="<?php echo $stp5;?>">
								  	<label><?php if(@$data->origin_impo_expo_custom){ echo $data->origin_impo_expo_custom;}?>
								  	</label>
								  </td>								  		  
								</tr>
								<?php
			                        if($data->destination_impo_expo_custom == "PENDING"){
			                          $stp6 = "pending";
			                        }elseif($data->destination_impo_expo_custom == "COMPLETED"){
			                          $stp6 = "transit";
			                        }elseif($data->destination_impo_expo_custom == "STANDING BY"){
			                          $stp6 = "h3r";
			                        }else{
			                          $stp6 = "";
			                        }
			                      ?>
								<tr>
									<td>IMPO / EXPO CUSTOMS</td>
									<td class="<?php echo $stp6;?>">
										<label>
											<?php if(@$data->destination_impo_expo_custom){ echo $data->destination_impo_expo_custom;}?>
										</label>
									</td>								
								</tr>
							  </tbody>
							</table>
							
							 <h3>.</h3>
							  
							<!--<table class="table table-striped track-qoute">
							  <thead>
								<tr>
								  <th>STEP</th>
								  <th>STATUS</th>								  
								</tr>
							  </thead>
							  <tbody>
								<tr>
								  <td>CARGO FLOW STEP 1</td>
								  <td class="pending1">PENDING</td>								 								  
								</tr>
								<tr>
								  <td>CARGO FLOW STEP 2</td>
								  <td class="transit1">COLLECTED / IN TRANSIT</td>								  		  
								</tr>
								<tr>
								  <td>CARGO FLOW STEP 3</td>
								  <td class="standing-by1">STANDING BY</td>								
								</tr>
								<tr>
								  <td>CARGO FLOW STEP 4</td>
								  <td class="pending1">PENDING</td>								 								  
								</tr>
								<tr>
								  <td>CARGO FLOW STEP 5</td>
								  <td class="transit1">COLLECTED / IN TRANSIT</td>								  		  
								</tr>
								<tr>
								  <td>CARGO FLOW STEP 6</td>
								  <td class="standing-by1">STANDING BY</td>								
								</tr>
							  </tbody>
							</table>-->
			    	    </div>
				    </div>                  
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection