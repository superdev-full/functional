<?php
/* JustMaverIt Environment */
// define('maverEnvironment'		, 'https://justmaverit.com/');
// define('BASE_PATH'			, '/home/build428/justmaverit.com/');

/* Local Environment */
define('maverEnvironment'		, 'http://localhost:9999/');
define('BASE_PATH'			, '/home/build428/justmaverit.com/');

/* PAYPAL */
// PayPal Business account.
define('PAYPAL_CLIENT_ID'	,'AdULZqArH6lPS_DfnTb2llHbqI95FWjWVW-qILXAanTsQQ9FbXFFK6TKUQ4bEHu5-ehzUv8ULBOX4QV9');
define('PAYPAL_SECRET_KEY'	,'EAIp9gS4F8iVRMfRt5Dq8yl3XukeBzNJaeXQqfRSqysK7xrTTBkM8CW6LJyPo4P2VpFXNMX9GezWC2v-');
// define('PAYPAL_CLIENT_ID'	,'AaXCD-6IB8SVUUa6iA3FdjyPCXaoCUuVf4X8z2fjOgqBvsyIUYgzJnitB5cUn6Qb-hN92icAW71B6t6E');
// define('PAYPAL_SECRET_KEY'	,'EOoqhSKSBQDLrtpSzLKmhCGJX8fEwMskhDm-Xw1uuKuy9PnWR92c474wOQU2ztlFir2geOIYzwIs3SnG');
define('PAYPAL_ID'			,'hello@rubberduckyanswers.com');
define('PAYPAL_SANDBOX_ID'	,'sb-hgqi4322032935@business.example.com');
// define('PAYPAL_SANDBOX_ID'	,'support-facilitator@myectmods.com');

// Sandbox environment  ?
define('PAYPAL_SANDBOX'		,false);
// Page payment.
define('PAYPAL_PAYMENT_PAGE_URL'	,maverEnvironment . 'paypal/payment.php');
// Successfull payment.
define('PAYPAL_RETURN_URL'	,maverEnvironment . 'paypal/success.php');
// Failed or Cancelled payment
define('PAYPAL_CANCEL_URL'	,maverEnvironment . 'paypal/cancel.php');
// PayPal IPN.
define('PAYPAL_NOTIFY_URL'	,maverEnvironment . 'paypal/ipn.php');
// currency code.
define('PAYPAL_CURRENCY'	,'USD');
// Set paypal url depending on test mode
define('PAYPAL_ACCOUNT', (PAYPAL_SANDBOX == true) ? PAYPAL_SANDBOX_ID : PAYPAL_ID);
define('PAYPAL_URL', (PAYPAL_SANDBOX == true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr");
//--------------

/* DATABASE */
// database hostname - you don't usually need to change this
define('db_host'			,'localhost');
// database user
// define('db_user'			,'build428_justmaveritadm');
// // database password
// define('db_pass'			,'350862435033212@L');

define('db_user'			,'root');
define('db_pass'			,'');


// database name
define('db_name'			,'build428_1justmaverit');
// database charset - change this only if utf8 is unsupported by your language
define('db_charset'			,'utf8');
//--------------

/* Account Registration */
// Disable the new account
define('disable_registration'		,false);
// Allow auto login after registration
define('auto_login_after_register'	,true);
//--------------

/* Account Activation */
// Email activation variables
// account activation required?
define('account_activation'	,false);
// Change "Your Company Name" and "yourdomain.com" - do not remove the < and > characters
define('mail_from'			,'JustMaverIt <noreply@justmaverit.com>');
// Link to activation file
define('activation_link'	, maverEnvironment . 'activate.php');
//--------------

/* Folders and Paths */
// Attachments upload folder
define('UPLOAD_PATH'		, BASE_PATH . 'uploads/');
define('UPLOAD_PATH_URL'	, maverEnvironment . 'uploads/');
// Email templates folder
define('EMAILS_PATH'		, BASE_PATH . 'views/emails/');
// Avatars upload folder & URL
define('AVATARS_UPLOAD_PATH', UPLOAD_PATH );
define('AVATARS_PATH_URL'	, maverEnvironment . 'uploads/');
// Messages upload folder
define('MESSAGES_UPLOAD_PATH', UPLOAD_PATH . 'm/');
define('MESSAGES_PATH_URL'	 , maverEnvironment . 'uploads/m/');
//--------------

/* Assignment's content Limits to fit in UI*/
define('A_TITLE_LIMIT'		, 255);
define('A_DESCRIPTION_LIMIT', 500);
//--------------
?>
