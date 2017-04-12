<script type="text/javascript">
	$(document).ready(function(){
		$('.dashboardMenu > ul').css('display', 'block');
	});
</script>

<aside class="main-sidebar leftside-bar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <!-- <div class="user-panel">
      <div class="pull-left image" <?php //echo $left_showProfileImage;?> >
        <?php //if ($showProfileImage): ?>
          <img src="{{ URL::asset('uploads/'.Auth::user()->picture) }}" class="img-circle" alt="User Image">
        <?php //endif; ?>
      </div>
      <div class="pull-left info">
        <p> {{ Auth::user()->name }} </p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div> -->
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <!--<li class="header">MAIN NAVIGATION</li>-->
      <li class="{{ (Route::currentRouteName() == 'dashboard') ? 'active' : '' }} treeview dashboardMenu">
        <a href="{{ newurl('/administrator/dashboard') }}"> <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ Request::is('administrator/airports') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/airports') }}"><i class="fa fa-circle-o"></i> <span>Airports</span> </a></li>
          <li class="{{ Request::is('administrator/airports') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/airline') }}"><i class="fa fa-circle-o"></i> <span>Airlines</span> </a></li>
          <li class="{{ Request::is('administrator/countries') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/countries') }}"><i class="fa fa-circle-o"></i> <span>Countries</span> </a></li>
          <li class="{{ Request::is('administrator/cities') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/cities') }}"><i class="fa fa-circle-o"></i> <span>Cities</span> </a></li>
          <li class="{{ Request::is('administrator/services') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/services') }}"><i class="fa fa-circle-o"></i> <span>Services</span> </a></li>
          <li class="{{ Request::is('administrator/ffstatus') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/ffstatus') }}"><i class="fa fa-circle-o"></i> <span>FF Status</span> </a></li>   
          <li class="{{ Request::is('administrator/units') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/units') }}"><i class="fa fa-circle-o"></i> <span>Units</span> </a></li>
          <li class="{{ Request::is('administrator/exchangeSelection') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/exchangeSelection') }}"><i class="fa fa-circle-o"></i> <span>Exchange Selection</span> </a></li>
          <li class="{{ Request::is('administrator/transportationSelection') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/transportationSelection') }}"><i class="fa fa-circle-o"></i> <span>Transportation Selection</span> </a></li>
          <li class="{{ Request::is('administrator/CFTMode') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/CFTMode') }}"><i class="fa fa-circle-o"></i> <span>CFT Mode</span> </a></li>
          <li class="{{ Request::is('administrator/containerType') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/containerType') }}"><i class="fa fa-circle-o"></i> <span>Container Type</span> </a></li>
          <li class="{{ Request::is('administrator/oceanPorts') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/oceanPorts') }}"><i class="fa fa-circle-o"></i> <span>Ocean Ports</span> </a></li>
          <li class="{{ Request::is('administrator/departments') ? 'active' : '' }}" >
            <a href="{{ newurl('/administrator/departments') }}"><i class="fa fa-circle-o"></i> <span>COL Departments</span> </a></li>
        </ul>
      </li>
      <li class="{{ (Route::currentRouteName() == 'ff') ? 'active' : '' }} treeview">
        <a href="{{ newurl('/administrator/dashboard') }}"> <i class="fa fa-edit"></i> <span>Freight Forwarder</span>
        <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ Request::is('administrator/freight-forwarder/View') ? 'active' : '' }}">
            <a href="{{ newurl('/administrator/freight-forwarder/View') }}"> <i class="fa fa-circle-o"></i> <span>View</span> </a></li>
          <li class="{{ Request::is('administrator/freight-forwarder/Add') ? 'active' : '' }}">
            <a href="{{ newurl('/administrator/freight-forwarder/Add') }}"> <i class="fa fa-circle-o"></i></i> <span>Add</span> </a></li>
          
        </ul>
      </li>
      <!-- <li>
        <a href="pages/calendar.html">
          <i class="fa fa-calendar"></i> <span>Calendar</span>
          <small class="label pull-right bg-red">3</small>
        </a>
      </li> -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>