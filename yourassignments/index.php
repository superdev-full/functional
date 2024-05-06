<?php
include '../main.php';
check_loggedin($con);

include_once "../controllers/assignment_controller.php";

$assignment_ctrl = new AssignmentController(true);
$user_id = $_SESSION['id'];
$assignments_list_data = $assignment_ctrl->get_assignments_list( $user_id );
$assignments_first_id = $assignments_list_data[0];
$assignments_view_list = $assignments_list_data[1];

include_once "../controllers/bids_controller.php";

$bids_ctrl = new BidsController(false);
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
    <link rel="stylesheet" href="../assets/css/all2.css" />
    <link rel="stylesheet" href="../assets/css/assignments.css" />
  </head>
  <body class="assignments-page">
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
          </div>
        </div>
        <div>
        <?php
        $current_page = "yourassignments";
        include_once "../views/common/top_menu.php";
        ?>
        </div>
      </nav>
    </header>
    <section class="main-container px-2 px-sm-5">
      <h2 class="text-center mb-3">Your Assignments</h2>
      <div class="assignments-container card py-3 px-3">
        <div>
          <div class="row">
            <div class="col-12 col-xl-4 mb-3 mb-xl-0 br pt-2">
              <div id="assignments_list">
                <h3 class="mb-2 text-center">Your Assignments</h3>

                <?php
                echo $assignments_view_list;
                ?>

              </div>
            </div>
            <!--End of Your Assignments-->

            <!--Start of Assignment Detail-->
            <div class="col-12 col-xl-4 mb-3 mb-xl-0 br pt-2">
              <div>
                <h3 class="mb-2 text-center">assignment details</h3>

                  <div id="assignment_detail" class="card br-25 px-2 py-3" data-qid="-1">
                    <?php
                    $assignment_detail = $assignment_ctrl->get_assignment_detail( $assignments_first_id );
                    echo $assignment_detail;
                    ?>
                </div>
              </div>
            </div>

            <!--End of Assignment Detail-->

            <!--Start of Candidates-->
            <div class="col-12 col-xl-4 pt-2">
              <div id="assignment_candidates">
                <h3 class="mb-2 text-center">Candidates</h3>

                    <?php
                    $role = "Member"; //$_SESSION['role']
                    $list = $bids_ctrl->get_candidates_list( $assignments_first_id, $_SESSION["id"], $role);
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
    <script src="../assets/script/yourassignments.js"></script>
    <?php if(empty($_SESSION['id'])){ ?>
    <script src="../assets/script/modals.js"></script>
    <?php } ?>
  </body>
</html>
