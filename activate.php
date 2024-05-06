<?php
include 'main.php';
// Output message
$msg = '';
// First we check if the email and code exists, these variables will appear as parameters in the URL
if (isset($_GET['email'], $_GET['code']) && !empty($_GET['code'])) {
	$stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?');
	$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->close();
		// Account exists with the requested email and code.
		$stmt = $con->prepare('UPDATE accounts SET activation_code = "activated" WHERE email = ? AND activation_code = ?');
		// Set the new activation code to 'activated', this is how we can check if the user has activated their account.
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
		$stmt->close();
		$msg = 'Your account is now activated! You can now <b><a href="index.php">Login</a></b.';
	} else {
		$msg = 'The account is already activated or doesn\'t exist!';
	}
} else {
	$msg = 'No code and/or email was specified!';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Maver</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"/>
    <!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="./assets/css/all.css" />
    <link rel="stylesheet" href="./assets/css/all2.css" />
    <style>
    a { color: white; }
    </style>
  </head>
	<!-- Start of Body -->
  <body class="index-page">
		<!-- Start of Nav Header -->
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo maverEnvironment ?> class="brand">
              <img
                class="img-fluid"
                width="240px"
                src="./assets/images/logo.png"
                alt=""
              />
            </a><!-- Closing a of brand  -->
          </div><!-- Closing Div of mr-3-->
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
                  d="M17.778.808l1.414 1.414L11.414 10l7.778 7.778-1.414 1.414L10 11.414l-7.778 7.778-1.414-1.414L8.586 10 .808 2.222 2.222.808 10 8.586 17.778.808z"
                />
              </svg>
            </span>
          </div><!-- Closing Div of burger-->
        </div><!-- Closing Div of navbrand d-flex -->
      </nav>
    </header>
		<!-- End of Nav Header -->
		<!-- Start of Section -->
    <section class="main-container px-2 px-sm-5">
      <center><p style="color:white;"><?=$msg?></p></center>
    </section>
    <!-- Closing Section-->
		<!-- Start of Footer -->
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2023 Maver</p>
      <ul class="flex-column flex-sm-row">
        <li><a href="./terms">Terms of Service</a></li>
        <li><a href="./privacy">Privacy Policy</a></li>
        <li><a href="./blog">Blog</a></li>
        <li><a href="./contact">Contact Us</a></li>
        <li><a href="./investors">Investors</a></li>
      </ul>
    </footer>
    <!-- End of Footer -->
    <!-- Start of Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> -->
    <!-- End of Scripts -->
  </body>
		<!-- End of Body -->
</html>
