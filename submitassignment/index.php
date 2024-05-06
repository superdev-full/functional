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
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../assets/css/all.css"/>
    <link rel="stylesheet" href="../assets/css/all2.css" />
    <link rel="stylesheet" href="../assets/css/submitassignment.css"/>
  </head>
  <!--Body-->
  <body class="submitassignment-page">
    <!-- Start of Header -->
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo maverEnvironment ?> class="brand">
              <img class="img-fluid" width="100px" "height="20px" src="../assets/images/logo.png" alt=""/>
            </a>
          </div>
          <div class="burger" id="burger">
            <span class="burger-open">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16">
                <g fill="#ffffff" fill-rule="evenodd">
                  <path d="M0 0h24v2H0zM0 7h24v2H0zM0 14h24v2H0z"/>
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
        $current_page = "submitassignment";
        include_once "../views/common/top_menu.php";
        ?>
        </div>
      </nav>
    </header>
    <!-- End of Header -->
    <div class="main-container">
      <div class="ask-form-box">
        <h2 id="heading">Submit Assignment</h2>
        <form id="msform"  action="submit.php" method="post" enctype="multipart/form-data">
          <!-- progressbar -->
          <ul id="progressbar">
            <li class="d-none active"></li>
            <li class="" id="first"></li>
            <li id="second"></li>
            <li id="third"></li>
          </ul>
          <!-- fieldsets -->
          <fieldset class="p-3 card">
            <div class="form-card position-relative d-flex flex-column">
              <input type="text" name="atitle" id="atitle" placeholder="Assignment Title"  autocomplete=”off”/>
              <textarea
                type="text"
                name="description"
                id="description"
                placeholder="Description"
              ></textarea>
            </div>
            <div class="text-edit-box flex-column flex-sm-row">
              <div class="mb-4 mb-sm-0">
                <div class="image-upload">
                  <label for="file-input">
                    <img src="../assets/images/attach.png" alt="Attach a file" />
                  </label>

                  <input id="file-input" name="file-input" type="file" onchange="preview_file(this);" accept=".png,.jpg,.gif,.jpeg,.tiff,.zip" style=" display: none;"/>
                  <span id="filename_preview"></span>
                </div>

              </div>
              <button type="button" name="next" class="next action-button">
                Next
              </button>
            </div>
          </fieldset>
          <fieldset class="p-3 card">
          <input type="hidden" id="atopics" name="atopics" value="">
            <div class="form-card position-relative">
              <h2 class="text-body">Add topics 🚀</h2>
              <div class="topic-box my-4 px-3 py-3">
                <input
                  type="text"
                  name="topic"
                  id="topic"
                  class="border-0 w-auto p-0 mb-0"
                />
              </div>
            </div>
            <div class="d-flex w-100 justify-content-between">
              <button
                type="button"
                name="previous"
                class="previous action-button-previous"
              >
                Back
              </button>
              <button type="button" name="next" class="next action-button">
                Next
              </button>
            </div>
          </fieldset>
          <fieldset class="p-3 card">
            <input type="hidden" id="aemergency" name="aemergency" value="">
            <div class="form-card position-relative">
              <div class="selectBox">
                <div class="selectBox__value">Select Assignment Emergency</div>
                <div class="dropdown-menu">
                  <a href="#" class="dropdown-item active">🤔 Just a assignment on my mind</a>
                  <a href="#" class="dropdown-item">😉 Need a response to continue</a>
                  <a href="#" class="dropdown-item">😤 Need a response right now</a>
                  <a href="#" class="dropdown-item">😡 Need a response ASAP</a>
                  <a href="#" class="dropdown-item">☠️ Life or death assignment</a>
                </div>
              </div>
            </div>
            <div class="d-flex w-100 justify-content-between">
              <button
                type="button"
                name="previous"
                class="previous action-button-previous"
              >
                Back
              </button>
              <a
                href="#"
                type="button"
                id="subAsSubmit"
                class="action-button"
              >
                Next
              </a>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
<?php
if(empty($_SESSION['id'])){
include_once "../views/modals/signin_modal.php";
include_once "../views/modals/signup_modal.php";
}
?>

    <!-- Start of footer -->
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2023 Maver</p>
      <ul class="flex-column flex-sm-row">
        <li><a href="../terms">Terms of Service</a></li>
        <li><a href="../privacy">Privacy Policy</a></li>
        <li><a href="../contact">Contact Us</a></li>
        <li><a href="../investors">Investors</a></li>
      </ul>
    </footer>
    <!-- End of footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script/script.js"></script>
    <?php if(empty($_SESSION['id'])){ ?>
    <script src="../assets/script/modals.js"></script>
    <?php } ?>
    <script>
      const A_TITLE_LIMIT = <?php echo A_TITLE_LIMIT;?>;
      const A_DESCRIPTION_LIMIT = <?php echo A_DESCRIPTION_LIMIT;?>;
      $(document).ready(function () {
        $("#subAsSubmit").click(function () {
          // get topics
          let topics = $( ".topic-box" ).children( ".topic-item" ).children();

          let topics_tags = "";
          topics.each(function () {
            if( this.className!="close-btn" ){

              if(topics_tags ==""){
                topics_tags = this.innerHTML ;
              }else{
                topics_tags += "," + this.innerHTML ;
              }

            }
          });

          $("#atopics").val(topics_tags);

          // Check if at least one topic has been set
          if( topics_tags.length<1  ){
            alert('Please select at least one topic.');
            return false;
          }

          // Check if emergency has been selected
          if( $('#aemergency').val().trim() == ""  ){
            alert('Please select assignment emergency.');
            return false;
          }
          <?php if(empty($_SESSION['id'])){ ?>
            // sign in modal if not signed in
            $("#signInFormModal").modal('show');
          <?php } else { ?>
            // submit if all ok
            $("#msform").submit();
          <?php } ?>

        });
      })
      <?php if(empty($_SESSION['id'])){ ?>
          let customLoginForm = document.querySelectorAll(".modal fade pr-0, .modal-dialog modal-dialog-centered, .modal-content form")[0];
          customLoginForm.onsubmit = event => {
            event.preventDefault();
            fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm) }).then(response => response.text()).then(result => {
              if (result.toLowerCase().includes("success")) {
                if( $('#aemergency').val().trim() == ""  ){
                  $("#signInFormModal").modal('hide');
            			window.location.href = "<?php echo maverEnvironment ?>" + "submitassignment";
                }else{
                  $("#msform").submit();
                }
              } else {
                document.querySelector(".msg1").innerHTML = result;
              }
            });
          };

          let customRegistrationForm = document.querySelectorAll(".modal fade pr-0, .modal-dialog modal-dialog-centered, .modal-content form")[1];
          customRegistrationForm.onsubmit = event => {
            event.preventDefault();
            fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm) }).then(response => response.text()).then(result => {
              if (result.toLowerCase().includes("autologin")) {
                if( $('#aemergency').val().trim() == ""  ){
                  $("#signUpFormModal").modal('hide');
            			window.location.href = "<?php echo maverEnvironment ?>" + "submitassignment";
                }else{
                  $("#msform").submit();
                }
              } else {
                document.querySelector(".msg2").innerHTML = result;
              }
            });
          };

      <?php } ?>
    </script>
    <script src="../assets/script/submitassignment.js"></script>
    <!--End of Body-->
  </body>
</html>
