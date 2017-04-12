<?php
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    // function route($name, $parameters = [], $absolute = true, $route = null){
    // if (!isset($parameters['lang'])) $parameters['lang'] = App::getLocale();
    //     return app('url')->route($name, $parameters, $absolute, $route);
    // }

    function newurl($string){
        if(App::getLocale() != "es"){
             $string = "/".App::getLocale().$string;
        }else{
            $string  = $string;
        }

        $url = url($string);
        return $url;
    }


    function GetDays($sStartDate, $sEndDate){  
      // Firstly, format the provided dates.  
      // This function works best with YYYY-MM-DD  
      // but other date formats will work thanks  
      // to strtotime().  
      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
      
      // Start the variable off with the start date  
      $aDays[] = $sStartDate;  
      
      // Set a 'temp' variable, sCurrentDate, with  
      // the start date - before beginning the loop  
      $sCurrentDate = $sStartDate;  
      
      // While the current date is less than the end date  
      while($sCurrentDate < $sEndDate){  
        // Add a day to the current date  
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
      
        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;  
      }  
      
      // Once the loop has finished, return the  
      // array of days.  
      return $aDays;  
    } 

    function airfreightdates($discontinue_date, $week_days, $startlimit=1, $limit=10, $start_date=""){
      //dd($week_days);
      sort($week_days);
      $start = time();
      $end = strtotime($discontinue_date);
      $dates = array();
      $a = 0;
      $b = 1;
      if($end >= $start){
        $date1 = date("d-m-Y");
        if(@$start_date){
          $date1 = $start_date;
        }
        $date2 = date("d-m-Y",strtotime($discontinue_date));
        $diff = GetDays($date1,$date2);
        $thisweek = date("W");

        foreach ($diff as $value) {
            $dateweek = date("W",strtotime($value));
            $day = date("N",strtotime($value));
            
            if(in_array($day, $week_days)){
                
                if((int)$b >= (int)$startlimit) {
                    $dates[$a] = date("Y-m-d",strtotime($value));
                    $a++;
                    if(count($dates) == $limit){
                        break;
                    }
                }
                $b++;
            }
        }
          //print_r($dates);
      }
      return $dates;
    }

    function oceanfreightdates($discontinue_date, $days=NULL, $startlimit=1, $limit=10, $start_date="",$freq=NULL,$spot_date=NULL){
     //dd($days);
      if(@$days){
        sort($days);
      }
      $start = time();
      $end = strtotime($discontinue_date);
      $dates = array();
      $a = 0;
      $b = 1;
      
      if($end >= $start){

          $date1 = date("d-m-Y");
          if(@$start_date){
            $date1 = $start_date;
          }
          $date2 = date("d-m-Y",strtotime($discontinue_date));
          $diff = GetDays($date1,$date2);
          
          if($freq == "spot"){
            $dates[$a] = date("Y-m-d",strtotime($spot_date));
            $a++;
          }elseif($freq == "weekly"){
            $thisweek = date("W");
            //print_r($diff);
            foreach ($diff as $value) {
                $dateweek = date("W",strtotime($value));
               
                $day = date("N",strtotime($value));
                if(in_array($day, $days)){
                    
                    if((int)$b >= (int)$startlimit) {
                        $dates[$a] = date("Y-m-d",strtotime($value));
                        $a++;
                        if(count($dates) == $limit){
                            break;
                        }
                    }
                    $b++;
                }
            }
          }else{
            foreach ($diff as $value) {
              //$dateweek = date("W",strtotime($value));
              $day = date("d",strtotime($value));
              
              if(in_array($day, $days)){
                  
                  if((int)$b >= (int)$startlimit) {
                      $dates[$a] = date("Y-m-d",strtotime($value));
                      $a++;
                      if(count($dates) == $limit){
                          break;
                      }
                  }
                  $b++;
              }
            }
          }
          
      }
      return $dates;
    }

    function currency($amount,$from_Currency,$to_Currency) {
      $amount = urlencode($amount);
      $from_Currency = urlencode($from_Currency);
      $to_Currency = urlencode($to_Currency);
      $get_amount =file_get_contents("https://www.google.com/finance/converter?a=".$amount."&from=".$from_Currency."&to=".$to_Currency);
      $get_amount = explode("<span class=bld>",$get_amount);
      $get_amount = explode("</span>",$get_amount[1]); 
      $converted_amount = preg_replace("/[^0-9\.]/", null, $get_amount[0]);
      return $converted_amount;

    }


    function pdfConverter($content) {
      require_once(public_path().'/html2pdf/autoload.inc.php');
      $dompdf = new Dompdf();
      $dompdf->loadHtml('hello world');

      // (Optional) Setup the paper size and orientation
      $dompdf->setPaper('A4', 'landscape');

      // Render the HTML as PDF
      $dompdf->render();

      // Output the generated PDF to Browser
      $dompdf->stream();
    }

    function numberFormat($payment){
      return number_format($payment,2, '.', ',');
    }