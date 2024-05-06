<?php
include 'main.php';
// No need for the user to see the login form if they're logged-in, so redirect them to the home page
// If the user is not logged in, redirect to the home page.
if (isset($_SESSION['loggedin'])) {
	header('Location:'. maverEnvironment . 'submitassignment');
	exit;
}
// Also check if they are "remembered"
if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme'])) {
	// If the remember me cookie matches one in the database then we can update the session variables.
	$stmt = $con->prepare('SELECT id, username, role FROM accounts WHERE rememberme = ?');
	$stmt->bind_param('s', $_COOKIE['rememberme']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		// Found a match
		$stmt->bind_result($id, $username, $role);
		$stmt->fetch();
		$stmt->close();
		// Authenticate the user
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $username;
		$_SESSION['id'] = $id;
		$_SESSION['role'] = $role;
		// Update last seen date
		$date = date('Y-m-d\TH:i:s');
		$stmt = $con->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
		$stmt->bind_param('si', $date, $id);
		$stmt->execute();
		$stmt->close();
		// Redirect to the home page
		header('Location:'. maverEnvironment . 'submitassignment');
		exit;
	}
}
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
    <meta name="description" content="Maver - 24/7 Friendly, Affordable, Step by Step & Correct Homework/Assignment Answers.">
    <meta name="keywords" content="24/7, Friendly, Affordable, Step by Step, Correct, Homework, Assignment, Answers, Math, Biology, Programming, Finance, Essays">
    <meta name="author" content="Maver">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P586LG8B9L"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-P586LG8B9L');
    </script>
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"/>
    <!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="./assets/css/all.css" />
    <link rel="stylesheet" href="./assets/css/all2.css" />
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
                src="./assets/images/brandName.png"
                alt=""
              />
            </a><!-- Closing a of brand  -->
          </div><!-- Closing Div of mr-3-->
          <div class="burger" id="burger">
            <span class="burger-open">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16">
                <g fill="#ffffff" fill-rule="evenodd">
                  <path d="M0 0h24v2H0zM0 7h24v2H0zM0 14h24v2H0z" />
                </g>
              </svg>
            </span>
            <span class="burger-close">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path
                  fill="#ffffff"
                  fill-rule="evenodd"
                  d="M17.778.808l1.414 1.414L11.414 10l7.778 7.778-1.414 1.414L10 11.414l-7.778 7.778-1.414-1.414L8.586 10 .808 2.222 2.222.808 10 8.586 17.778.808z"
                />
              </svg>
            </span>
          </div><!-- Closing Div of burger-->
        </div><!-- Closing Div of navbrand d-flex -->
        <div>
        <?php
        include_once "./views/common/top_menu.php";
        ?>
        </div>
      </nav>
    </header>
		<!-- End of Nav Header -->
		<!-- Start of Section -->
    <section class="main-container px-2 px-sm-5">
      <div class="w-100 text-center mb-4">
        <img
          class="img-fluid"
          width="100px"
          height="20px"
          src="./assets/images/logo.png"
          alt=""
        />
      </div>
      <div class="srh-container">
        <div class="srh-box">
          <input id="search" type="text" placeholder="What can we help you with?..." />
          <svg
            width="30px"
            height="30px"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
            role="img"
            preserveAspectRatio="xMidYMid meet"
            viewBox="0 0 1024 1024"
          >
            <path
              fill="currentColor"
              d="m795.904 750.72l124.992 124.928a32 32 0 0 1-45.248 45.248L750.656 795.904a416 416 0 1 1 45.248-45.248zM480 832a352 352 0 1 0 0-704a352 352 0 0 0 0 704z"
            ></path>
          </svg>
        </div><!-- Closing div of srh-box -->
        <ul class="drop"></ul>
      </div><!-- Closing div of srh-container -->
      <div class="p-3">
        <h4 class="text-center">Examples of things we can help you with:</h4>
        <div class="row pt-2">
          <div class="col-12 col-xl-4 mb-2 mb-xl-0">
            <div>
              <div class="card br-25 mb-2 p-0">
                <div class="card-header px-2 pb-2">
                  <img
                    class="mr-2 my-auto"
                    src="./assets/images/business.png"
                    alt=""
                  />
                  <div class="name-text my-auto">Develop a crisis management plan for a global company facing a reputational threat.</div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                  <p class="mb-0 body-text">
                      Create a plan for a global company to manage a reputational threat. Research and analyze crisis management strategies, and develop an effective plan that addresses the situation. Present your plan and recommendations to company executives.
                  </p>
                </div>
              </div>
              <div class="card br-25 mb-2">
                <div class="card-header px-2 pb-0">
                  <img
                    class="mr-2 my-auto"
                    src="./assets/images/nursing.png"
                    alt=""
                  />
                  <div class="name-text my-auto">Create a research proposal on the effectiveness of nurse-led interventions.</div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                  <p class="mb-0 body-text">
                     Develop a proposal to research the effectiveness of nurse-led interventions in healthcare. Use evidence-based research and analysis to design a study that can contribute to the nursing profession. Your proposal should include a detailed methodology, data collection methods, and analysis plan. You should also discuss potential limitations and ethical considerations. Finally, make a compelling case for why your study is important and how it can contribute to nursing knowledge.
                  </p>
                </div>
              </div>
              <div class="card br-25">
                <div class="card-header px-2 pb-0 mb-1">
                  <img
                    class="mr-2 my-auto"
                    src="./assets/images/criminaljustice.png"
                    alt=""
                  />
                  <div class="name-text my-auto">Write an essay on the ethical considerations of using predictive policing.</div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                  <p class="mb-0 body-text">
                      Research the ethical considerations of using predictive policing. Analyze its impact on communities, privacy rights, and potential for discrimination. Develop a comprehensive essay that argues for or against its use. Use critical thinking and strong writing skills to articulate your ideas effectively.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-4 mb-2 mb-xl-0">
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-2">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/psychology.png"
                  alt=""
                />
                <div class="name-text my-auto">Conduct a meta-analysis on psychological treatments for depression.</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    Conduct a meta-analysis of psychological treatments for depression. Collect and analyze data from previous studies to identify effective treatments. Develop a comprehensive report of your findings and present it to a panel of experts in the field. Use critical thinking and strong research skills to draw meaningful conclusions.
                </p>
              </div>
            </div>
            <div class="card br-25 mb-2">
              <div class="card-header px-3 pb-0 mb-2 pt-3">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/javascript.png"
                  alt=""
                />
                <div class="name-text my-auto">React/Next.js site doesn't load properly in Safari (blank page)?</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    I have a bug in my Next.js website, where when I open my site in Safari,
                    it sometimes loads and sometimes doesn't (almost 50/50 chance - shows a
                    blank page, but I can see outlines of some of my components, no text though).
                    It happens on both iOS/macOS versions of Safari. What is the root cause and
                    solution to this problem?
                </p>
              </div>
            </div>
            <div class="card br-25">
              <div class="card-header px-3 pb-0 mb-2 pt-3">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/biology.png"
                  alt=""
                />
                <div class="name-text my-auto">Design an experiment to study the effects of climate change on plant physiology.</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                   Design a comprehensive research plan to investigate the effect of climate change on plant physiology. Develop a clear hypothesis, identify key variables, and design an experiment that uses scientific methods to collect and analyze data. Your research plan should also include a detailed methodology and analysis plan, and address potential limitations and ethical considerations. Finally, write a detailed report of your findings, conclusions, and recommendations for future research in the field.
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-4">
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-0 mb-1">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/engineering.png"
                  alt=""
                />
                <div class="name-text my-auto">Develop a prototype for a sustainable energy system for a remote community.</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
