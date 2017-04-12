<html>
    <body>
        <style>
            @media only screen and (min-width:320px) and (max-width: 640px){
                margin-left:0px;	
            }
        </style>
        <div style="float: left; border: 3px solid rgb(0, 84, 166); width: auto; padding: 15px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">
            <div style="border-bottom: 1px solid rgb(0, 84, 166);   padding-bottom: 4px; padding-left: 20px;  padding-top: 8px; margin-bottom: 39px; background:#0054A6;">
                <img src="<?php echo URL::to('/');?>/assets/img/logo1.png">
            </div>
            @yield('content')
            <p><table style='text-align:left;'>
                <?php 
                    $locale = App::getLocale(); 
                    if($locale == "es"){
                ?>
                        <tr> <th style='font-size:14px; color:#0054A6;'>Cordialmente,</th></tr>
                        <tr><td style='font-size:14px;'>EASEFREIGHT</td></tr>
                <?php    
                    }else{
                ?>
                        <tr> <th style='font-size:14px; color:#0054A6;'>Best Regards,</th></tr>
                        <tr><td style='font-size:14px;'>EASEFREIGHT</td></tr>
                <?php
                    }
                ?>
                
            </table></p>
        </div>
    </body>
    
</html>