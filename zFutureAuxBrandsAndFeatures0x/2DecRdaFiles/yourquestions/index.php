<?php
include '../main.php';
check_loggedin($con);

include_once "../controllers/question_controller.php";

$question_ctrl = new QuestionController(true);
$user_id = $_SESSION['id'];
$questions_list_data = $question_ctrl->get_questions_list( $user_id );
$questions_first_id = $questions_list_data[0];
$questions_view_list = $questions_list_data[1];

include_once "../controllers/bids_controller.php";

$bids_ctrl = new BidsController(false);
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
    <link rel="stylesheet" href="../assets/css/all2.css" />
    <link rel="stylesheet" href="../assets/css/questions.css" />
  </head>
  <body class="questions-page">
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
        <?php 
        $current_page = "yourquestions";
        include_once "../views/common/top_menu.php";
        ?>              
        </div>
      </nav>
    </header>
    <section class="main-container px-2 px-sm-5">
      <h2 class="text-center mb-3">Your Questions</h2>
      <div class="questions-container card py-3 px-3">
        <div>
          <div class="row">
            <div class="col-12 col-xl-4 mb-3 mb-xl-0 br pt-2">
              <div id="questions_list">
                <h3 class="mb-2 text-center">Your Questions</h3>
                
                <?php
                echo $questions_view_list;
                ?>

              </div>
            </div>
            <!--End of Your Questions-->

            <!--Start of Question Detail-->
            <div class="col-12 col-xl-4 mb-3 mb-xl-0 br pt-2">
              <div>
                <h3 class="mb-2 text-center">question details</h3>

                  <div id="question_detail" class="card br-25 px-2 py-3" data-qid="-1">
                    <?php
                    $question_detail = $question_ctrl->get_question_detail( $questions_first_id );
                    echo $question_detail;
                    ?>	
                </div>
              </div>
            </div>            

            <!--End of Question Detail-->

            <!--Start of Candidates-->
            <div class="col-12 col-xl-4 pt-2">
              <div id="question_candidates">
                <h3 class="mb-2 text-center">Candidates</h3>

                    <?php
                    $role = "Member"; //$_SESSION['role']
                    $list = $bids_ctrl->get_candidates_list( $questions_first_id, $_SESSION["id"], $role);
                    echo $list[1];
                    ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php 
if(empty($_SESSION['id'])){
include_once "../views/modals/signin_modal.php";
include_once "../views/modals/signup_modal.php";
}
?>    
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
    <script src="../assets/script/yourquestions.js"></script>
    <?php if(empty($_SESSION['id'])){ ?>
    <script src="../assets/script/modals.js"></script>
    <?php } ?>
  </body>
</html>
