<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar leftmenu">
    <ul class="sidebar-menu">
      <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}" >
        <a href="{{ newurl('/admin/dashboard') }}"> <i class="fa fa-dashboard"></i> <span>
          <?php //echo App::getLocale();?>
          {{ trans('messages.dashboard') }}</span> </a></li>
      <li class="{{ (Route::currentRouteName() == 'clientInformation') ? 'active' : '' }} treeview">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span>{{ trans('messages.client_information') }}</span>
          <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/shareHolders/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/shareHolders/View') }}"><i class="fa fa-circle"></i>
              <span>{{ trans('messages.legal_representative') }}</span> </a></li>
          <li class="{{ Request::is('admin/securityQuality') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/securityQuality') }}"> 
            <i class="fa fa-circle"></i> <span> {{ trans('messages.security_&_quality_system') }}</span> </a></li>
          <li class="{{ Request::is('admin/securityFinantialQuality') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/securityFinantialQuality') }}" 
              title="Financial Institution Operations For Using Foreign Trade"> 
              <i class="fa fa-circle"></i> <span> {{ trans('messages.financial_entity') }}</span> </a></li>
          <li class="{{ Request::is('admin/personInCharge/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/personInCharge/View') }}"> 
            <i class="fa fa-circle"></i> <span> {{ trans('messages.person_in_charge') }}</span> </a></li>
        </ul>
      </li>
      <li class="{{ (Route::currentRouteName() == 'route') ? 'active' : '' }} treeview">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span>{{ trans('messages.route') }}</span>
        <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/routeAFR/*') ? 'active' : '' }}"><a href="{{ newurl('/admin/routeAFR/View') }}"> 
            <i class="fa fa-circle"></i> <span>{{ trans('messages.AFR_RoutEs') }}</span> </a></li>
          <li class="{{ Request::is('admin/routeOcean/*') ? 'active' : '' }}"><a href="{{ newurl('/admin/routeOcean/View') }}"> 
            <i class="fa fa-circle"></i> <span>{{ trans('messages.OFR_RoutEs') }}</span> </a></li>
          <li class="{{ Request::is('admin/routeColombia/*') ? 'active' : '' }}"><a href="{{ newurl('/admin/routeColombia/View') }}"> 
            <i class="fa fa-circle"></i> <span>{{ trans('messages.Local_Inland_ROutes') }}</span> </a></li>
        </ul>
      </li>
      <li class="{{ (Route::currentRouteName() == 'air_rates') ? 'active' : '' }} treeview">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span> {{ trans('messages.airfreightrates') }}</span>
          <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/localTerminalAir/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/localTerminalAir/View') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.col_airport_rates') }}</span></a></li>
          
          <li class="{{ Request::is('admin/tarifasAFR/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/tarifasAFR/View') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.afr_rates') }}</span></a></li>
        </ul>
      </li>
      <li class="{{ (Route::currentRouteName() == 'rates') ? 'active' : '' }} treeview">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span> {{ trans('messages.ocean_freight_rates') }}</span>
        <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/localTerminalCOL/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/localTerminalCOL/View') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.col_port_rates') }} </span></a></li>
          <li class="{{ Request::is('admin/oceanLCL/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/oceanLCL/View') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.ofr_lcl_rates') }}</span></a></li>
          <li class="{{ Request::is('admin/oceanFCL/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/oceanFCL/View') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.ofr_fcl_rates') }}</span></a></li>
          
          <!-- <li class="">
            <a href="#"><i class="fa fa-circle"></i><span> Tarifas Adicionale</span>s</a></li> -->
          <!-- <li class="{{ Request::is('admin/localTerminal/Add') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/localTerminal/Add') }}"><i class="fa fa-circle"></i> Add Terminal Rates</a></li> -->
          <!-- <li class="{{ Request::is('admin/route/Add') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/route/Add') }}"><i class="fa fa-circle"></i> Add AFR</a></li> -->
        </ul>
      </li>
      <li class="{{ (Route::currentRouteName() == 'itinerary') ? 'active' : '' }} treeview">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span>{{ trans('messages.itineraries') }}</span>
          <i class="fa fa-angle-left pull-right"></i> </a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/routeItinerary/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/routeItinerary/View') }}"><i class="fa fa-circle"></i><span> {{ trans('messages.aereo_itineraries') }} </span></a></li>
          <!-- <li class="{{ Request::is('/admin/routeItinerary/Add') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/routeItinerary/Add') }}"><i class="fa fa-circle"></i>Add AFR</a></li> -->
          <li class="{{ Request::is('admin/ofrItinerary/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/ofrItinerary/View') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.itineraries OFR LCL / FCL') }} </span></a></li>
          <!-- <li class="{{ Request::is('admin/routeItinerary/*') ? 'active' : '' }} ">
            <a href="{{ newurl('/admin/routeItinerary/View') }}"><i class="fa fa-circle"></i> View Itinerary</a></li>
          <li class="{{ Request::is('admin/routeItinerary/Add') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/routeItinerary/Add') }}"><i class="fa fa-circle"></i> Add Itinerary</a></li> -->
        </ul>
      </li>
      <li class="{{ Request::is('admin/colombiaRates/*') ? 'active' : '' }}">
        <a href="{{ newurl('/admin/colombiaRates/View') }}"> <i class="fa fa-edit"></i>
        <span>{{ trans('messages.col_inland_trucking') }} </span> </a></li>
      <li class="{{ Request::is('admin/additionalRates/*') ? 'active' : '' }}">
        <a href="{{ newurl('/admin/additionalRates') }}"> <i class="fa fa-edit"></i>
        <span>{{ trans('messages.additional_rates') }} </span> </a></li>

      <!-- <li class="{{ (Route::currentRouteName() == 'colombiaRates') ? 'active' : '' }} treeview">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span> COL Inland trucking</span>
        <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/colombiaRates/*') ? 'active' : '' }}">
            <a href="{{ newurl('/admin/colombiaRates/View') }}"><i class="fa fa-circle"></i><span> Tarifas Terrestres COL</span></a></li>
        </ul>
      </li> -->
      
      
      <li><a href="{{ newurl('/admin/truckAssignments/view') }}"><i class="fa fa-edit"></i><span>{{ trans('messages.truck_assignment') }}</span></a></li>
      <li><a href="{{ newurl('/admin/quote/additional_info') }}"><i class="fa fa-edit"></i><span>{{ trans('messages.additional_info') }}</span></a></li>
      <li class="treeview {{ (Route::currentRouteName() == 'quote') ? 'active' : '' }}">
        <a href="#" class="section-header"> <i class="fa fa-edit"></i> <span>{{ trans('messages.quotes') }}</span>
          <i class="fa fa-angle-left pull-right"></i> </a>
        <ul class="treeview-menu SubbmenSecurity section-body">
          <li class="{{ Request::is('admin/quote/info') ? 'active' : '' }}{{ Request::is('admin/quote/info/*') ? 'active' : '' }}"><a href="{{ newurl('/admin/quote/info') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.quotes_info') }}</span></a></li>
          <li class="{{ Request::is('admin/quote/details') ? 'active' : '' }}{{ Request::is('admin/quote/details/*') ? 'active' : '' }}"><a href="{{ newurl('/admin/quote/details') }}"><i class="fa fa-circle"></i><span>{{ trans('messages.quotes_summary') }}</span></a></li>
        </ul>
      </li>
      <li class="{{ (Route::currentRouteName() == 'reports') ? 'active' : '' }}"><a href="{{ newurl('/admin/reports') }}"><i class="fa fa-edit"></i></i><span>{{ trans('messages.reports') }}</span></a></li>
      <!-- <li class="{{ Request::is('admin/uploadrates') ? 'active' : '' }}" >
        <a href="{{ newurl('/admin/uploadrates') }}"> <i class="fa fa-dashboard"></i> <span>Upload Rates</span> </a></li> -->
      
    </ul>
   
  </section>
  <!-- /.sidebar -->

</aside>
  <script>
	$(document).ready(function(){
		$(document).on('click','.treeview',function(){
     // console.log();
      $('.treeview').removeClass('active');
      $(this).addClass('active');
      $(".treeview:not(.active) .treeview-menu").removeAttr("style").hide();
    });
    $('.section-header').click(function(e){
      e.preventDefault();
      
		});	
    $(".treeview.active .treeview-menu").css('display','block');
	});

  $(document).ready(function(){
    // $('.section-header.active').click(function(e){
    //   e.preventDefault();
    //   console.log($(this));
    //   //$(this).next().css('display','block'); 
    // });  
    $('.section-header').click(function(){
      $(this).next().slideToggle();  
    });     
  });
</script>
 