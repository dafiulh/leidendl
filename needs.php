<?php

$res = array(1=>"Very Low",2=>"Low",3=>"Middle",4=>"Middle High",5=>"High");
$aes128_pw = "dafhx128root";

function siteURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['SERVER_NAME'];
    return $protocol.'/'.$domainName;
}

?>