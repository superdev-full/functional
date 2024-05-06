<?php
include '../main.php';
check_loggedin($con);

include_once "../controllers/bids_controller.php";

$bid_id = $_GET["product_id"];

$bids_ctrl = new BidsController(true);
$bid_info = $bids_ctrl->get_bid( $bid_id );
?>
<!DOCTYPE html>
<html lang="en">
    <script
    src='//fw-cdn.com/4644767/3170686.js'
    chat='true'>
    </script>
  <head>
    <title>Maver</title>
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
            <a href=<?php echo maverEnvironment ?> class="brand">
              <img
                class="img-fluid"
                width="100px"
                height="20px"
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
              <a href="../submitassignment" class="menu-link">Submit Assignment</a>
            </li>
            <li class="menu-item">
              <a href="../yourassignments" class="menu-link"
                >Your Assignments</a
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


            <?php
            if($bid_info["status"]!="1"){
                ?>
                <div class="card" style="padding:20px;">
                    <div class="body">
                    <h3>Bid cannot be processed. Please contact support.</h3>
                    </div>
                </div>
                <?php
            }else{
            ?>
        			<br><br><br><br>
                <div class="card" style="padding:20px;">
					<center>
                    <h3>PayPal - Tutor's payment</h3>
                    <div class="body">

                        <h6>Price: <?php echo '$'.$bid_info['bid_amount'].' '.PAYPAL_CURRENCY; ?></h6>

                        <!-- Paypal payment form for displaying the buy button -->
                        <form action="<?php echo PAYPAL_URL; ?>" method="POST">
                            <!-- Identify your bussiness so that you can collect the payment -->
                            <input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT; ?>">

                            <!-- Specify a buy now button -->
                            <input type="hidden" name="cmd" value="_xclick">

                            <!-- Specify details about the item that buyers will purchase -->
                            <input type="hidden" name="item_name" value="Tutor payment for bid <?php echo $bid_id; ?>">
                            <input type="hidden" name="item_number" value="<?php echo $bid_id; ?>">
                            <input type="hidden" name="amount" value="<?php echo $bid_info['bid_amount']; ?>">
                            <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">

                            <!-- Specify URLs -->
                            <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
                            <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">

                            <!-- Display the payment button -->
                            <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="Buy Now" style="width:250px;"> <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
                        </form>
                    </div>
        				</center>        
				</div>
            <?php
            }
            ?>


</div>
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2023 Maver</p>
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
