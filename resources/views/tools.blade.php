@extends('layouts.app')
@section('content')
	<div class="container-fluid airShpmain">        
		<div class="container contactus">
			<div class="airShipping">
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading">{{ trans('messages.ToolS') }}</div>
						<div class="panel-body">
							<div class="col-md-12 tool">
								<!-- <p class="tools">{{ trans('messages.The below tools are incorporated into the system to help the user have a fluid and short experience while the platform interact with him') }}.
								</p>
								<ul>
									<li>{{ trans('messages.Unit Converter') }}.</li> 
									<li>{{ trans('messages.DIAN Product Tariff classification')}}.</li>
									<li>{{ trans('messages.How to cube') }}.</li>
								</ul> -->
								<div id="accordion_tool">
				                    <h3>{{ trans('messages.How_to_calculate') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated">
											<div class="tools-cube"><h4>
												<p>{{ trans('messages.Simply_be_sure') }}</p>
											</h4>
											<table>
												<tr>
													<td>L</td>
													<td>{{ trans('messages.length') }}</td>
												</tr>
												<tr>
													<td>W</td>
													<td>{{ trans('messages.width') }}</td>
												</tr>
												<tr>
													<td>H</td>
													<td>{{ trans('messages.height') }}</td>
												</tr>
											</table>
											<p>{{ trans('messages.If_you_want') }}</p></DIV>
											<h4>{{ trans('messages.Example') }}</h4>
											<img src="{{ URL::asset('assets/images/HOW_TO_CUBE.png') }}" width="920" />
										</div>
									</div>
				                    <h3>{{ trans('messages.How to make unit convertions') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated">
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
				                    <h3>{{ trans('messages.Container Specification') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated">
											<img src="{{ URL::asset('assets/images/containter.png') }}" width="920px" />
											<p></p>
											<h4>{{ trans('messages.DIMENSIONS AND CAPACITIES') }}</h4>
											<img src="{{ URL::asset('assets/images/container-147973.png') }}" width="920px" class="tool-img"/>
										</div>
									</div>
									<h3>{{ trans('messages.Pallet Specs AFR') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated1">
											<h5>{{ trans('Most commonly used pallets and air cargo containers, called Unit Load Devices (ULD). By using standardized ULDs it is possible to group a large amount of load into a single unit..') }}</h5>
											<img src="{{ URL::asset('assets/images/lD1.png') }}" width="920px" />
											<p>&nbsp;</p>
											<img src="{{ URL::asset('assets/images/lD2.png') }}" width="920px" />
											<p>&nbsp;</p>
											<img src="{{ URL::asset('assets/images/lD3.png') }}" width="920px" />
											<p>&nbsp;</p>
											<img src="{{ URL::asset('assets/images/lD4.png') }}" width="920px" />
											<h4>{{ trans('messages.Most commonly used pallets and air cargo containers, called Unit Load Devices (ULD). By using standardized ULDs it is possible to group a large amount of load into a single unit.') }}</h4>
											<p>{{trans('messages.Determine the characteristics of the goods to be transported (cargo description)') }}</p>
											<p>{{trans('messages.Cargo packing: It is the final packaging unit used by the customer to carry their cargo, cartons, barrels, lids and wooden bases, etc.') }}</p>
											<p>{{trans('messages.Uniformity of the load In order to determine more precisely the volume of a load, it must be determined whether the delivered load is uniform (packed in boxes of the same dimensions) or the customer uses different packing units (for cubing, We must have the information of the load, with dimensions and quantities of pieces with equal dimensions). Packing List') }}</p>
											<h4>{{trans('messages.Cylindrical parts:') }}</h4>
											<p>{{trans('messages.They are pieces whose width and height is determined by the radius of the piece to be exported.)') }}</p>
											<p>{{trans('messages.Palletizing: When palletizing cylindrical parts, it must be taken into account that there are spaces that are lost by the same round shape of the bases of these pieces, and these lost spaces are included within the collection of space or freight that is charged to the exporter.') }}</p>
											<h4>{{trans('messages.Cubic parts') }}</h4>
											<p>{{trans('messages.Palletizing: Because of its cubic shape, it is possible to achieve a better optimization of the space, it is necessary to know the internal measures of the palletization unit to accommodate the boxes in the best possible way to give the shape of the pallet.)') }}</p>
											<h4>{{trans('messages.Dense load') }}</h4>
											<p>{{trans('messages.When the volume of the long load x width x height of a piece and dividing it by a constant ratio of 6000 determines a volume weight lower than the physical and actual weight of the load. Voluminous load: When the volume of the load that has multiplied the length-width and height of a piece and is divided by a constant ratio of 6000 determines a volume weight greater than the physical and real weight of the load.') }}</p>
											<h4>{{trans('messages.Extra-dimensioned load') }}</h4>
											<p>{{trans('messages.It is the cargo that, due to its dimensions, is larger than the dimensions of a pallet or packaging unit of an airplane and this demands special handling for transport. Cargo that can not be transported by plane due to its dimensions:') }}</p>
										</div>
									</div>
									<h3>{{ trans('messages.Pallet Specs OFR') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated2">
											<h4>{{ trans('messages.ISO PALLETS') }}</h4>
											<p>{{trans('messages.The International Organization for Standardization (ISO) sanctions six pallet dimensions, detailed in ISO Standard 6780.') }}</p>
											<img src="{{ URL::asset('assets/images/ofr.png') }}" width="920px" />
											<p></p>
											<img src="{{ URL::asset('assets/images/ofr_screen_shot.png') }}" width="920px" />
										</div>
									</div>
									<h3>{{ trans('messages.OFR Vocabulary') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated3">
											<h4>{{ trans('messages.CUSTOMS') }}</h4>
											<p>{{trans('messages.They are the places authorized for the entry or exit of the national territory of goods and the means in which they are transported or driven.') }}</p>
											<h4>{{ trans('messages.AFFORD') }}</h4>
											<p>{{trans('messages.The activity is to recognize the merchandise, verify its nature and value, establish its weight, account or measure, classify it in the tariff nomenclature and determine the levies applicable to it.') }}</p>
											<h4>{{ trans('messages.CUSTOMS AGENT CUSTOMS INTERMEDIATE PARTNERSHIP (CIS)') }}</h4>
											<p>{{trans('messages.According to Decree 2685, the Customs Brokerage Company (SIA) whose main corporate purpose is the exercise of customs brokerage, is the only one that can complete the customs formalities when the export exceeds the amount for courier.') }}</p>
											<h4>{{ trans('messages.MARITIME AGENT / FLUVIAL') }}</h4>
											<p>{{trans('messages.Peruvian legal person authorized by the General Directorate of Aquatic Transport to intervene, at the appointment of the general agent or on behalf of the shipping company or Shipowner, in the operations of the ships in the Port Terminals') }}</p>
											<h4>{{ trans('messages.STORAGE') }}</h4>
											<p>{{trans('messages.It is the service that lends itself to the cargo that remains in the places of deposit determined by the company.') }}</p>
											<h4>{{ trans('messages.CUSTOMS WAREHOUSES') }}</h4>
											<p>{{trans('messages.Open or closed premises intended for the temporary placement of the goods as long as their dispatch is requested.') }}</p>
											<h4>{{ trans('messages.PILE ON') }}</h4>
											<p>{{trans('messages.Place the load neatly on top of each other in the storage areas.') }}</p>
											<h4>{{ trans('messages.ARMADOR') }}</h4>
											<p>{{trans('messages.The natural or legal person who owns the ship, or who, without it, has it in charter. In any of the cases, it is the one that conditions the ship for its exploitation, obtaining yield of the freight of the merchandise or transport of passengers. 17. Gross Tonnage: It is the expression of the total volume of a ship, determined in accordance with the existing international and national provisions.') }}</p>
											<h4>{{ trans('messages.ARRIVAL') }}</h4>
											<p>{{trans('messages.Arrival of the boat to a port to load or unload, or to avoid some danger.') }}</p>
											<h4>{{ trans('messages.STORAGE') }}</h4>
											<p>{{trans('messages.Temporary placing of the merchandise in areas near the ship') }}</p>
											<h4>{{ trans('messages.ATTRACTION') }}</h4>
											<p>{{trans('messages.Operation of driving the ship from the official anchorage of the port and docking it to the dock or designated berth.') }}</p>
											<h4>{{ trans('messages.CABOTAGE') }}</h4>
											<p>{{trans('messages.Transport service between national ports, terminals and marinas') }}</p>
											<h4>{{ trans('messages.CALADO') }}</h4>
											<p>{{trans('messages.It is the submerged depth of a ship in the water.') }}</p>
											<h4>{{ trans('messages.MARINE ACCESS CHANNEL') }}</h4>
											<p>{{trans('messages.Natural or artificial maritime space used as a transit of ships, to enable them to access or withdraw from port facilities.') }}</p>
											<h4>{{ trans('messages.CONSOLIDED CHARGE') }}</h4>
											<p>{{trans('messages.Grouping of goods belonging to one or more consignees, assembled to be transported from one port to another in containers, provided that they are covered by the same shipping document.') }}</p>
											<h4>{{ trans('messages.CONTAINED LOAD') }}</h4>
											<p>{{trans('messages.Cargo handled in containers that are interchanged between modes of transport.') }}</p>

											<h4>{{ trans('messages.UNITARIZED GENERAL LOADING') }}</h4>
											<p>{{trans('messages.It is the grouping of a number of articles to form a shipping unit to facilitate its handling. For example pallets, containers and vehicles.') }}</p>
											<h4>{{ trans('messages.GENERAL LOADING, FRACTIONED OR RELEASED') }}</h4>
											<p>{{trans('messages.It is the load that is handled in sacks, boxes, packages, bales, pieces, machinery, etc.') }}</p><h4>{{ trans('messages.TARIFF CLASSIFICATION') }}</h4>
											<p>{{trans('messages.It is the classification of the goods object of the foreign trade operation that must be presented by importers, exporters through customs brokerage companies, prior to the foreign trade operation that they intend to carry out.') }}</p>
											<h4>{{ trans('messages.CFR') }}</h4>
											<p>{{trans('messages.The term by which the seller assumes all the costs of transporting the merchandise to the agreed place of destination, but the risk of loss or damage thereof or any increase in costs is transferred from the seller to the buyer as soon as the merchandise passes The edge of the ship, at the port of embarkation.') }}</p>
											<h4>{{ trans('messages.CIF') }}</h4>
											<p>{{trans('messages.Purchase clause that includes the value of the goods in the country of origin, freight and insurance to the point of destination.') }}</p>
											<h4>{{ trans('messages.BOARDING KNOWLEDGE (BL)') }}</h4>
											<p>{{trans('messages.Document that accredits the possession and / or ownership of the cargo.') }}</p>
											<h4>{{ trans('messages.CONSIGNEE') }}</h4>
											<p>{{trans('messages.Natural or legal person in whose name the goods are manifested or acquired by endorsement.') }}</p>

											<h4>{{ trans('messages.CONSOLIDATION OF LOAD') }}</h4>
											<p>{{trans('messages.Filling of a container with merchandise from one, two or more shippers.') }}</p>
											<h4>{{ trans('messages.CONTAINER') }}</h4>
											<p>{{trans('messages.Square or rectangular box, intended to transport and store all types of products and packaging, which encloses and protects the contents of losses and damages, which can be driven by any means of transport, handled as a "loading unit" and transferred without remanipulation. content.') }}</p>
											<h4>{{ trans('messages.GANG') }}</h4>
											<p>{{trans('messages.Group of stevedores that in a port are occupied in stowing the merchandise aboard the ships, as well as of its landing.') }}</p>
											<h4>{{ trans('messages.DEMURRAGE (Containers: delay)') }}</h4>
											<p>{{trans('messages.Fees charged for the use of the container beyond the days granted before returning to the yard established in the lending') }}</p>
											<h4>{{ trans('messages.CUSTOMS DEPOSITS ENABLED') }}</h4>
											<p>{{trans('messages.Premises destined to store merchandise requested to the regime of Customs Deposit.') }}</p>
											<h4>{{ trans('messages.STOWAGE') }}</h4>
											<p>{{trans('messages.It is the process of accommodating the load in a warehouse space, dock or means of transport.') }}</p>
											<h4>{{ trans('messages.FOB') }}</h4>
											<p>{{trans('messages.Purchase clause that considers the value of the merchandise placed on board the vehicle in the country of origin, excluding insurance and freight. The risk or loss of damage of the merchandise is transferred from the seller to the buyer when it passes the ships edge.') }}</p>
											<h4>{{ trans('messages.FOUNDATION') }}</h4>
											<p>{{trans('messages.Operation to drive the ship to the official anchorage of the port. 71.Infrastructure for Water Access: Consists of canals, approach zones, defense works (breakwaters, breakwaters, locks) and signaling (lights, buoys) that are in the aquatic operations area.') }}</p>
											<h4>{{ trans('messages.HAZARDOUS GOODS') }}</h4>
											<p>{{trans('messages.They are classified as hazardous goods for which there are regulations regarding their procedure of acceptance, packaging, stowage, documentation and transportation for either local or international transportation. There are nine (9) classifications of dangerous goods for international shipping and regulations, documentation, acceptance procedures, packaging and stowage are established by the International Maritime Organization (IMO).') }}</p>


											<h4>{{ trans('messages.PORT OPERATOR') }}</h4>
											<p>{{trans('messages.Legal entity incorporated or domiciled in the country, which is authorized to provide, in port areas, services to ships, cargo and / or passengers.') }}</p>
											<h4>{{ trans('messages.TOWAGE') }}</h4>
											<p>{{trans('messages.Service provided by tugboats to pull, push, support or assist the ship during port operations.') }}</p>
											<h4>{{ trans('messages.LINER SERVICE') }}</h4>
											<p>{{trans('messages.It is the regular freight service with vessels subject to predetermined routes between ports that are operated at periodic intervals and has predetermined freight rates.') }}</p>
												<h4>{{ trans('messages.CONTAINER TARE') }}</h4>
											<p>{{trans('messages.Weight of the empty container, whose average weight is of 2.1 tons for container of 20 feet and of 3.5 tons for container of 40 feet.') }}</p>
											<h4>{{ trans('messages.TALLY') }}</h4>
											<p>{{trans('messages.Document that records the number, condition and characteristics of the cargo.') }}</p>
											<h4>{{ trans('messages.PORT TERMINAL') }}</h4>
											<p>{{trans('messages.The unit established in a port or outside it, consisting of works, installations and surfaces, including its water zone, which allows the complete operation of the port operation for which it is intended.') }}</p>
											<h4>{{ trans('messages.TEU') }}</h4>
											<p>{{trans('messages.Unit equivalent to a 20-foot-long container. Acronym of the term "Twenty Equivalent Unit".') }}</p>
											<h4>{{ trans('messages.TRANSHIPMENT') }}</h4>
											<p>{{trans('messages.Transfer of goods effected under customs control from the same customs office, from one transport unit to another, or on a different journey, including its unloading to the ground, in order to continue to its destination.') }}</p>
											<h4>{{ trans('messages.TRANSIT') }}</h4>
											<p>{{trans('messages.Passage of foreign goods across the country when it forms part of a total journey started abroad and must be completed outside its borders. Also considered as transit of goods is the dispatch of foreign goods abroad that have been unloaded by mistake or other qualified causes in the primary zones or places enabled, provided that they have not left those premises and that their arrival in the country And Subsequent shipment to the exterior is made by sea or air.') }}</p>
											<h4>{{ trans('messages.BONDED TRANSPORTATION') }}</h4>
											<p>{{trans('messages.Customs procedure under which goods subject to customs control are transported from one customs zone to another.') }}</p>
											<h4>{{ trans('messages.INLAND TRANSPORTATION') }}</h4>
                                            <p>{{trans('messages.Transportation of persons or goods loaded in a place located within the national territory to be landed or unloaded in a place located within the same national territory.') }}</p>
                                            <h4>{{ trans('messages.TRANSPORTERS') }}</h4>
                                            <p>{{trans('messages.Company who actually transports the goods or who has the command or responsibility of the means of transportation.') }}</p>
                                            <h4>{{ trans('messages.DECLARED VALUE') }}</h4>
                                            <p>{{trans('messages.Economic value of the cargo in order to establish customs duties of the goods contained in a shipment that are subject to the same customs regime and classified under the same tariff heading.') }}</p>
                                            <h4>{{ trans('messages.FREE ZONE') }}</h4>
                                            <p>{{trans('messages.Part of the national territory in which the customs regime allows goods to be received without payment of import duties.') }}</p>
                                            <h4>{{ trans('messages.PRIMARY CUSTOMS ZONE') }}</h4>
                                            <p>{{trans('messages.Part of the customs territory that includes the customs, aquatic or terrestrial spaces destined or authorized for operations of landing, loading, mobilization or deposit of the goods; Offices, premises or units for the direct customs service; Airports, land or roads and any other place where customs operations are normally carried out.') }}</p>
                                            <h4>{{ trans('messages.FREIGHT ALL KIND (FAK)') }}</h4>
                                            <p>{{trans('messages.Cargo of all types to which a spicific rate for container is applied.') }}</p>
                                            <h4>{{ trans('messages.BAF (Bunker Adjustment Factor)') }}</h4>
                                           <p>{{trans('messages.It is a surcharge applied by shipping lines, this surcharge will be adjusted accordingly with bunker price variatons without previous notice.') }}</p>
                                             <h4>{{ trans('messages.CAF (Currency Adjustment Factor)') }}</h4>
                                           <p>{{trans('messages.It is an extra charge applied by the shipping lines. The CAF is due to currency fluctuations. Should any variation affecting the costs of the shipping lines occur, this surcharge will be automatically adjusted, according to the changes.') }}</p>
                                           <h4>{{ trans('messages.PCS (Panama Canal Surcharge)') }}</h4>
                                         <p>{{trans('messages.Surcharge applied to cago transiting through the Panama Canal') }}</p>
                                         <h4>{{ trans('messages.PSS (Peak Season Surcharge)') }}</h4>
                                           <p>{{trans('messages.It is a surcharge in periods of peak demand to reduce traffic congestion.') }}</p>
                                            <h4>{{ trans('messages.THC (Terminal Handling Charge)') }}</h4>
                                           <p>{{trans('messages.Charge for the handling of goods at the port terminal.') }}</p>

											




											
										</div>
									</div>
									<h3>{{ trans('messages.AFR Vocabulary') }}</h3>
									<div class="box-body ">
										<div class="col-md-12 col-sm-12 estimated4">
											<h4>{{ trans('messages.AIR WAY BILL (AWB)') }}</h4>
                                           <p>{{trans('messages.Bill of lading which covers both domestic and international flights transporting goods to a specified destination. Technically, it is a non-negotiable instrument of air transport which serves as a receipt for the shipper, indicating that the carrier has accepted the goods listed therein and obligates itself to carry the consignment to the airport of destination according to specified conditions.') }}</p>
                                           <h4>{{ trans('messages.ACT OF GOD') }}</h4>
                                          <p>{{trans('messages.Damage to goods occurred without the intervention of human elements.') }}</p>
                                           <h4>{{ trans('messages.CONTAINERISED AIRCRAFT') }}</h4>
                                           <p>{{trans('messages.An aircraft in which cargo compartments are equipped with ULDs and restraint system, in a convenient order to accommodate overhead containers or pallets. This can be any airplane, whether it is a narrow cabin or a wide cabin.') }}</p>
                                             <h4>{{ trans('messages.ALL CARGO AIRCRAFT') }}</h4>
                                           <p>{{trans('messages.An airplane that carries cargo exclusively') }}</p>
                                            <h4>{{ trans('messages.DEPOSIT WAREHOUSE') }}</h4>
                                           <p>{{trans('messages.A place where goods can be stored for an indefinite period without being subject to import duties.') }}</p>
                                            <h4>{{ trans('messages.CHARGES CORRECTION ADVICE (CCA)') }}</h4>
                                           <p>{{trans('messages.A document used to notify changes in charges to be paid for transportation and / or other charges or in the method of payment shown in the air waybill.') }}</p>
                                           <h4>{{ trans('messages.BROKER AGENT') }}</h4>
                                           <p>{{trans('messages.Person or company who serves as a trusted agent or intermediary in commercial negotiations or transactions. Brokers are usually licensed professionals in fields where specialized knowledge is required, such as international transportation.') }}</p>
                                           <h4>{{ trans('messages.CARGO HOLD') }}</h4>
                                           <p>{{trans('messages.Space confined to transport of cargo, mail and luggage under the main deck of the airplane.') }}</p>
                                           <h4>{{ trans('messages.HIGH DENSITY CARGO') }}</h4>
                                           <p>{{trans('messages.Cargo whose weight is high compared to its volume.') }}</p>
                                               <h4>{{ trans('messages.LOW DENSITY CARGO') }}</h4>
                                           <p>{{trans('messages.Cargo whose weight is low compared to its volume.') }}</p>
                                            <h4>{{ trans('messages.TERMINAL CHARGES') }}</h4>
                                           <p>{{trans('messages.They are charges such as collection, delivery, storage, customs release, etc. These are established locally by the authorities.') }}</p>
                                             <h4>{{ trans('messages.SHIPPING INSTRUCTIONS') }}</h4>
                                           <p>{{trans('messages.Document containing the instructions of the shipper or its agent to prepare the documents and the shipment.') }}</p>
                                           <h4>{{ trans('messages.CERTIFICATE OF ORIGIN') }}</h4>
                                           <p>{{trans('messages.In a printed form or as an electronic document, it is completed by the exporter and certified by a recognized issuing body, attesting that the goods in a particular export shipment have been produced, manufactured or processed in a particular country. Document involved in the process that cargo needs to access tariff benefits in other countries.') }}</p>
                                             <h4>{{ trans('messages.WEIGHT CERTIFICATE') }}</h4>
                                           <p>{{trans('messages.Document where the weight of the merchandise (net and gross) is made per package of all the shipment and any other data tending to serve as proof in terms of weights that would have the goods at the time of issuance of the document.') }}</p>
                                             <h4>CFR</h4>
                                           <p>{{trans('messages.The term by which the seller assumes all the costs of transporting the merchandise to the agreed place of destination, but the risk of loss or damage thereof or any increase in costs is transferred from the seller to the buyer as soon as the merchandise passes The edge of the ship, at the port of embarkation.') }}</p>
                                           <h4>{{ trans('messages.VOYAGE CHARTER') }}</h4>
                                           <p>{{trans('messages.It is called voyage charter when ship is hired for any particular voyage. In this case freight is calculated keeping in view the distance and quantity of goods.') }}</p>
                                           <h4>{{ trans('messages.CONTRACT OF AFFREIGHTMENT') }}</h4>
                                           <p>{{trans('messages.It is a contract between the shipper and the shipping company. In this contract shipper agrees to hire the ship at settled price. This price is called affreight.') }}</p>
                                            <h4>CIF</h4>
                                           <p>{{trans('messages.Term of sale that includes the value of the goods in the country of origin, the freight and insurance to the point of destination.') }}</p>
                                           <h4>{{ trans('messages.CHARTER PARTY') }}</h4>
                                           <p>{{trans('messages.The documents on which the contract is made is called the charter party.') }}</p>
                                           <h4>{{ trans('messages.AIR FREIGHT DEMURRAGE') }}</h4>
                                           <p>{{trans('messages.Fees charged for the use of ULD during loading and unloading beyond a 48-hour period or as provided in the lease.') }}</p>
                                            <h4>{{ trans('messages.DOLLY') }}</h4>
                                           <p>{{trans('messages.Unpowered vehicle for cargo design for connection to a tractor unit, truck or prime mover vehicle with strong traction power.') }}</p>
                                           <h4>{{ trans('messages.PACKAGING') }}</h4>
                                           <p>{{trans('messages.Any container or deck on which the contents of a shipment are packaged.') }}</p>
                                            <h4>{{ trans('messages.COMMERCIAL INVOICE') }}</h4>
                                           <p>{{trans('messages.When used in foreign trade') }}</p>
                                            <h4>{{ trans('messages.CONSULAR INVOICE') }}</h4>
                                           <p>{{trans('messages.A consular invoice is a document, often in triplicate, submitted to the consul or embassy of a country to which goods are to be exported before the goods are sent abroad') }}</p>
                                           <h4>IATA</h4>
                                           <p>{{trans('messages.International Air Transportation Association, supports aviation with global standards for airline safety, security, efficiency and sustainability.') }}</p>
                                            <h4>{{ trans('messages.CARGO_mANIFEST') }}</h4>
                                           <p>{{trans('messages.Cargo document listing the cargo, passengers, and crew of a ship, aircraft, or vehicle, for the use of customs and other officials.') }}</p>
                                            <h4>{{ trans('messages.MARKS') }}</h4>
                                           <p>{{trans('messages.They are the symbols in the packages used to indicate the handling or identification of these.') }}</p>
                                           <h4>{{ trans('messages.DANGEROUS GOODS') }}</h4>
                                           <p>{{trans('messages.Merchandises classified as hazardous goods for which there are regulations regarding their procedure of acceptance, packaging, stowage, documentation and transportation for either local or international transportation. There are nine (9) classifications of dangerous goods for international shipping and regulations, documentation, acceptance procedures, packaging and stowage are established by the International Maritime Organization (IMO).') }}</p>
                                           <h4>{{ trans('messages.DELIVERY ORDER') }}</h4>
                                           <p>{{trans('messages.Authorization to deliver the shipment to another person who is not the consignee noted in the air waybill.') }}</p>
                                           <h4>{{ trans('messages.AIRFREIGHT PALLET') }}</h4>
                                           <p>{{trans('messages.It is a platform with a flat surface, manufactured according to the standard requirements of the aircraft, in which the goods are insured in the aircraft.') }}</p>
                                            <h4>{{ trans('messages.PLATFORM') }}</h4>
                                           <p>{{trans('messages.It is a defined area of the airport, where the aircraft is located for stowage and cargo unloading, passenger ascent and descent, fuel loading, parking or maintenance.') }}</p>
                                           <h4>{{ trans('messages.ULD POSITIONS') }}</h4>
                                           <p>{{trans('messages.The positions reserved for the stowage of containers in the main cabin and / or the lower cabin in a large-cabin wide-body aircraft or in a freighter aircraft.') }}</p>
                                            <h4>{{ trans('messages.UNIT LOAD DEVICE (ULD)') }}</h4>
                                           <p>{{trans('messages.A container in which the goods can be transported and which adapts and adjusts to the electronic system of retrenchment of the airplane; In this way it becomes an integral part of the aircraft') }}</p>
                                            <h4>{{ trans('messages.CARGO TRANSFER') }}</h4>
                                           <p>{{trans('messages.Cargo arriving at a designated transfer airport by one flight and continuing with a connecting flight from the same or connecting carrier.') }}</p>
                                            <h4>{{ trans('messages.CHARGEABLE WEIGHT') }}</h4>
                                           <p>{{trans('messages.Either the actual gross weight or volume weight of the cargo or the minimum weight of an applicable rate, whichever is higher. Is used to calculate the weight charge that is equal to: chargeable weight x rate per kg/lb.') }}</p>
                                             <h4>{{ trans('messages.CLASS RATE') }}</h4>
                                           <p>{{trans('messages.Large grouping of various items under one general group. The freight rates that apply to all items in the class are called class rates.') }}</p>
                                           <h4>{{ trans('messages.COMBI') }}</h4>
                                           <p>{{trans('messages.Aircraft configured for transportation of both passenger (only main deck) and air cargo on the main deck (on main deck and in belly holds).') }}</p>
                                           <h4>{{ trans('messages.COURRIER') }}</h4>
                                           <p>{{trans('messages.The person or company in charge of “accompanying” time sensitive documents and/or small parcels through the passenger baggage channels thereby avoiding the more time consuming customs procedures for freight.') }}</p>
                                           <h4>{{ trans('messages.DELIVERY SERVICE') }}</h4>
                                           <p>{{trans('messages.The carriage of inbound consignments from the airport to the address of the consignee or its designated agent or to the custody of the appropriate government agency, when required.') }}</p>






										</div>
									</div>
				                </div>
							</div>
			 			</div>                  
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection