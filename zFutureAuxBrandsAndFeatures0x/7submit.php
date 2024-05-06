<?php
 include 'main.php';
 if(isset($_POST['Submit']))
 {
  $ip = isset($_SERVER['HTTP_CLIENT_IP']) 
     ? $_SERVER['HTTP_CLIENT_IP'] 
    : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
      ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
      : $_SERVER['REMOTE_ADDR']);
  $choice = $_POST['choice'];
  $email = $_POST['email'];
  $text =  $ip . ", " . $choice . ", " . $email . "\n";
  $fp = fopen('dataInformation901x.txt', 'a+');

    if(fwrite($fp, $text))  {
        echo 'saved';

    }
fclose ($fp);    
}

header('Location:'. rdaEnvironment . 'thankyou');
?>

