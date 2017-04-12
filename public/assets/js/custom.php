<script type="text/javascript">
  $(document).ready(function(){
    var date = new Date();
    date.setDate(date.getDate());
    $(".datepicker1").datepicker({startDate: date});
    
    $('.addOtherAdditionalRates-js').on('click',function(e){
      e.preventDefault(); console.log('.add-other-fields-js:last');
      $(".add-other-fields-js:last").clone().find(':input').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
          return '[' + (parseInt(p1,10)+1) + ']';
        });

      }).end().appendTo(".otherAdditionalRates-js");
      $(".add-other-fields-js:last").find("input[type='text']").val("");
      $(".add-other-fields-js:last").find("input[type='email']").val("");

      $(".add-other-fields-js:last .rmcls").html("<span title='Remove' class='glyphicon glyphicon-remove'></span>");
      
      $('<script>$(".glyphicon.glyphicon-remove").on("click",function(){ $(this).parent().parent().parent().parent().remove(); });</' + 'script>').appendTo(".add-other-fields-js:last .rmcls");
    });

    $('.direct_via_rate').click(function(){
      $('.direct-no').css('display','none');
      if($(this).val() == "no"){
        $('.direct-no').css('display','block');
      }
    });
    $("a").click(function(e){
      console.log($(this).find('i.fa-trash').length);
      if($(this).find('i.fa-trash').length == 1){
        if(!confirm('Are you sure you want to delete record?')){
          e.preventDefault();
          return false;
        }
      }
      return true;
    });

    //select box turns into autocomplete
    $('select.turn-to-ac').selectToAutocomplete({'copy-attributes-to-text-field': false});
    
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
    $("#departing").datepicker();
    $("#returning").datepicker();
    $("button").click(function() {
      // var selected = $("#dropdown option:selected").text();
      // var departing = $("#departing").val();
      // var returning = $("#returning").val();
      // if (departing === "" || returning === "") {
      //   alert("Please select departing and returning dates.");
      // } else {
      //   confirm("Would you like to go to " + selected + " on " + departing + " and return on " + returning + "?");
      // }
    });

    //add tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $('.rating input').click(function(){
      console.log($(this).next('label'));
      $(this).next('label').css('color','#FFD700');
    });
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
      showInputs: false,
      minuteStep: 1,
    });
    //Datemask dd/mm/yyyy
    $(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "mm/dd/yyyy"});

    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy'
    });

    // Show / hide input type file
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

    // Change Select City
    $(document).on('change','.col_change_city',function(e){
      e.preventDefault(e);
      var city = $(this).val();
      var url = '<?php echo BASE_URL; ?>'+'/portbycity/'+city;
      $.ajax({
        url: url,
        type: "get",
        success: function(data){
          var obj = jQuery.parseJSON(data);
          console.log(obj);
          if(obj.flag){
            //alert(obj.html.cities);
            $('.col_city_ports').html(obj.html.ports);
          }else{
            $('.col_city_ports').html("<option value=''>Select Port</option>");
          }
        }
      });
    });
    
    $('input[type="radio"].minimal').on('click',function(){
      $(this).closest('.form-group').find('input.radioyes').css('display','block');
    });

    $('input[type="radio"].minimal-red').click(function(){
      $(this).closest('.form-group').find('input.radioyes').css('display','none');
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
    
    // Change Week by select year
    $('#year').on('change',function(e){
       //alert('df');
    });

    //decline process
    // $(document).on('click','.search_air_routes',function(e){
    //   e.preventDefault(e);
    //   var country = $('#country_id').val();
    //   var city = $('#city_id').val();
    //   var air = $('#air').val();
    //   var url = '<?php echo BASE_URL; ?>'+'/admin/getAirRoute/'+country+'/'+city+'/'+air;
    //   $.ajax({
    //     url: url,
    //     type: "get",
    //     success: function(data){
    //       var obj = jQuery.parseJSON(data);
    //       console.log(obj.success);
    //       console.log(obj.data);
    //       if(obj.success){
    //         $('.desination').css('display','block');
    //         $('.desination').html(obj.data);
    //         $('.ratesFields').css('display','block');
    //       }else{
    //         $('.desination').css('display','block');
    //         $('.desination').html(obj.data);
    //       }
    //     }
    //   });
    // });
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
  
    $('.air-route-js').on('submit', function(event){
      event.preventDefault();
      var form = $(this);
      var formUrl = $('form.from-action-js').attr('action');
      $.ajax({
          type     : "POST",
          url      : $(this).attr('action'),
          data     : form.serialize(),
          cache    : false,
          success  : function(data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success){
              $('.rates-js').css('display','block');
              $('.no-result-js').css('display','none');
              $('.rates-js form').append('<input type="hidden" value="'+obj.data+'" name="afr_route_id"/>');
              formUrl = formUrl+'/'+obj.data+'/0/0';
              if(obj.rates_id){
                formUrl = '<?php echo BASE_URL;?>'+$('.editUrl').val()+obj.data+'/'+obj.rates_id;+obj.data+'/'+obj.rates_id;
              }

              if(obj.irates_id){
                formUrl = formUrl;
              }
              //console.log(formUrl);exit();
			  window.location.replace(formUrl);
            }else{
              formUrl = formUrl+'/0/0/1';
              window.location.replace(formUrl);
              $('.no-result-js').css('display','block');
              $('.no-result-js .box-header').html(obj.data);
              $('.rates-js').css('display','none');
            }
          }
      })
    });
    
    $('.col-route-js').on('submit', function(event){
      event.preventDefault();
      var form = $(this);
      var formUrl = $('form.from-action-js').attr('action');
      $.ajax({
          type     : "POST",
          url      : $(this).attr('action'),
          data     : form.serialize(),
          cache    : false,
          success  : function(data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success){
              $('.rates-js').css('display','block');
              $('.no-result-js').css('display','none');
              $('.rates-js form').append('<input type="hidden" value="'+obj.data+'" name="col_route_id"/>');
              formUrl = formUrl+'/'+obj.data+'/0/0';
              
              window.location.replace(formUrl);
            }else{
              formUrl = formUrl+'/0/0/1';

              window.location.replace(formUrl);
              $('.no-result-js').css('display','block');
              $('.no-result-js .box-header').html(obj.data);
              $('.rates-js').css('display','none');
            }
          }
      })
    });

    $('.ocean1-route-js').on('submit', function(event){
      event.preventDefault();
      var form = $(this);
      $.ajax({
          type     : "POST",
          url      : $(this).attr('action'),
          data     : form.serialize(),
          cache    : false,
          success  : function(data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success){
              $('.rates-js').css('display','block');
              $('.no-result-js').css('display','none');
              $('.rates-js form').append('<input type="hidden" value="'+obj.data+'" name="ocean_route_id"/>');
            }else{
              $('.no-result-js').css('display','block');
              $('.no-result-js .box-header').html(obj.data);
              $('.rates-js').css('display','none');
            }
          }
      })
    });



    $('.ocean-route-js').on('submit', function(event){
      event.preventDefault();
      var form = $(this);
      var formUrl = $('form.from-action-js').attr('action');
      $.ajax({
          type     : "POST",
          url      : $(this).attr('action'),
          data     : form.serialize(),
          cache    : false,
          success  : function(data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success){
              $('.rates-js').css('display','block');
              $('.no-result-js').css('display','none');
              $('form.main-form-js').append('<input type="hidden" value="'+obj.data+'" name="ocean_route_id"/>');
              formUrl = formUrl+'/'+obj.data+'/0/0';
			  if(obj.addofrItinerary){
			  		formUrl = '<?php echo BASE_URL;?>/admin/ofrItinerary/Add/'+obj.data+'/0/0';
			  }
              //console.log(formUrl);exit();
              window.location.replace(formUrl);
            }else{
              formUrl = formUrl+'/0/0/1';
              window.location.replace(formUrl);
              $('.no-result-js').css('display','block');
              $('.no-result-js .box-header').html(obj.data);

              $('.rates-js').css('display','none');
            }
          }
      })
    });
    
    //ajax start and complete call back
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    }); 

    $("#accordion_tool" ).accordion({heightStyle: 'content'});
    $( "#accordion" ).accordion({heightStyle: 'content'});
    $('#accordion button').click(function(e) {
        e.preventDefault();
        var delta = ($(this).is('.next') ? 1 : -1);
        $('#accordion').accordion('option', 'active', ( $('#accordion').accordion('option','active') + delta  ));
    });
    $( ".accordion" ).accordion({heightStyle: 'content'});
    $('.accordion button').click(function(e) {
        e.preventDefault();
        var delta = ($(this).is('.next') ? 1 : -1);
        $('.accordion').accordion('option', 'active', ( $('.accordion').accordion('option','active') + delta  ));
    });

    // 


  });
   
</script>