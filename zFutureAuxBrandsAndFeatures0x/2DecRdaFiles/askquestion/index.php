<?php
include '../main.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RubberDuckyAnswers</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../assets/css/all.css"/>
    <link rel="stylesheet" href="../assets/css/all2.css" />
    <link rel="stylesheet" href="../assets/css/askquestion.css"/>
  </head>
  <!--Body-->
  <body class="askquestion-page">
    <!-- Start of Header -->
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo rdaEnvironment ?> class="brand">
              <img class="img-fluid" width="240px" src="../assets/images/logo.png" alt=""/>
            </a>
          </div>
          <div class="burger" id="burger">
            <span class="burger-open">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16">
                <g fill="#252a32" fill-rule="evenodd">
                  <path d="M0 0h24v2H0zM0 7h24v2H0zM0 14h24v2H0z"/>
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
        $current_page = "askquestion";
        include_once "../views/common/top_menu.php";
        ?>            
        </div>
      </nav>
    </header>
    <!-- End of Header -->
    <div class="main-container">
      <div class="ask-form-box">
        <h2 id="heading">Ask Question</h2>
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
              <input type="text" name="qtitle" id="qtitle" placeholder="Question Title"  autocomplete=”off”/>
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
          <input type="hidden" id="qtopics" name="qtopics" value="">
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
            <input type="hidden" id="qemergency" name="qemergency" value="">
            <div class="form-card position-relative">
              <div class="selectBox">
                <div class="selectBox__value">Select Question Emergency</div>
                <div class="dropdown-menu">
                  <a href="#" class="dropdown-item active">🤔 Just a question on my mind</a>
                  <a href="#" class="dropdown-item">😉 Need a response to continue</a>
                  <a href="#" class="dropdown-item">😤 Need a response right now</a>
                  <a href="#" class="dropdown-item">😡 Need a response ASAP</a>
                  <a href="#" class="dropdown-item">☠️ Life or death question</a>
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
                id="askQueSubmit"
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
      <p class="mb-0">@2022 RubberDuckyAnswers</p>
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
      const Q_TITLE_LIMIT = <?php echo Q_TITLE_LIMIT;?>;
      const Q_DESCRIPTION_LIMIT = <?php echo Q_DESCRIPTION_LIMIT;?>;
      $(document).ready(function () {
        $("#askQueSubmit").click(function () {
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

          $("#qtopics").val(topics_tags);

          // Check if at least one topic has been set
          if( topics_tags.length<1  ){
            alert('Please select at least one topic.');
            return false;
          }     

          // Check if emergency has been selected
          if( $('#qemergency').val().trim() == ""  ){
            alert('Please select question emergency.');
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
                if( $('#qemergency').val().trim() == ""  ){
                  $("#signInFormModal").modal('hide');
            			window.location.href = "<?php echo rdaEnvironment ?>" + "askquestion";
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
                if( $('#qemergency').val().trim() == ""  ){
                  $("#signUpFormModal").modal('hide');
            			window.location.href = "<?php echo rdaEnvironment ?>" + "askquestion";
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
    <script src="../assets/script/askquestion.js"></script>
    <!--End of Body-->
  </body>
</html>
