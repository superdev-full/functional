<?php
include '../main.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RubberDuckyAnswers</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../assets/css/all.css" />
  </head>
  <body class="investors-page">
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
                  d="M17.778.808l1.414 1.414L11.414 10l7.778 7.778-1.414 1.414L10 11.414l-7.778 7.778-1.414-1.414L8.586 10 .808 2.222 2.222.808 10 8.586 17.778.808z"
                />
              </svg>
            </span>
          </div>
        </div>
        <div>
        </div>
      </nav>
    </header>

		<div class="main-container py-5">
      <h2 class="text-center mb-5">Investors Sign In</h2>
      <div>

				<div class="inv-signInForm inv-signInForm-main">
					<div class="inv-signIn">
        <form id="investorSignInForm" class="card py-5 px-4" action="../invsignin.php" method="post">
          <p>Please login to see events, presentations, monthly/quarterly reports, and eVote.</p>
          <div class="form-group mb-4">
            <input
              type="text"
              class="w-100"
              id="investorName"
              name="investorName"
              placeholder="Username"
              required
            />
          </div>
          <div class="form-group mb-4">
            <input
              name="investorPwd"
              id="investorPwd"
              placeholder="Password"
              required
            >
          </div>
           <div class="imsg"></div>
           
          <div class="">
          <button type="submit" id="investorSignInBtn">Submit</button>
          </div>
          
        </form>
      </div>
    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/script/script.js"></script>
<script>
// AJAX code
let loginForm = document.querySelectorAll(".inv-signInForm inv-signInForm-main, .inv-signIn form")[0];
loginForm.onsubmit = event => {
	event.preventDefault();
	fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm) }).then(response => response.text()).then(result => {
		if (result.toLowerCase().includes("success")) {
			window.location.href = "<?php echo rdaEnvironment ?>" + "investors";
		} else {
			document.querySelector(".imsg").innerHTML = result;
		}
	});
};
</script>
</body>
</html>
