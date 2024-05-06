<?php
include 'main.php';
// No need for the user to see the login form if they're logged-in, so redirect them to the home page
// If the user is not logged in, redirect to the home page.
if (isset($_SESSION['loggedin'])) {
	header('Location:'. rdaEnvironment . 'askquestion');
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
		header('Location:'. rdaEnvironment . 'askquestion');
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RubberDuckyAnswers</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="RubberDuckyAnswers - 24/7 Friendly, Affordable, Step by Step & Correct Programming/Coding Answers.">
    <meta name="keywords" content="24/7, Friendly, Affordable, Step by Step, Correct, Programming, Coding, Answers, HTML, CSS, JavaScript, Java, Python, React, Angular, Spring, Boot, SpringBoot, Compile, Error, Node">
    <meta name="author" content="RubberDuckyAnswers">
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
            <a href=<?php echo rdaEnvironment ?> class="brand">
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
          width="210px"
          src="./assets/images/LogoDucky.png"
          alt=""
        />
      </div>
      <div class="srh-container">
        <div class="srh-box">
          <input id="search" type="text" placeholder="Type your question..." />
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
        <h4 class="text-center">Example questions you can ask:</h4>
        <div class="row pt-2">
          <div class="col-12 col-xl-4 mb-2 mb-xl-0">
            <div>
              <div class="card br-25 mb-2 p-0">
                <div class="card-header px-2 pb-2">
                  <img
                    class="mr-2 my-auto"
                    src="./assets/images/swift.png"
                    alt=""
                  />
                  <div class="name-text my-auto">How to get selected UICollectionViewCell?</div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                  <p class="mb-0 body-text">
                      I have a UICollection view with more sections. I want to get the selected custom cell to change the background,
                      but when I click on it the app crashes and says "unexpectedly found nil while unwrapping an Optional value".
                      Is there a problem with my BrandCollectionCell or is the problem something else in Swift?
                  </p>
                </div>
              </div>
              <div class="card br-25 mb-2">
                <div class="card-header px-2 pb-0">
                  <img
                    class="mr-2 my-auto"
                    src="./assets/images/linux.png"
                    alt=""
                  />
                  <div class="name-text my-auto">How to Generate Regular Expression?</div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                  <p class="mb-0 body-text">
                      Hello. I am trying to generate a regex expression that will match when the first
                      and the last char of a string are the same. How do I do this?
                  </p>
                </div>
              </div>
              <div class="card br-25">
                <div class="card-header px-2 pb-0 mb-1">
                  <img
                    class="mr-2 my-auto"
                    src="./assets/images/apple.png"
                    alt=""
                  />
                  <div class="name-text my-auto">How to get a specific video area in Swift AVPlayer?</div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                  <p class="mb-0 body-text">
                      I am working on Swift based macOS application. The user will choose a video file and
                      the NSView Controller will play the video using AVPlayerView. The user can then draw
                      a rectangle over the AVPlayerView. How do I show the selected area video in a rectangle
                      to a camera Preview Layer on the right bottom?
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
                  src="./assets/images/github.png"
                  alt=""
                />
                <div class="name-text my-auto">How do I avoid error while pushing to Github?</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    I have a question. I can commit changes flawlessly while working with Github
                    Desktop but when I try to commit using Android Studio's "Commit Changes" button
                    I receive the error "failed with error: fatal: unable to access 'https://github
                    . ... .git/': The requested URL returned error: 403." How do I avoid/fix this error?
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
                  src="./assets/images/devicon.png"
                  alt=""
                />
                <div class="name-text my-auto">Responsive column layout with CSS/HTML?</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    I'm trying to achieve following layout with HTML/CSS, where the navigation elements
                    "A" and "C" are situated above the main content "B" on small screens and distributed
                    corresponding to the left "A" and right "C" on larger screens. My goal is to use
                    constant HTML-elements and only change CSS-styles based on media-queries. How to
                    achieve this?
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-4">
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-0 mb-1">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/apple.png"
                  alt=""
                />
                <div class="name-text my-auto">How do you make SwiftUI's Picker borderless/transparent on macOS?</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    I am developing a application and I am trying to set a picker button borderless and transparent
                    in SwiftUI on MacOS. I have tried using .background(), .border() and .opacity() to no avail,
                    how do I do this?
                </p>
              </div>
            </div>
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-2">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/swift.png"
                  alt=""
                />
                <div class="name-text my-auto">
                  How do I build a 2D game board with a player using Swift?
                </div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    I would like to create a 2D game board (like a chess board) with a player using Swift.
                    How do I create a game board that will initially have 9 squares(3x3), each square has a
                    value inside (Ex: Int = 1), player starts at the center of the board, when you move the
                    player to the edge of the board the board will expand, and when you as the player moves
                    it will change the value inside each square from 0 to 1?
                </p>
              </div>
            </div>
            <div class="card br-25 mb-2">
              <div class="card-header px-2 pb-0">
                <img
                  class="mr-2 my-auto"
                  src="./assets/images/linux.png"
                  alt=""
                />
                <div class="name-text my-auto">How can I write C code to create a tree using fork()?</div>
              </div>
              <div class="card-body px-3 pt-0 pb-2">
                <p class="mb-0 body-text">
                    How can I write C code to create a new process using fork() while also at the same time
                    using the functions: wait (0), getpid() and getppid() to print the id and the parent
                    process id for each process that is created?
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
      <p class="mb-0">@2022 RubberDuckyAnswers</p>
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
