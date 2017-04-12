@extends('layouts.app')
@section('content')
<div class="container-fluid airShpmain">        
	<div class="container contactus">
		<div class="airShipping">
			<div class="row">
			  <div class="panel panel-default">
				  <div class="panel-heading">{{ trans('messages.How to make unit convertions') }}</div>
					<div class="panel-body">
						<div class="col-md-12 news conversion">
							<table class="table table-bordered">
								<tr><th>Metric</th><th colspan="2">UNIT / UNIDAD</th><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th></tr>
								<tr><th>Métrico</th><th>ES</th><th>EN</th><th>Imperial</th><th>ES</th><th>EN</th></tr>
								<tr><td>1</td><td>milimetro(s)</td><td>milimeter(s)</td><td>0.03937</td><td>pulgadas</td><td>inches</td></tr>	
								<tr><td>1</td><td>centimetro(s)</td><td>centimeter(s)</td><td>0.3937</td><td>pulgadas</td><td>inches</td></tr>			
								<tr><td>1</td><td>metro(s)</td><td>meter(s)</td><td>3.28084</td><td>pie(s)</td><td>foot/feet</td></tr>
							</table>
							<table class="table table-bordered">
								<tr><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th><th>Metric</th><th colspan="2">UNIT / UNIDAD</th></tr>		
								<tr><th>Imperial</th><th>ES</th><th>EN</th><th>Métrico</th><th>	ES</th><th>EN</th></tr>
								<tr><td>1</td><td>pulgadas</td><td>inches</td><td>2.54</td><td>centimetros</td><td>centimeter</td></tr>		
								<tr><td>1</td><td>pie(s)</td><td>foot/feet</td><td>0.3048</td><td>metros</td><td>meters</td></tr>
								<tr><td>1</td><td>yarda</td><td>yard</td><td>0.9144</td><td>metros</td><td>meters</td></tr>
							</table>
							<table class="table table-bordered">
								<tr><th>Metric</th><th colspan="2">UNIT / UNIDAD</th><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th></tr>
								<tr><th>Métrico</td><td>ES</td><td>EN</td><td>Imperial</td><td>ES</td><td>EN</th></tr>
								<tr><td>1</td><td>cm2</td><td>cm2</td><td>0.155</td><td>pulgada2</td><td>sq inch</td></tr>
								<tr><td>1</td><td>m2</td><td>m2</td><td>10.76391</td><td>pies2</td><td>	sq foot</td></tr>
							</table>							
								
							<table class="table table-bordered">
								<tr><th> Imperial</th><th colspan="2">UNIT / UNIDAD</th><th>Metric</th><th colspan="2">UNIT / UNIDAD</th></tr>			
								<tr><th> Imperial</td><td>ES</td><td>EN</td><td>Métrico	ES	EN</th></tr>	
								<tr><td> 1</td><td>pulgada2</td><td>sq inch</td><td>6.4516</td><td>centimetro2</td><td>sq centimeter</td></tr>	
								<tr><td> 1</td><td>pies2</td><td>sq foot</td><td>0.0929</td><td>metro2</td><td>sq meter</td></tr>
							</table>
							<table class="table table-bordered">						
								<tr><th>Metric</th><th colspan="2">UNIT / UNIDAD</th><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th></tr>			
								<tr><th>Métrico</th><th>ES</th><th>EN</th><th>Imperial</th><th>ES</th><th>EN</th></tr>
								<tr><td>1</td><td>centimetro3</td><td>cb centimetre</td><td>0.061</td><td>pulgada(s)3</td><td>cb inch</td></tr>	
								<tr><td>1</td><td>metro3</td><td>cb meter</td><td>35.314667</td><td>pie(s)3</td><td>cb feet	</td></tr>
							</table>
							<table class="table table-bordered">	
								<tr><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th><th>Metric</th><th colspan="2">UNIT / UNIDAD</th></tr>
								<tr><th>Imperial</th><th>ES</th><th>EN</th><th>Métrico</th><th>ES</th><th>EN</th></tr>
								<tr><td>1</td><td>pulgada(s)3</td><td>cb inch</td><td>16.387 cm3</td><td>centimetro3</td><td>cb centimetre</td></tr>
								<tr><td>1</td><td>pie(s)3</td><td>cb feet</td><td>0.0283 m3</td><td>metro3</td><td>cb meter</td></tr>
							</table>
							<table class="table table-bordered">						
								<tr><th>Metric</th><th colspan="2">UNIT / UNIDAD</th><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th><th>USA</th><th colspan="2">UNIT / UNIDAD</th></tr>
								<tr><th>Métrico</th><th>ES</th><th>EN</th><th>Imperial</th><th>ES</th><th>EN</th><th>EEUU</th><th>ES</th><th>EN</th></tr>
								<tr><td>1</td><td>kilogramo</td><td>kilogram</td><td>2.2046</td><td>libra(s)</td><td>pound(s)</td></tr>
								<tr><td>1</td><td>tonelada</td><td>metric ton</td><td>0.9842</td><td>tonelada</td><td>larga	long</td><td>ton</td><td>1.1023	tonelada corta</td><td>short ton</td></tr>
							</table>
							<table class="table table-bordered">	
								<tr><th>Imperial</th><th colspan="2">UNIT / UNIDAD</th><th>Metric</th><th colspan="2">UNIT / UNIDAD	</th><th>USA</th><th colspan="2">UNIT / UNIDAD</th></tr>
								<tr><th>Imperial</th><th>ES</th><th>EN</th><th>Métrico</th><th>ES</th><th>EN</th><th>EEUU</th><th>ES</th><th>EN</th></tr>
								<tr><td>1</td><td>libra(s)</td><td>pound(s)</td><td>0.4536</td><td>kilogramo</td><td>kilogram</td><td></td></td><td></td><td></tr>		
								<tr><td>1</td><td>tonelada larga</td><td>long ton</td><td>1.016</td><td>tonelada</td><td>metric ton</td><td>1.12</td><td>tonelada corta</td><td>short ton</td></tr>
							</table>
							<table class="table table-bordered">								
								<tr><th>USA</th><th colspan="2">UNIT / UNIDAD</th><th>Metric</th><th colspan="2">UNIT / UNIDAD</th><th>Imperial</th><th colspan="2">UNIT / UNIDAD	</th></tr>
								<tr><th>EEUU</th><th>ES</th><th>EN</th><th>Métrico</th><th>ES</th><th>EN</th><th>Imperial</th><th>ES</th><th>EN</th></tr>
								<tr><td>1</td><td>tonelada corta</td><td>short ton</td><td>0.9071</td><td>tonelada</td><td>metric ton</td><td>0.8928</td><td>tonelada larga</td><td>long ton</td></tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection