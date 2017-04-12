<script type="text/javascript">

 //--Only type number validation
  function isNumber(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /^[0-9.,\b]+$/;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }
  //--Only type number validation

  $(document).ready(function(){

//--multiply--lenght
    $( ".long_cbm" ).change(function() {
        var len = $(this).val();
        var newlen = len * 3.28084;
        var newlen_n = newlen.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .long_cbf").val(newlen_n);
    });
//--multiply--lenght

//--devide--lenght
    $( ".long_cbf" ).change(function() {
        var len = $(this).val();
        var newlen = len / 3.28084;
        var newlen_n = newlen.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .long_cbm").val(newlen_n);
    });
//--devide--lenght


    $( ".width_cbm" ).change(function() {
        var len2 = $(this).val();
        var newlen2 = len2 * 3.28084;
        var newlen2_n = newlen2.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .width_cbf").val(newlen2_n);
    });

//devide -- width
    $( ".width_cbf" ).change(function() {
        var len2 = $(this).val();
        var newlen2 = len2 / 3.28084;
        var newlen2_n = newlen2.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .width_cbm").val(newlen2_n);
    });
//devide -- width



    $( ".height_cbm" ).change(function() {
        var len3 = $(this).val();
        var newlen3 = len3 * 3.28084;
        var newlen3_n = newlen3.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .height_cbf").val(newlen3_n);
    });

//devide 3
     $( ".height_cbf" ).change(function() {
        var len3 = $(this).val();
        var newlen3 = len3 / 3.28084;
        var newlen3_n = newlen3.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .height_cbm").val(newlen3_n);
    });
//devide 3



//--Weight to tonns and lb
     $('.weight_cbm').change(function(){

        var wght = parseFloat($('.weight_cbm').val()) || 0;
        var wght2=wght/1000;
        var wght2_n=wght2.toFixed(2);
        var wght3=wght*2.2046;
        var wght3_n=wght3.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);

        $("."+n+" .weight_cbf").val(wght2_n);    
        $("."+n+" .weight_cbl").val(wght3_n);
    });
//--Weight to tonns and lb

//--Weight to kgs and lb
     $('.weight_cbf').change(function(){

        var wght = parseFloat($('.weight_cbf').val()) || 0;
        var wght2=wght*1000;
        var wght2_n=wght2.toFixed(2);
        var wght3=wght*2204.62;
        var wght3_n=wght3.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);

        $("."+n+" .weight_cbm").val(wght2_n);  
        $("."+n+" .weight_cbl").val(wght3_n);   
    });
//--Weight to kgs and lb


//--Weight to kg and tonns
     $('.weight_cbl').change(function(){

        var wght = parseFloat($('.weight_cbl').val()) || 0;
        var wght2=wght/2.2046;
        var wght2_n=wght2.toFixed(2);
        var wght3=wght/2204.62;
        var wght3_n=wght3.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);

        $("."+n+" .weight_cbm").val(wght2_n);    
        $("."+n+" .weight_cbf").val(wght3_n);
    });
