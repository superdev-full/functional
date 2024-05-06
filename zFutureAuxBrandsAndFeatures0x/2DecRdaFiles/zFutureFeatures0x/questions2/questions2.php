<?php
include '../../main.php';
check_loggedin($con);
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
    <link rel="stylesheet" href="../../assets/css/all.css" />
    <link rel="stylesheet" href="questions2.css" />
  </head>
  <body class="questions-page">
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo rdaEnvironment ?> class="brand">
              <img class="img-fluid" width="240px" src="../../assets/images/logo.png" alt="" />
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
          <ul class="menu" id="menu">
            <li class="menu-item">
              <a href="../../askquestion" class="menu-link">Ask Question</a>
            </li>
            <li class="menu-item">
              <a href="../../yourquestions" class="menu-link active">Your Questions</a>
            </li>
            <li class="menu-item">
              <a href="../../messages" class="menu-link">Messages</a>
            </li>
            <li class="menu-item">
              <a href="../../settings" class="menu-link">Settings</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <section class="main-container px-2 px-sm-5">
      <h2 class="text-center mb-2">Your questions</h2>
      <div class="questions-container card p-3">
        <div class="row">
          <!--Start of Your Questions -->
          <div class="col-12 col-xl-4 mb-2 mb-xl-0 br pt-2">
            <div>
              <h3 class="mb-2 text-center">Your Questions</h3>
              <div class="card br-25 mb-3">
                <div class="card-header py-2">
                  <img
                    class="mr-2 my-auto"
                    src="../../assets/images/swift.png"
                    alt=""
                  />
                  <div class="name-text my-auto">UITableView error</div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="subtitle-box">
                    🤔&nbsp; Just a question on my mind
                  </div>
                  <div class="px-3 py-2">
                    <p class="mb-0">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis tempor incididunt ut
                      labore
                    </p>
                  </div>
                </div>
              </div>

              <div class="card br-25 bg-dgray mb-3">
                <div class="card-header py-2">
                  <img
                    class="mr-2 my-auto"
                    src="../../assets/images/apple.png"
                    alt=""
                  />
                  <div class="name-text my-auto">iOS 13 incompatibility</div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="subtitle-box">
                    😡&nbsp; Need a response ASAP
                  </div>
                  <div class="px-3 py-2">
                    <p class="mb-0">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua.
                    </p>
                  </div>
                </div>
              </div>

              <div class="card br-25 bg-dgray mb-3">
                <div class="card-header py-2">
                  <img
                    class="mr-2 my-auto"
                    src="../../assets/images/apple.png"
                    alt=""
                  />
                  <div class="name-text my-auto">iOS 13 incompatibility</div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="subtitle-box">
                    😡&nbsp; Need a response ASAP
                  </div>
                  <div class="px-3 py-2">
                    <p class="mb-0">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua.
                    </p>
                  </div>
                </div>
              </div>

              <div class="card br-25 bg-dgray mb-3">
                <div class="card-header py-2">
                  <img
                    class="mr-2 my-auto"
                    src="../../assets/images/apple.png"
                    alt=""
                  />
                  <div class="name-text my-auto">iPad OS 15 not working</div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="subtitle-box">😤&nbsp; Need a response right now</div>
                  <div class="px-3 py-2">
                    <p class="mb-0">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis tempor incididunt ut
                      labore
                    </p>
                  </div>
                </div>
              </div>

              <div class="card br-25 bg-lgray">
                <div class="card-header py-2">
                  <img
                    class="mr-2 my-auto"
                    src="../../assets/images/apple.png"
                    alt=""
                  />
                  <div class="name-text my-auto">iPad OS 15 not working</div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="subtitle-box">😤&nbsp; Need a response right now</div>
                  <div class="px-3 py-2">
                    <p class="mb-0">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis tempor incididunt ut
                      labore
                    </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!--End of Your Questions -->

          <!--Start Of Question Details -->
          <div class="col-12 col-xl-4 mb-2 mb-xl-0 br pt-2">
            <div>
              <h3 class="mb-2 text-center">question details</h3>
              <div class="card br-25 mb-3 px-2 py-3">
                <h4 class="text-center mb-3">iOS 13 incompatibility</h4>
                <div
                  class="topic-item-box d-flex flex-wrap justify-content-center"
                >
                  <div class="topic-item mr-2 mb-2">
                    <div class="close-btn mr-1">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1em"
                        height="1em"
                        preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 32 32"
                      >
                        <path
                          fill="currentColor"
                          d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"
                        ></path>
                      </svg>
                    </div>
                    <p class="mb-0">iOS</p>
                  </div>
                  <div class="topic-item mr-2 mb-2">
                    <div class="close-btn mr-1">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1em"
                        height="1em"
                        preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 32 32"
                      >
                        <path
                          fill="currentColor"
                          d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"
                        ></path>
                      </svg>
                    </div>
                    <p class="mb-0">swift 5.5</p>
                  </div>
                  <div class="topic-item mr-2 mb-2">
                    <div class="close-btn mr-1">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1em"
                        height="1em"
                        preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 32 32"
                      >
                        <path
                          fill="currentColor"
                          d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"
                        ></path>
                      </svg>
                    </div>
                    <p class="mb-0">Autolayout</p>
                  </div>
                  <div class="topic-item mb-2">
                    <div class="close-btn mr-1">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1em"
                        height="1em"
                        preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 32 32"
                      >
                        <path
                          fill="currentColor"
                          d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"
                        ></path>
                      </svg>
                    </div>
                    <p class="mb-0">XCode</p>
                  </div>
                </div>
                <div class="px-3 py-2">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. est laborum.
                    incididunt ut labore et dolore magna aliqua. incididunt ut
                    labore et dolore magna aliqua. Duis aute irure dolor in
                    reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. est laborum. incididunt ut labore et
                    dolore magna aliqua. incididunt ut labore et dolore magna
                    aliqua.
                  </p>
                  <img
                    class="w-100"
                    src="../../assets/images/code_img1.png"
                    alt=""
                  />
                </div>
              </div>
            </div>
          </div>
