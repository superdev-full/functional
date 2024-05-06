<?php
include '../main.php';
check_loggedin($con);

include_once "../controllers/bids_controller.php";
//var_dump($_GET);

//If Transaction Data is Available in the URL
if(!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])){
    //Get Transaction Information from URL
    // https://dev.rubberduckyanswers.com/paypal/success.php?item_number=40&tx=97798184WB6613906&amt=1&cc=USD&st=Completed
    // https://dev.rubberduckyanswers.com/paypal/success.php?item_number=42&tx=7KC47686930364711&amt=1&cc=USD&st=Completed
    // https://dev.rubberduckyanswers.com/paypal/success.php?item_number=43&tx=4SK458144J118531C&amt=1&cc=USD&st=Completed
    $item_number    = $_GET['item_number'];
    $txn_id         = $_GET['tx'];
    $payment_gross  = $_GET['amt'];
    $currency_code  = $_GET['cc'];
    $payment_status = $_GET['st'];

    $bid_id = $item_number;

    //Get Product infomation from the database
    $bids_ctrl = new BidsController(true);
    $bid_info = $bids_ctrl->get_bid( $bid_id );

    //Check if transaction data exists with the same TXN ID
    $payment_info = $bids_ctrl->get_payment( $txn_id );

    if($payment_info["status"]==1){
        $payment_id     = $payment_info['payment_id'];
        $payment_gross  = $payment_info['payment_gross'];
        $payment_status = $payment_info['payment_status'];
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
        //update the bid itself
        $bids_ctrl->set_payment_date( $bid_id );
    }  
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RubberDuckyAnswers</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../assets/css/all.css" />
  </head>
  <body class="message-page">
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo rdaEnvironment ?> class="brand">
              <img
                class="img-fluid"
                width="240px"
                src="../assets/images/logo.png"
                alt=""
              />
            </a>
          </div>
          <div class="burger" id="burger">
            <span class="burger-open">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16">
                <g fill="#252a32" fill-rule="evenodd">
                  <path d="M0 0h24v2H0zM0 7h24v2H0zM0 14h24v2H0z" />
                </g>
              </svg>
            </span>
            <span class="burger-close">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path
                  fill="#252a32"
                  fill-rule="evenodd"
                  d="M17.778.808l1.414 1.414L11.414 10l7.778 7.778-1.414 1.414L10\
                   11.414l-7.778 7.778-1.414-1.414L8.586 10 .808 2.222 2.222.808\
                   10 8.586 17.778.808z"
                />
              </svg>
            </span>
          </div>
        </div>
        <div>
          <ul class="menu" id="menu">
            <li class="menu-item">
              <a href="../askquestion" class="menu-link">Ask Question</a>
            </li>
            <li class="menu-item">
              <a href="../yourquestions" class="menu-link"
                >Your Questions</a
              >
            </li>
            <li class="menu-item">
              <a href="../messages" class="menu-link">Messages</a>
            </li>
            <li class="menu-item">
              <a href="../settings" class="menu-link">Settings</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="main-container">



        <div class="card"  style="padding:20px;">
            <div class="body">
                <?php if(!empty($payment_id)){ ?>
                    <h1 class="success">Your Payment has been successful</h1>

                    <h4>Payment Information</h4>
                    <p><b>Reference Number:</b> <?php echo $payment_id; ?></p>
                    <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
                    <p><b>Paid Amount:</b> <?php echo $payment_gross; ?></p>
                    <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>

                    <h4>Bid Information</h4>
                    <p><b>Name:</b> Tutor's Bid payment</p>
                    <p><b>Price:</b> <?php echo $bid_info['bid_amount']; ?></p>
                <?php }else{ ?>
                    <h1 class="error">Your payment could not be retrieved.</h1>
                <?php } ?>
            </div>
            <a href="../yourquestions" class="btn-link">Back to Your Questions</a>
        </div>

</div>
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2022 RubberDuckyAnswers</p>
      <ul class="flex-column flex-sm-row">
        <li><a href="../terms">Terms of Service</a></li>
        <li><a href="../privacy">Privacy Policy</a></li>
        <li><a href="../contact">Contact Us</a></li>
        <li><a href="../investors">Investors</a></li>
      </ul>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script/script.js"></script>
  </body>
</html>