//--Weight to kg and tonns



  //--Total
    $('.long_cbm, .width_cbm, .height_cbm, .long_cbf, .width_cbf, .height_cbf').change(function(){
        var lng = parseFloat($('.long_cbm').val()) || 0;
        var width = parseFloat($('.width_cbm').val()) || 0;
        var height = parseFloat($('.height_cbm').val()) || 0;
        var count_n = lng * width * height;
        var count = count_n.toFixed(2);
        var d = new Date();
        var n = "a"+d.getTime();
        $(this).parent().parent().parent().parent().addClass(n);
        $("."+n+" .total_cbm").val(count);

        var count2 = (lng*3.28084) * (width*3.28084) * (height*3.28084);
        var count3 = count2.toFixed(2);
        $("."+n+" .total_cbf").val(count3);

        // $('.total_cbm').val(lng * width * height);
        // var total_m= parseFloat($('.total_cbm').val()) || 0;
        // $('.total_cbf').val(total_m * 3.28084);    
    });
  //--Total


    //alert('s'); 
    
    // $("#qform").submit(function(event) {
    //     alert('ewr');
    // });

    // $(".append-js:last").clone().find(':input').each(function(){
    //    this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
    //      return '[' + (parseInt(p1,10)+1) + ']';
    //    });
    //  }).end().appendTo(".add-fields-js");

    $("#makeclone").on('click',function(){
      
        var as = $("div.divclone:last .long_cbm").attr("class");
        var res = as.replace("form-control long_cbm", ""); 
        var as1 = $("div.divclone:last .long_cbf").attr("class");
        var res1 = as1.replace("form-control long_cbf", ""); 
        $("#long_cbm").val(res.trim());
        $("#long_cbf").val(res1.trim());
        
        //devide -- lenght
         var as = $("div.divclone:last .long_cbf").attr("class");
        var res = as.replace("form-control long_cbf", ""); 
        var as1 = $("div.divclone:last .long_cbm").attr("class");
        var res1 = as1.replace("form-control long_cbm", ""); 
        $("#long_cbf").val(res.trim());
        $("#long_cbm").val(res1.trim());
        //devide -- lenght


        var ws = $("div.divclone:last .width_cbm").attr("class");
        var wres = ws.replace("form-control width_cbm", ""); 
        var ws1 = $("div.divclone:last .width_cbf").attr("class");
        var wres1 = ws1.replace("form-control width_cbf", ""); 
        $("#width_cbm").val(wres.trim());
        $("#width_cbf").val(wres1.trim());

        //devide -- width
        var ws = $("div.divclone:last .width_cbf").attr("class");
        var wres = ws.replace("form-control width_cbf", ""); 
        var ws1 = $("div.divclone:last .width_cbm").attr("class");
        var wres1 = ws1.replace("form-control width_cbm", ""); 
        $("#width_cbf").val(wres.trim());
        $("#width_cbm").val(wres1.trim());
        //devide -- width

        var hs = $("div.divclone:last .height_cbm").attr("class");
        var hres = hs.replace("form-control height_cbm", ""); 
        var hs1 = $("div.divclone:last .height_cbf").attr("class");
        var hres1 = hs1.replace("form-control height_cbf", ""); 
        $("#height_cbm").val(hres.trim());
        $("#height_cbf").val(hres1.trim());

        //devide -- height
        var hs = $("div.divclone:last .height_cbf").attr("class");
        var hres = hs.replace("form-control height_cbf", ""); 
        var hs1 = $("div.divclone:last .height_cbm").attr("class");
        var hres1 = hs1.replace("form-control height_cbm", ""); 
        $("#height_cbf").val(hres.trim());
        $("#height_cbm").val(hres1.trim());
        //devide -- height


      //--total
        var tot = $("div.divclone:last .total_cbm").attr("class");
        var tres = tot.replace("form-control total_cbm", ""); 
        var tot1 = $("div.divclone:last .total_cbf").attr("class");
        var tres1 = tot1.replace("form-control total_cbf", ""); 
        $("#total_cbm").val(tres.trim());
        $("#total_cbf").val(tres1.trim());
      //--total

      //--Weight 1
        var wgmh = $("div.divclone:last .weight_cbm").attr("class");
        var wgres = wgmh.replace("form-control weight_cbm", ""); 
        var wgmh1 = $("div.divclone:last .weight_cbf").attr("class");
        var wgres1 = wgmh1.replace("form-control weight_cbf", ""); 
        <?php if(isset($stats) && $stats['services'] != "Maritime"): ?>
            var wgmh2 = $("div.divclone:last .weight_cbl").attr("class");
            var wgres2 = wgmh2.replace("form-control weight_cbl", "");
            $("#weight_cbl").val(wgres2.trim());
        <?php endif; ?>
        $("#weight_cbm").val(wgres.trim());
        $("#weight_cbf").val(wgres1.trim());
        
      //--Weight 1

      //--Weight 2
        var wgmh = $("div.divclone:last .weight_cbf").attr("class");
        var wgres = wgmh.replace("form-control weight_cbf", ""); 
        var wgmh1 = $("div.divclone:last .weight_cbm").attr("class");
        var wgres1 = wgmh1.replace("form-control weight_cbm", ""); 
        <?php if(isset($stats) && $stats['services'] != "Maritime"): ?>
            var wgmh2 = $("div.divclone:last .weight_cbl").attr("class");
            var wgres2 = wgmh2.replace("form-control weight_cbl", "");
            $("#weight_cbl").val(wgres2.trim());
        <?php endif; ?>
        $("#weight_cbf").val(wgres.trim());
        $("#weight_cbm").val(wgres1.trim());
        
      //--Weight 2

      //--Weight 3
      <?php if(isset($stats) && $stats['services'] != "Maritime"): ?>
        var wgmh = $("div.divclone:last .weight_cbl").attr("class");
        var wgres = wgmh.replace("form-control weight_cbl", "");
        $("#weight_cbl").val(wgres.trim()); 
      <?php endif; ?>  
        var wgmh1 = $("div.divclone:last .weight_cbm").attr("class");
        var wgres1 = wgmh1.replace("form-control weight_cbm", ""); 

        var wgmh2 = $("div.divclone:last .weight_cbf").attr("class");
        var wgres2 = wgmh2.replace("form-control weight_cbf", ""); 

        
        $("#weight_cbm").val(wgres1.trim());
        $("#weight_cbf").val(wgres2.trim());
      //--Weight 3


      //--clone code
        $("div.divclone:last").clone().find(':input').each(function(){
           this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
             return '[' + (parseInt(p1,10)+1) + ']';
           });
         }).end().appendTo(".divmain");
        $("div.divclone:last").find("input[type='text']").val("");
        var html = $("div.divclone:last"); 
        html.find('script').remove();
      //--clone code
         $("div.divclone:last .rmcls").html("<span title='Remove' class='glyphicon glyphicon-remove'></span>");
         $('<script>$(".glyphicon.glyphicon-remove").on("click",function(){ $(this).parent().parent().parent().parent().remove(); });</' + 'script>').appendTo("div.divclone:last .rmcls");  
         var minNumber = 1; // le minimum
         var maxNumber = 100000; // le maximum
         var d = Math.floor(Math.random() * (maxNumber + 1) + minNumber);
         var nn = "long_cbm"+d;
         var mn = 'long_cbf'+d; 
         $("div.divclone:last .long_cbm").addClass(nn);
         $("div.divclone:last .long_cbf").addClass(mn); 
         $("div.divclone:last .long_cbm").removeClass($("#long_cbm").val());
         $("div.divclone:last .long_cbf").removeClass($("#long_cbf").val());       
        $("div.divclone:last").append('<script>$("input.'+nn+'" ).change(function() {var len = $(this).val(); var newlen = len * 3.28084; var newlen_n = newlen.toFixed(2); $(".'+mn+'").val(newlen_n);});</' + 'script>');

        //devide -- lenght
        var minNumber = 1; // le minimum
         var maxNumber = 100000; // le maximum
         var d = Math.floor(Math.random() * (maxNumber + 1) + minNumber);
         var nna = "long_cbf"+d;
         var mna = 'long_cbm'+d; 
         $("div.divclone:last .long_cbf").addClass(nna);
         $("div.divclone:last .long_cbm").addClass(mna); 
         $("div.divclone:last .long_cbf").removeClass($("#long_cbf").val());
         $("div.divclone:last .long_cbm").removeClass($("#long_cbm").val());       
        $("div.divclone:last").append('<script>$("input.'+nna+'" ).change(function() {var len = $(this).val(); var newlen = len / 3.28084; var newlen_n = newlen.toFixed(2); $(".'+mna+'").val(newlen_n);});</' + 'script>');
        //devide -- lenght

         var minNumber2 = 1; // le minimum
         var maxNumber2 = 100000; // le maximum
         var d2 = Math.floor(Math.random() * (maxNumber2 + 1) + minNumber2);
         var wm = "width_cbm"+d2;
         var wf = 'width_cbf'+d2; 
         $("div.divclone:last .width_cbm").addClass(wm);
         $("div.divclone:last .width_cbf").addClass(wf); 
         $("div.divclone:last .width_cbm").removeClass($("#width_cbm").val());
         $("div.divclone:last .width_cbf").removeClass($("#width_cbf").val());       
        $("div.divclone:last").append('<script>$("input.'+wm+'" ).change(function() {var len2 = $(this).val(); var newlen2 = len2 * 3.28084; newlen2_n = newlen2.toFixed(2); $(".'+wf+'").val(newlen2_n);});</' + 'script>');

        //devide -- width
         var minNumber2 = 1; // le minimum
         var maxNumber2 = 100000; // le maximum
         var d2 = Math.floor(Math.random() * (maxNumber2 + 1) + minNumber2);
         var wma = "width_cbf"+d2;
         var wfa = 'width_cbm'+d2; 
         $("div.divclone:last .width_cbf").addClass(wma);
         $("div.divclone:last .width_cbm").addClass(wfa); 
         $("div.divclone:last .width_cbf").removeClass($("#width_cbf").val());
         $("div.divclone:last .width_cbm").removeClass($("#width_cbm").val());       
        $("div.divclone:last").append('<script>$("input.'+wma+'" ).change(function() {var len2 = $(this).val(); var newlen2 = len2 / 3.28084; newlen2_n = newlen2.toFixed(2); $(".'+wfa+'").val(newlen2_n);});</' + 'script>');
        //devide -- width

        var minNumber3 = 1; // le minimum
         var maxNumber3 = 100000; // le maximum
         var d3 = Math.floor(Math.random() * (maxNumber3 + 1) + minNumber3);
         var hm = "height_cbm"+d3;
         var hf = 'height_cbf'+d3; 
         $("div.divclone:last .height_cbm").addClass(hm);
         $("div.divclone:last .height_cbf").addClass(hf); 
         $("div.divclone:last .height_cbm").removeClass($("#height_cbm").val());
         $("div.divclone:last .height_cbf").removeClass($("#height_cbf").val());       
        $("div.divclone:last").append('<script>$("input.'+hm+'" ).change(function() {var len3 = $(this).val(); var newlen3 = len3 * 3.28084; newlen3_n = newlen3.toFixed(2); $(".'+hf+'").val(newlen3_n);});</' + 'script>');

        //devide -- height
        var minNumber3 = 1; // le minimum
         var maxNumber3 = 100000; // le maximum
         var d3 = Math.floor(Math.random() * (maxNumber3 + 1) + minNumber3);
         var hma = "height_cbf"+d3;
         var hfa = 'height_cbm'+d3; 
         $("div.divclone:last .height_cbf").addClass(hma);
         $("div.divclone:last .height_cbm").addClass(hfa); 
         $("div.divclone:last .height_cbf").removeClass($("#height_cbf").val());
         $("div.divclone:last .height_cbm").removeClass($("#height_cbm").val());       
        $("div.divclone:last").append('<script>$("input.'+hma+'" ).change(function() {var len3 = $(this).val(); var newlen3 = len3 / 3.28084; newlen3_n = newlen3.toFixed(2); $(".'+hfa+'").val(newlen3_n);});</' + 'script>');
        //devide -- height


      //--total
         var minNumber4 = 1; // le minimum
         var maxNumber4 = 100000; // le maximum
         var d4 = Math.floor(Math.random() * (maxNumber4 + 1) + minNumber4);
         var tm = "total_cbm"+d4;
         var tf = 'total_cbf'+d4; 
         $("div.divclone:last .total_cbm").addClass(tm);
         $("div.divclone:last .total_cbf").addClass(tf); 
         $("div.divclone:last .total_cbm").removeClass($("#total_cbm").val());
         $("div.divclone:last .total_cbf").removeClass($("#total_cbf").val()); 

        $("div.divclone:last").append('<script>$("input.'+nn+', input.'+wm+', input.'+hm+', input.'+nna+', input.'+wma+', input.'+hma+'" ).change(function(){var lng2 = parseFloat($(".'+nn+'").val()) || 0;var width2 = parseFloat($(" .'+wm+'").val()) || 0;var height2 = parseFloat($(".'+hm+'").val()) || 0;var newlen4 = lng2 * width2 * height2;newlen4_n = newlen4.toFixed(2);$(".'+tm+'").val(newlen4_n);var total_m2= parseFloat($(".'+tm+'").val()) || 0;var newlen5= (lng2 * 3.28084) * (width2 * 3.28084) * (height2 * 3.28084);newlen5_n = newlen5.toFixed(2);$(".'+tf+'").val(newlen5_n);});</' + 'script>');
      //--total

      //--Weight 1
        var minNumber5 = 1; // le minimum
        var maxNumber5 = 100000; // le maximum
        var d5 = Math.floor(Math.random() * (maxNumber5 + 1) + minNumber5);
        var wgm = "weight_cbm"+d5;
        var wgf = 'weight_cbf'+d5; 
        var wgl = 'weight_cbl'+d5;

        $("div.divclone:last .weight_cbm").addClass(wgm);
        $("div.divclone:last .weight_cbf").addClass(wgf);
        $("div.divclone:last .weight_cbl").addClass(wgl);

        $("div.divclone:last .weight_cbm").removeClass($("#weight_cbm").val());
        $("div.divclone:last .weight_cbf").removeClass($("#weight_cbf").val());  
        $("div.divclone:last .weight_cbl").removeClass($("#weight_cbl").val()); 

        $("div.divclone:last").append('<script>$(".'+wgm+'").change(function(){var wght2 = parseFloat($(".'+wgm+'" ).val()) || 0;var wght3=wght2/1000;var wght3_n=wght3.toFixed(2);var wght4=wght2*2.2046;var wght4_n=wght4.toFixed(2);$(".'+wgf+'").val(wght3_n);$(".'+wgl+'").val(wght4_n);});</' +'script>');
      //--Weight 1

      //--Weight 2
        var minNumber5 = 1; // le minimum
        var maxNumber5 = 100000; // le maximum
        var d5 = Math.floor(Math.random() * (maxNumber5 + 1) + minNumber5);
        var wgm = "weight_cbf"+d5;
        var wgf = 'weight_cbm'+d5; 
        var wgl = 'weight_cbl'+d5;

        $("div.divclone:last .weight_cbf").addClass(wgm);
        $("div.divclone:last .weight_cbm").addClass(wgf); 
        $("div.divclone:last .weight_cbl").addClass(wgl); 

        $("div.divclone:last .weight_cbf").removeClass($("#weight_cbf").val());
        $("div.divclone:last .weight_cbm").removeClass($("#weight_cbm").val());  
        $("div.divclone:last .weight_cbl").removeClass($("#weight_cbl").val()); 

        $("div.divclone:last").append('<script>$(".'+wgm+'").change(function(){var wght2 = parseFloat($(".'+wgm+'" ).val()) || 0;var wght3=wght2*1000;var wght3_n=wght3.toFixed(2);var wght4=wght2*2204.62;var wght4_n=wght4.toFixed(2);$(".'+wgf+'").val(wght3_n);$(".'+wgl+'").val(wght4_n);});</' + 'script>');
      //--Weight 2

      //--Weight 3
        var minNumber5 = 1; // le minimum
        var maxNumber5 = 100000; // le maximum
        var d5 = Math.floor(Math.random() * (maxNumber5 + 1) + minNumber5);
        var wgm = "weight_cbl"+d5;
        var wgf = 'weight_cbm'+d5; 
        var wgl = 'weight_cbf'+d5;

        $("div.divclone:last .weight_cbl").addClass(wgm);
        $("div.divclone:last .weight_cbm").addClass(wgf); 
        $("div.divclone:last .weight_cbf").addClass(wgl); 

        $("div.divclone:last .weight_cbl").removeClass($("#weight_cbl").val());
        $("div.divclone:last .weight_cbm").removeClass($("#weight_cbm").val());  
        $("div.divclone:last .weight_cbf").removeClass($("#weight_cbf").val()); 

        $("div.divclone:last").append('<script>$(".'+wgm+'").change(function(){var wght2 = parseFloat($(".'+wgm+'" ).val()) || 0;var wght3=wght2/2.2046;var wght3_n=wght3.toFixed(2);var wght4=wght2/2204.62;var wght4_n=wght4.toFixed(2);$(".'+wgf+'").val(wght3_n);$(".'+wgl+'").val(wght4_n);});</' + 'script>');
      //--Weight 3





    }); 
  });
</script>