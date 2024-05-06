<?php
include '../main.php';
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
  <body class="contact-page">
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
      <h2 class="text-center mb-5">Contact Us</h2>
      <div>
          <div class="contact-submitForm contact-submitForm-main">
              <div class="contact-submit">
        <form id="contactForm" class="card py-5 px-4" action="../submit.php" method="post">
          <p>Please feel free to contact us if you have any questions, comments or concerns
          regarding general website use, billing and payments, or press inquiries. We try to
          respond to all inquiries within 72 hours, thank you.</p>
          <div class="form-group mb-4">
            <input
              type="text"
              class="w-100"
              id="contactName"
              name="contactName"
              placeholder="Name"
              required
            />
          </div>
          <div class="form-group mb-4">
            <input
              type="email"
              class="w-100"
              id="contactEmail"
              name="contactEmail"
              placeholder="E-Mail"
              required
            />
          </div>
          <div class="form-group mb-4">
            <textarea
              name="contactMsg"
              id="contactMsg"
              placeholder="Message"
              rows="6"
            ></textarea>
          </div>
          <div class="cmsg"></div>
          <div class="">
            <button type="submit" id="contactBtn" name="Submit" value="Submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script/script.js"></script>
    <script>
// AJAX code
let loginForm = document.querySelectorAll(".contact-submitForm contact-submitForm-main, .contact-submit form")[0];
loginForm.onsubmit = event => {
	event.preventDefault();
	fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm) }).then(response => response.text()).then(result => {
		if (result.toLowerCase().includes("success")) {
		    document.querySelector(".cmsg").innerHTML = result;
		} else {
			document.querySelector(".cmsg").innerHTML = result;
		}
	});
};
</script>
  </body>
</html>
