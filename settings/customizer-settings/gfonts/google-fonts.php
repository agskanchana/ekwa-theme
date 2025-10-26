<?php
// google api key
$google_api_key = "AIzaSyC4q_ND3Fdt2XdTCNsdyZi7fckGAqEwxD4";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=" . $google_api_key);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
$fonts_list = json_decode(curl_exec($ch), true);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($http_code != 200) {
   $google_fonts = "";
}
else{


// echo out list of fonts

$fonts_list =  $fonts_list['items'];

 $google_fonts = array('custom' => 'custom',);

foreach($fonts_list  as $key => $font ){
    $google_fonts = array_merge($google_fonts, array($key => $font['family']) );
}

//print_r($google_fonts);


/*
function getvarient($varients){
        foreach($varients as $v){
            return " Varients : ". $v." , ";
        }
    }

foreach($fonts_list as $font){

     $varient = $font['variants'];
    
    echo "<strong>".$font['family']. "</strong>".getvarient($varient)."<br>";
    
   
}*/
}