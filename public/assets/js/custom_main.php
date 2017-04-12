<script type="text/javascript">
  $(document).ready(function(){
    $(".departing").datepicker({format: 'dd/mm/yyyy', startDate: new Date(), minDate: new Date() });

    // $('.check_itinerary').click(function(){
    //   var ready_date = $(this).attr('ready_date');
    //   $('.departing').val(ready_date);
    // });
    $(".datepicker").datepicker();
    $('.add-other-info-js').on('click',function(e){
      e.preventDefault(); console.log('.add-other-fields-js:last');
      $(".add-other-fields-js:last").clone().find(':input').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
          return '[' + (parseInt(p1,10)+1) + ']';
        });

      }).end().appendTo(".addotherinfo-js");
      $(".add-other-fields-js:last").find("input[type='text']").val("");
      $(".add-other-fields-js:last").find("input[type='email']").val("");

      $(".add-other-fields-js:last .rmcls").html("<span title='Remove' class='glyphicon glyphicon-remove'></span>");
      
      $('<script>$(".glyphicon.glyphicon-remove").on("click",function(){ $(this).parent().parent().parent().remove(); });</' + 'script>').appendTo(".add-other-fields-js:last .rmcls");
      
    });

    //ajax start and complete call back
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    }); 
    
     //select box turns into autocomplete
    $('select.turn-to-ac').selectToAutocomplete({'copy-attributes-to-text-field': false});

    $(".js-example-basic-multiple").select2();
    $('.rating input').click(function(){
      $(this).addClass('active');
      $(this).next('label').css('color','#FFD700');
    });
    
    $('input[type="radio"].minimal').on('click',function(){
      $(this).closest('.form-group').next('div.radioyes:first').css('display','block');
    });
    $('input[type="radio"].minimal-red').click(function(){
      $(this).closest('.form-group').next('div.radioyes:first').css('display','none');
    });
    $(document).on('change','#country_id_js',function(e){
      e.preventDefault(e);
      var country = $('#country_id_js').val();
      var url = '<?php echo BASE_URL; ?>'+'/getCitiesByCountries/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            $('.cities-js').html(obj.html.cities);
            $('.branchies-js').html(obj.html.brachies);
            $('.country_code_ext').val(obj.html.country_code);
          }else{
            $('.country_code_ext').val('');
            $('.cities-js').html("<select class='form-control' name='city_id'><option value=''>Please Select City</option></select>");
          }
        }
      });
    });

    $('.add-button-js a').on('click',function(e){
      e.preventDefault();
      $(".append-js:last").clone().find(':input').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
          return '[' + (parseInt(p1,10)+1) + ']';
        });
      }).end().appendTo(".add-fields-js");
      $(".append-js:last").find("input[type='text']").val("");
    });

    $('.add-shareholder-button-js').bind('click',function(e){
      e.preventDefault();
      $(".add-shareholder-fields-js:last").clone(true).find(':input').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
          return '[' + (parseInt(p1,10)+1) + ']';
        });
      }).end().appendTo(".shareholder-js");

      $(".add-shareholder-fields-js:last").find("input[type='text']").val("");

      $(".add-shareholder-fields-js:last .rmcls").html("<span title='Remove' class='glyphicon glyphicon-remove'></span>");
      
      $('<script>$(".glyphicon.glyphicon-remove").on("click",function(){ $(this).parent().parent().parent().remove(); });</' + 'script>').appendTo(".add-shareholder-fields-js:last .rmcls");
      // $(".add-shareholder-fields-js:last .rmcls .glyphicon-remove").html('<script type="text/javascript">
      //   $(document).ready(function(){
      //     
      //   });
      //   
      //  ');

    });

    
    

    $('.add-personincharge-button-js').on('click',function(e){
      e.preventDefault();
      $(".add-personincharge-fields-js:last").clone().find(':input').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
          return '[' + (parseInt(p1,10)+1) + ']';
        });

      }).end().appendTo(".personincharge-js");
      $(".add-personincharge-fields-js:last").find("input[type='text']").val("");
      $(".add-personincharge-fields-js:last").find("input[type='email']").val("");

      $(".add-personincharge-fields-js:last .rmcls").html("<span title='Remove' class='glyphicon glyphicon-remove'></span>");
      
      $('<script>$(".glyphicon.glyphicon-remove").on("click",function(){ $(this).parent().parent().parent().remove(); });</' + 'script>').appendTo(".add-personincharge-fields-js:last .rmcls");
      
    });

    $(".container-type-js").on('change',function(){
      var selectedText = $(".container-type-js option:selected").text();
      $(".container-type-main-js a.tooltips").html(selectedText+' <span>i</span>');
    });

    $('.load-type-js').click(function(e){
      e.preventDefault();
      $('.load-type-js').removeClass('activetab');
      $(this).addClass('activetab');
      var $clickedValue = $(this).attr('ref');
      $('#load_type_id_js').val($clickedValue);
      //console.log($('.lcl_show-js'));
      if($clickedValue == "lcl"){
        $('.lcl_show-js').css('display','block');
        $('.fcl_show-js').css('display','none');
      }else{
        $('.lcl_show-js').css('display','none');
        $('.fcl_show-js').css('display','block');
      }
    });
    $("#accordion_tool" ).accordion({heightStyle: 'content'});
    //accordion start
    $( "#accordion, .accordion" ).accordion({heightStyle: 'content',collapsible: true, disabled: true});
    $('#accordion button, .accordion button').click(function(e) {
        e.preventDefault();
        var delta = ($(this).is('.next') ? 1 : -1);
        $('#accordion').accordion('option', 'active', ( $('#accordion').accordion('option','active') + delta  ));
    });
    //accordion end

    //Animation for header footer start
    $("a[href='#top']").click(function() {
       $("html, body").animate({ scrollTop: 0 }, "slow");
       return false;
    });
    $('.js--triggerAnimation').click(function(e){
        e.preventDefault();
        var anim = $('.js--animations').val();
        testAnim(anim);
    });

    $('.js--animations').change(function(){
        var anim = $(this).val();
        testAnim(anim);
    });

    // Origin Change ocean Port by city
    $(document).on('change','.origin_change_ocean_port_by_city',function(e){
      e.preventDefault(e);
      var city = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/oceanPortBycity/'+city;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            //console.log(obj.html.ports);
            $('.origin_change_ocean_port').html(obj.html.ports);
          }else{
            $('.origin_change_ocean_port').html("<option value=''>Select Ocean Port</option>");
          }
        }
      });
    });

    // Destination Change ocean Port by city
    $(document).on('change','.destination_change_ocean_port_by_city',function(e){
      e.preventDefault(e);
      var city = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/oceanPortBycity/'+city;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            //console.log(obj.html.ports);
            $('.destination_change_ocean_port').html(obj.html.ports);
          }else{
            $('.destination_change_ocean_port').html("<option value=''>Select Ocean Port</option>");
          }
        }
      });
    });

    // Change Origin Country
    $(document).on('change','.origin_afr_country',function(e){
      e.preventDefault(e);
      var country = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/admin/airportbycountry/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            $('.origin_airport_js').html(obj.html.airports);
          }else{
            $('.origin_airport_js').html("<option value=''>Select Airport</option>");
          }
          $('select.turn-to-ac-fornt-js').next('.ui-autocomplete-input').remove();
          $('select.turn-to-ac-fornt-js').selectToAutocomplete({'copy-attributes-to-text-field': false});
        }
      });
    });

    $(document).on('change','.origin_change_country',function(e){
      e.preventDefault(e);
      var country = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/citybycountry/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.origin_change_city').html(obj.html.cities);
            $('.origin_change_port').html(obj.html.ports);
          }else{
            $('.origin_change_city').html("<option value=''>Select City</option>");
            $('.origin_change_port').html("<option value=''>Select Port</option>");
          }
          $('select.turn-to-ac-fornt-js').next('.ui-autocomplete-input').remove();
          $('select.turn-to-ac-fornt-js').selectToAutocomplete({'copy-attributes-to-text-field': false});
        }
      });
    });

    // Change Origin City
    $(document).on('change','.origin_change_city',function(e){
      e.preventDefault(e);
      var city = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/citybyports/'+city;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.origin_change_airport').html(obj.html.airports);
            $('.origin_change_department').html(obj.html.departments);
          }else{
            $('.origin_change_airport').html("<option value=''>Select Airport</option>");
            $('.origin_change_department').html("<option value=''>Select Departments</option>");
          }
        }
      });
    });

    // Change Origin Port
    $(document).on('change','.origin_change_port',function(e){
      e.preventDefault(e);
      var port = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/terminalbyport/'+port;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.origin_change_terminal').html(obj.html.terminals);
          }else{
            $('.origin_change_terminal').html("<option value=''>Select Terminal</option>");
          }
        }
      });
    });

    // Change Destination Country
    $(document).on('change','.destination_afr_country',function(e){
      e.preventDefault(e);
      var country = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/admin/airportbycountry/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            $('.destination_airport_js').html(obj.html.airports);
          }else{
            $('.destination_airport_js').html("<option value=''>Select Airport</option>");
          }
          $('select.turn-to-ac-fornt-js').next('.ui-autocomplete-input').remove();
          $('select.turn-to-ac-fornt-js').selectToAutocomplete({'copy-attributes-to-text-field': false});
        }
      });
    });
    $(document).on('change','.destination_change_country',function(e){
      e.preventDefault(e);
      var country = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/citybycountry/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.destination_change_city').html(obj.html.cities);
            $('.destination_change_port').html(obj.html.ports);
          }else{
            $('.destination_change_city').html("<option value=''>Select City</option>");
            $('.destination_change_port').html("<option value=''>Select Port</option>");
          }
          $('select.turn-to-ac-fornt-js').next('.ui-autocomplete-input').remove();
          $('select.turn-to-ac-fornt-js').selectToAutocomplete({'copy-attributes-to-text-field': false});
        }
      });
    });

    // Change Destination City
    $(document).on('change','.destination_change_city',function(e){
      e.preventDefault(e);
      var city = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/citybyports/'+city;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.destination_change_airport').html(obj.html.airports);
            $('.destination_change_department').html(obj.html.departments);
          }else{
            $('.destination_change_airport').html("<option value=''>Select Airport</option>");
            $('.destination_change_department').html("<option value=''>Select Department</option>");
          }
        }
      });
    });

    // Change Destination Port
    $(document).on('change','.destination_change_port',function(e){
      e.preventDefault(e);
      var port = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/terminalbyport/'+port;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.destination_change_terminal').html(obj.html.terminals);
          }else{
            $('.destination_change_terminal').html("<option value=''>Select Terminal</option>");
          }
        }
      });
    });


  });
  
  jQuery(document).ready(function($) {

    $('input[type=radio][name=belong_network]').change(function() {
       
        if (this.value == 'yes') {
            $("#belong_network_text").css('display','block');
        }
        else if (this.value == 'no') {
            $("#belong_network_text").css('display','none');
        }
    });

    $('input[type=radio][name=quality_check]').change(function() {
       
        if (this.value == 'yes') {
            $(".certifier_text").css('display','block');
            $(".no_certifier_text").css('display','none');
        }
        else if (this.value == 'no') {
            $(".certifier_text").css('display','none');
            $(".no_certifier_text").css('display','block');
        }
    });

    $('.zoomit').addClass("visible").viewportChecker({
        classToAdd: 'visible animated zoomIn',
        offset: 50
    });
    $('.zoomit1').addClass("visible").viewportChecker({
        classToAdd: 'visible animated zoomIn',
        offset: 50
    });
    $('.zoomit2').addClass("visible").viewportChecker({
        classToAdd: 'visible animated zoomIn',
        offset: 50
       });
    $('.zoomit3').addClass("visible").viewportChecker({
        classToAdd: 'visible animated zoomIn',
        offset: 50
    });
    $('.zoomit4').addClass("visible").viewportChecker({
        classToAdd: 'visible animated slideInDown',
        offset: 50
    });
    $('.zoomit5').addClass("visible").viewportChecker({
        classToAdd: 'visible animated lightSpeedIn',
        offset: 50
    });
  });
  function testAnim(x) {
    $('#animationSandbox').removeClass().addClass(x + ' animated')
        .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
  };
</script>