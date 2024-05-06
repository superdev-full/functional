<?php
$ip = isset($_SERVER['HTTP_CLIENT_IP']) 
? $_SERVER['HTTP_CLIENT_IP'] 
: (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
? $_SERVER['HTTP_X_FORWARDED_FOR'] 
: $_SERVER['REMOTE_ADDR']);
$contactName = $_POST['contactName'];
$contactEmail = $_POST['contactEmail'];
$contactMsg = $_POST['contactMsg'];
$text =  $ip . ", " . $contactName . ", " . $contactEmail . ", " . $contactMsg . "\n";
$fp = fopen('zcontactInformation900x.txt', 'a+');
     
if(fwrite($fp, $text))  {
    echo 'Message Sent';
}
fclose ($fp);    
?>

