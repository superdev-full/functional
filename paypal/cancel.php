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
  <body class="message-page">
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo maverEnvironment ?> class="brand">
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

                <div class="card" style="padding:20px;">
                    <div class="body">
                    <h3>Your PayPal Transaction has been canceled!</h3>
                    <a href="../yourassignments" class="btn-link">Back to your assignments</a>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script/script.js"></script>
  </body>
</html>
