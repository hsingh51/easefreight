@extends('layouts.app')
@section('content')
<div class="container-fluid airShpmain">        
	<div class="container contactus">
		<div class="airShipping">
			<div class="row">
			  <div class="panel panel-default">
				  <div class="panel-heading">{{ trans('messages.ServiceS') }}</div>
					<div class="panel-body">
						<div class="col-md-12 services">

						 <h4>1. {{ trans('messages.Our Services for the User, Freight Services Buyer')}}.</h4> 
						<p class="service">{{ trans('messages.Our allied Freight Forwarders offer LCL services for both Air-freight and Ocean-freight and FCL services for Containerized Ocean-freight, through the EASEFREIGHT platform')}}.</p>
						<ul>
							<li>{{ trans('messages.Door to Door or any other in between combination as Port to Door or Door to Port')}}.</li>
							<li>{{ trans('messages.Local and Foreign Customs Agency')}}.</li>
							<li>{{ trans('messages.Document Elaboration')}}.</li>
							<li>{{ trans('messages.Processes with Local Authorities')}}.</li>
							<li>{{ trans('messages.International Cargo Insurance')}}.</li>
							<li>{{ trans('messages.Local Inland Transportation')}}.</li>
							<li>{{ trans('messages.Special Services')}}.</li>
							<li>{{ trans('messages.Cargo tracking process')}}.</li>
						</ul>
						<p class="service">{{ trans('messages.All this while')}}:</p>
						<p class="service">{{ trans('messages.Getting at least 3 different instant quotes for you to compare.
								Multiple options & transparency which speeds the decision process.
								Getting on line support on any inquiry')}}.</p>
						<p class="service">{{ trans('messages.Visibility on issues like sellers, costs and times')}}.</p>
						<p class="service">{{ trans('messages.Full quote in 48 hours')}}.</p>
						<p class="service">{{ trans('messages.Online booking and payment through our platform')}}.</p> 
						 <h4>2. {{ trans('messages.Our Services for the Freight Forwarder, Freight Services Seller')}}.</h4>
						<ul>
							<li>{{ trans('messages.Data Mamagement')}}.</li>
						</ul>
						<p class="service">{{ trans('messages.Not just this, you receive')}}:</p>
						<ul>
							<li>{{ trans('messages.Quote automatization, as per clients request, minimizing the quote elaboration time')}}</li>
							<li>{{ trans('messages.Increase your company’s exposure to thousands of new potential customers')}}.</li>
							<li>{{ trans('messages.Minimize manual errors made on the quoting operation and invoicing procedures, that not only cost money but hurt the relation with clients')}}</li>
							<li>{{ trans('messages.Increases the probability of closing business')}}.</li>
							<li>{{ trans('messages.We help you organize your activities in order for you not to miss a deadline')}}.</li>
						</ul>



			    	 </div>
				  </div>                  
			   </div>
			</div>
		</div>
	</div>
</div>
@endsection