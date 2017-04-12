@extends('layouts.app')
@section('content')
<div class="container-fluid airShpmain">        
	<div class="container contactus">
		<div class="airShipping">
			<div class="row">
			  <div class="panel panel-default">
				  <div class="panel-heading">{{ trans('messages.How_to_calculate') }}</div>
					<div class="panel-body">
						<div class="col-md-12 news">
							<div class="col-md-10 news-fiels">
								<h4>
									<p class="cube">{{ trans('messages.Simply_be_sure') }}</p>
								</h4>
								<table>
									<tr>
										<td>L</td>
										<td>{{ trans('messages.length') }}</td>
									</tr>
									<tr>
										<td>{{ trans('messages.W') }}</td>
										<td>{{ trans('messages.width') }}</td>
									</tr>
									<tr>
										<td>H</td>
										<td>{{ trans('messages.height') }}</td>
									</tr>
								</table>
								<p>{{ trans('messages.If_you_want') }}</p>
								<h4>{{ trans('messages.Example') }}</h4>
								<img src="{{ URL::asset('assets/images/HOW_TO_CUBE.png') }}" width="705px" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection