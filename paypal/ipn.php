<?php
include '../main.php';

include_once "../controllers/bids_controller.php";

/*
Read Post Data
Reading posted data directly from $_POST causes serialization
Issues with array data in POST
Reading raw POST data from input stream intend.
*/

$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();

$myfile = fopen("ipn.log", "a") or die("Unable to open file!");
fwrite($myfile, date("Y-m-d h:i:s") . "\n");
fwrite($myfile, $raw_post_data);
$txt = "\n";
fwrite($myfile, $txt);
fclose($myfile);

foreach($raw_post_array as $keyval){
    $keyval = explode('=', $keyval);
    if(count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}

//Read the post from paypal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')){
    $get_magic_quotes_exists = true;
}

foreach($myPost as $key => $value){
    if($get_magic_quotes_exists == true){
        $value = urlencode(stripslashes($value));
    }else{
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}

/*
Post IPN data back to paypal to validate the IPN data is genuine
Without this step anyone can fake IPN data
*/

$paypalURL = PAYPAL_URL;
$ch = curl_init($paypalURL);
if($ch == FALSE){
    return FALSE;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

//Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: PHP-IPN-VerificationScript'));
$res = curl_exec($ch);

/*
Inspect IPN validation result and act accordingly 
Split response headers and payload, a better way for strcmp
*/

$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));

$myfile = fopen("ipn.log", "a") or die("Unable to open file!");
fwrite($myfile, $res . "\n");
fclose($myfile);

if(strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0){

    //Retrive transaction infro from paypal
    $item_number    = $_POST['item_number'];
    $txn_id         = $_POST['txn_id'];
    $payment_gross  = $_POST['mc_gross'];
    $currency_code  = $_POST['mc_currency'];
    $payment_status = $_POST['payment_status'];

    $bid_id = $item_number;

    //Check if transation data exists with the same TXN ID
    $bids_ctrl = new BidsController(true);
    $payment_info = $bids_ctrl->get_payment( $txn_id );
    //update the bid itself
    $bids_ctrl->set_payment_date( $bid_id );   


    if($payment_info["status"]==1){
        exit();
    }else{
        //Insert transaction data into the database
        $data = array(
            "item_number"     => $item_number,
            "txn_id"          => $txn_id,
            "payment_gross"   => $payment_gross,
            "currency_code"   => $currency_code,
            "payment_status"  => $payment_status
          );
        $payment_id = $bids_ctrl->create_payment($data);
    }

}