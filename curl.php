<?php
//Get the $target_url here from $_GET[];
$target_url = "/ease-freight/public/quote/response?paymentRef=19";
$ch = curl_init("http://easefreight.com");
$fp = fopen("$target_url", "r");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FILE, $fp);

curl_exec($ch);
curl_close($ch);
fclose($fp);
?>