<script type="text/javascript">
  $(document).ready(function(){
    $('input[type="radio"].minimal').on('click',function(){
      $(this).closest('.form-group').next('div.radioyes:first').css('display','block');
    });
    $('input[type="radio"].minimal-red').click(function(){
      $(this).closest('.form-group').next('div.radioyes:first').css('display','none');
    });

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
    $('.section-header').click(function(){
      $(this).next().slideToggle();  
    });
    $('input[type="radio"].minimal').on('click',function(){
      $(this).closest('.form-group').find('input.radioyes').css('display','block');
    });
    $('input[type="radio"].minimal-red').click(function(){
      $(this).closest('.form-group').find('input.radioyes').css('display','none');
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
            $('#cell_phone').val(obj.html.country_code);
          }else{
            // $('.desination').css('display','block');
            // $('.desination').html(obj.data);
          }
        }
      });
    });

    $('#status-js').on('change',function(){
      if($('#status-js option:selected').text() == "Appointment"){
        $('#appointment-js').css('display','block');
      }
    });
    $('.add-button-js a').on('click',function(e){
      e.preventDefault();
      $(".append-js:last").clone().find(':input').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
          return '[' + (parseInt(p1,10)+1) + ']';
        });
      }).end().appendTo(".add-fields-js");
      
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
      var $clickedValue = $(this).attr('ref');
      if($clickedValue == "lcl"){
        $('.lcl-detail-show-hide-js').css('display','block');
      }else{
        $('.lcl-detail-show-hide-js').css('display','none');
      }
      $('#load_type_id_js').val($clickedValue);
    });
    
    //accordion start
     $( "#accordion, .accordion" ).accordion({heightStyle: 'content',collapsible: true, disabled: true});
    $('#accordion button, .accordion button').click(function(e) {
        e.preventDefault();
        var delta = ($(this).is('.next') ? 1 : -1);
        console.log(delta);
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

    // Change Origin Country
    $(document).on('change','.origin_change_country',function(e){
      e.preventDefault(e);
      var country = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/citybycountry/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.origin_change_city').html(obj.html.cities);
            $('.origin_change_port').html(obj.html.ports);
          }else{
            $('.origin_change_city').html("<option value=''>Select City</option>");
            $('.origin_change_port').html("<option value=''>Select Port</option>");
          }
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
    $(document).on('change','.destination_change_country',function(e){
      e.preventDefault(e);
      var country = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/citybycountry/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.destination_change_city').html(obj.html.cities);
            $('.destination_change_port').html(obj.html.ports);
          }else{
            $('.destination_change_city').html("<option value=''>Select City</option>");
            $('.destination_change_port').html("<option value=''>Select Port</option>");
          }
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
  
  $(document).ready(function(){
    //add tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //decline process
    $(document).on('click','#decsave',function(e){
      e.preventDefault(e);
      var declineReason = $.trim($(this).closest('form').find('#decline-reason').val());
      var decTable = $.trim($(this).closest('form').attr('dec-table'));
      var decField = $.trim($(this).closest('form').attr('dec-field'));
      var decId = $.trim($(this).closest('form').attr('dec-id'));
      var decStatus = $.trim($(this).closest('form').attr('dec-status'));
      if(declineReason.length > 0){
        var url = '<?php echo BASE_URL; ?>'+'/administrator/status/'+decId+'/'+decStatus+'/'+decTable+'/'+decField+'/'+declineReason;
        window.location.replace(url);
      }else{
        $(this).closest('form').addClass('has-feedback has-error');
        e.stopPropagation();
      }
    });
    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
    //Datemask dd/mm/yyyy
    $(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "mm/dd/yyyy"});

    $('.datepicker').datepicker({
      //format: 'dd-mm-yyyy'
    });

    // Show / hide input type file
    console.log($('input[type="radio"].minimal'));
    $('input[type="radio"].minimal').on('click',function(){
      console.log($(this).closest('.form-group').find('input.radioyes'));
      $(this).closest('.form-group').find('input.radioyes').css('display','block');
    });
    $('input[type="radio"].minimal-red').click(function(){
      $(this).closest('.form-group').find('input.radioyes').css('display','none');
    });

    // Change Week by select year
    $('#year').on('change',function(e){
       //alert('df');
    });
    $(document).on('change','#country_id_js',function(e){
      e.preventDefault(e);
      var country = $('#country_id_js').val();
      console.log(country);
      var url = '<?php echo BASE_URL; ?>'+'/admin/getCitiesByCountries/'+country;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj.flag);
          console.log(obj.data);
          if(obj.flag){
            $('.cities-js').html(obj.data);
          }else{
            // $('.desination').css('display','block');
            // $('.desination').html(obj.data);
          }
        }
      });
    });
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });

    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    }); 


    $( "#accordion" ).accordion({heightStyle: 'content'});
    $('#accordion button').click(function(e) {
        e.preventDefault();
        var delta = ($(this).is('.next') ? 1 : -1);
        $('#accordion').accordion('option', 'active', ( $('#accordion').accordion('option','active') + delta  ));
    });


  });
  
  function testAnim(x) {
    $('#animationSandbox').removeClass().addClass(x + ' animated')
        .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
  };
</script>