<!--End of Question Details-->
<!--Start of Solutions -->
          <div class="col-12 col-xl-4 pt-2">
            <div>
              <h3 class="mb-2 text-center">Solutions</h3>
              <div class="border-card br-25 mb-3">
                <div class="card-header pt-3 pb-2">
                  <div class="row w-100">
                    <div class="col-7 d-flex">
                      <img
                        class="mr-2 my-auto"
                        src="../../assets/images/avatar1.png"
                        alt=""
                      />
                      <div class="my-auto name-text">Annah Jolie</div>
                    </div>
                    <div class="col-5 d-flex">
                      <div class="star-ratings">
                        <div class="fill-ratings" style="width: 100%">
                          <span>★★★★★</span>
                        </div>
                        <div class="empty-ratings">
                          <span>★★★★★</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="px-3 py-0">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua.
                    </p>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                      ullamco laboris nisi ut aliquip ex ea commodo consequat.
                      Duis aute irure dolor in reprehenderit in voluptate velit
                      esse cillum dolore eu fugiat nulla pariatur. est laborum.
                      incididunt ut labore et dolore magna aliqua. incididunt ut
                      labore et dolore magna aliqua. Duis aute irure dolor in
                      reprehenderit in voluptate velit esse cillum dolore eu
                      fugiat nulla pariatur. est laborum. incididunt ut labore
                      et dolore magna aliqua. incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                    <div class="mb-3">
                      <img
                        class="w-100"
                        src="../../assets/images/code_img2.png"
                        alt=""
                      />
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
  <!--End of Solutions -->
        </div>
      </div>
    </section>
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2022 RubberDuckyAnswers</p>
      <ul class="flex-column flex-sm-row">
        <li><a href="../../terms">Terms of Service</a></li>
        <li><a href="../../privacy">Privacy Policy</a></li>
        <li><a href="../../blog">Blog</a></li>
        <li><a href="../../contact">Contact Us</a></li>
        <li><a href="../../investors">Investors</a></li>
      </ul>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/script/script.js"></script>
  </body>
</html>
