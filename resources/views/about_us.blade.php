@extends('layouts.app')
@section('content')
<div class="container-fluid airShpmain">        
	<div class="container contactus">
		<div class="airShipping">
			<div class="row">
			  <div class="panel panel-default">
				  <div class="panel-heading">{{ trans('messages.About Us') }}</div>
					<div class="panel-body">
						<div class="col-md-12 about-us">

							<p class="about">{{ trans('messages.We are a B2B Freight Services for the International Trade E-commerce')}}.</p>
							<p class="about">
								{{ trans('messages.EaseFreight comes as an initiative of two friends, professionals in the Logistics and International commerce fields, who had the firm intention of facilitating the integration between Freight Services Sellers and the SME’s Freight Services Buyers. Since the access to freight services information is so complex for these enterprises') }}.</p>
							<p class="about">{{ trans('messages.All this, after years of identifying the opportunities offered by the new developments in IT, the SME Freight Services Buyer general ignorance on the subject and last but not least the failures in the trading of Freight Services and the associated costs of opportunity both in time and money') }}.</p>
							<p class="about about-heading"><b>{{ trans('messages.What EaseFreight pretends') }}</b>:</p>
							<p class="about">{{ trans('messages.To facilitate the import/export process of merchandises in Colombia and the world') }}.</p>
							<p class="about">{{ trans('messages.This initiative pretends, through a multilateral platform via web/app, to introduce a new and easy way to access international transportation and logistics information in between others: logistics service suppliers, costs, times and departures. As well as to provide the best three quotes from three of the inscribed freight forwarders, for each specific request for quote. These freight forwarders will be rated by user experience and these ratings will serve as a fiable reference which intends to provide security and transparence to the process. On-line booking and payment based on instant and case by case quotes, giving a better understanding of the market, will provide the sector with a better education and a stronger growth. To make swifter processes through electronic documentation and the interaction of a platform holding both ends of the deal, will contribute with higher time and process efficiencies when hiring and operating international transportation') }}.</p>
							<p class="about">{{ trans('messages.By all this, EaseFreight pretends to generate a freight commerce with') }}:</p>
							<p class="about about-p"><b>{{ trans('messages.Security') }}.</b></p>
							<p class="about about-p"><b>{{ trans('messages.Transparency') }}.</b></p>
							<p class="about about-p"><b>{{ trans('messages.Swiftness') }}.</b></p>
							<p class="about"><b>{{ trans('messages.Ease')}}, </b>{{ trans('messages.when contracting these services on-line') }}</p>
							<p class="about">{{ trans('messages.Likewise, to increase the volume of international transportation business in Colombia, while serving as a facilitator of the same, introducing new users. Increasing the countries impo/expo we expect a notorious improvement in the overall productivity, pretending to contribute with employment generation and commercial interchange') }}.</p>
			    	 </div>
				  </div>                  
			   </div>
			</div>
		</div>
	</div>
</div>
@endsection