Design and build a prototype for a sustainable energy system that can provide power to a remote community. Conduct research to identify the community's energy needs and develop a system that can meet those needs while minimizing environmental impact. Use engineering principles and techniques to create a functional prototype, and conduct rigorous testing and analysis to ensure its reliability and efficiency.
                </p>
              </div>
            </div>
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-2">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/finance.png"
                  alt=""
                />
                <div class="name-text my-auto">
                  Develop a financial model to evaluate an investment in a complex derivative product.
                </div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    Develop a financial model to evaluate the risks and returns of an investment in a complex derivative product. Use advanced mathematical and statistical techniques to assess the product's performance and identify key factors that can impact its value. Analyze the product's market and regulatory environment, and identify potential risks and opportunities.
                </p>
              </div>
            </div>
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-0">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/anthropology.png"
                  alt=""
                />
                <div class="name-text my-auto">Write an essay on cultural relativism and moral relativism.</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    Research cultural relativism and moral relativism. Analyze their similarities and differences, and their impact on cross-cultural understanding. Develop a comprehensive essay that argues for or against their validity and provides evidence to support your position. Your essay should demonstrate critical thinking, strong writing skills, and engage with counterarguments and alternative perspectives on the topic.
                </p>
              </div>
            </div>
          </div>
        </div><!-- Closing div of row pt-2 -->
      </div><!-- Closing div of p-3 -->
    </section><!-- Closing Section-->

<?php
include_once "./views/modals/signin_modal.php";

include_once "./views/modals/signup_modal.php";
?>


		<!-- Start of Footer -->
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2023 Maver</p>
      <ul class="flex-column flex-sm-row">
        <li><a href="./terms">Terms of Service</a></li>
        <li><a href="./privacy">Privacy Policy</a></li>
        <li><a href="./contact">Contact Us</a></li>
        <li><a href="./investors">Investors</a></li>
      </ul>
    </footer>
		<!-- End of Footer -->
		<!-- Start of Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/script/script.js"></script>
    <script src="./assets/script/suggestions.js"></script>
    <script src="./assets/script/modals.js"></script>
		<!-- End of Scripts -->
  </body>
		<!-- End of Body -->
</html>
