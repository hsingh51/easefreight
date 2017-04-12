<script type="text/javascript">
  $(function(){
    $( "#dialog" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener" ).on( "click", function(e) {
      e.preventDefault();
      sweetAlert("Attention", "Please logout to view Importer and Exporter!");
    });

    $( "#imp" ).on( "click", function(e) {
      e.preventDefault();
      sweetAlert("Attention", "Please logout to view Freight Forworder!");
    });

    $('a.buttonSlide').hover(function() {
      $text = $(this).children('span').html();
      $f_text = "<?php echo trans('messages.i_am_a_frieght_forwarder')?>";
      $m_text = "<?php echo trans('messages.i_am_an_importer_exporter')?>";
      if($text == $f_text){
        $('#typed-strings').html("<p>"+$text+"</p><p>"+$text+"</p><p>"+$m_text+"</p><p>"+$text+"</p>");
      }else{
        $('#typed-strings').html("<p>"+$text+"</p><p>"+$text+"</p><p>"+$f_text+"</p><p>"+$text+"</p>");
      }
      
      $("#typed").typed('reset');
      $("#typed").typed({
          stringsElement: $('#typed-strings'),
          typeSpeed: 50,
          backDelay: 500,
          loop: true,
          contentType: 'html', // or text
          // defaults to false for infinite loop
          loopCount: false,
          callback: function(){ foo(); },
          resetCallback: function() { newTyped(); }
      });
    });
    /** Header Slider Starts from here **/  
      $(window).scroll(function() {
        if ($(this).scrollTop() >= 90) {
          $('.main-nav').addClass('stickytop');
        }
        else {
          $('.main-nav').removeClass('stickytop');
        }
      });

      $("#typed").typed({
          // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
          stringsElement: $('#typed-strings'),
          typeSpeed: 50,
          backDelay: 500,
          loop: true,
          contentType: 'html', // or text
          // defaults to false for infinite loop
          loopCount: false,
          callback: function(){ foo(); },
          resetCallback: function() { newTyped(); }
      });

      $(".reset").click(function(){
          $("#typed").typed('reset');
      });
    /** Header Slider End from here **/
  });
  function newTyped(){ /* A new typed object */ }

  function foo(){ console.log("Callback"); }
  function dialog() {
    jAlert({
      headingText: 'Warning',
      contentText: 'Please logout to view importer and exporter.'
    },"top"); // left, right, bottom or top    
  } 

</script>