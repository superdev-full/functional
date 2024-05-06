<?php
include '../main.php';
check_loggedin($con);

include_once "../controllers/chat_controller.php";

$chat_ctrl = new ChatController(true);
$user_id = $_SESSION['id'];
if(!empty($_GET['member_id'])){
  $member_id = $_GET['member_id'];
}else{
  $member_id = -1;
}
$chats_list_data = $chat_ctrl->get_chats_list( $user_id, $member_id );
$chats_first_id = $chats_list_data[0];
$chats_view_list = $chats_list_data[1];

$count = $chat_ctrl->unread_message_count_handle( $user_id, true );
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
    <link rel="stylesheet" href="../assets/css/message.css" />
  </head>
                <div class="thousand">
                </div>
  <body class="message-page">
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
                  d="M17.778.808l1.414 1.414L11.414 10l7.778 7.778-1.414 1.414L10\
                   11.414l-7.778 7.778-1.414-1.414L8.586 10 .808 2.222 2.222.808\
                   10 8.586 17.778.808z"
                />
              </svg>
            </span>
          </div>
        </div>
        <div>
        <?php 
        $current_page = "messages";
        include_once "../views/common/top_menu.php";
        ?>           
        </div>
      </nav>
    </header>
    <div class="main-container">
      <div class="card w-100 py-3 px-4">
        <div class="row h-100 position-relative">
          <div
            class="col-12 col-md-6 col-lg-5 col-xl-4 border-right px-0 h-100 user-container active"
          >
            <div id="chats_list">

            <?php
                echo $chats_view_list;
            ?>
            </div>
          </div>
          <div
            class="col-12 col-md-6 col-lg-7 col-xl-8 h-100 px-0 chatting-container"
          >
            <div class="chatting-box">
              <div class="chatting-box-header py-3 px-3 d-flex">
              <div class="my-auto mr-2 back-btn d-block d-md-none">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024">
                    <path fill="currentColor" d="M872 474H286.9l350.2-304c5.6-4.9 2.2-14-5.2-14h-88.5c-3.9\
                       0-7.6 1.4-10.5 3.9L155 487.8a31.96 31.96 0 0 0 0 48.3L535.1\
                        866c1.5 1.3 3.3 2 5.2 2h91.5c7.4 0 10.8-9.2 5.2-14L286.9\
                         550H872c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8z"></path>
                  </svg>
                </div>
                <div class="d-flex" id="chat_messages_header">
                    <?php
                    $chat_messages_header_view = $chat_ctrl->get_chat_messages_header( $user_id, $chats_first_id );
                    echo $chat_messages_header_view;
                    ?>	                  
                </div>
              </div>
              <div class="chatting-box-body p-3">
                <div id="chat_messages">
                    <?php
                    $chat_messages_view = $chat_ctrl->get_chat_messages( $user_id, $chats_first_id , 0 );
                    echo $chat_messages_view;
                    ?>	                  
                </div>
              </div>
              <div class="chatting-box-text py-2">
                <?php if( is_numeric($chats_first_id) && $chats_first_id>0 ){ ?>
                <form id="frmMsg" action="">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex w-100">
                      <div class="message-input-box">
                        <textarea id="msg_box" name="msg_box" class="message-box-input"></textarea>
                      </div>
                      <div class="my-auto px-2">
                        <div class="image-upload my-auto">
                          <label class="mb-0" for="file-input">
                          <img src="../assets/images/attach.png" alt="Attach a file" />
                          </label>
                          <input id="file-input" name="file-input" type="file" onchange="upload_file(this);" accept=".png,.jpg,.gif,.jpeg,.tiff,.zip" style=" display: none;"/>
                        </div>                      
                      </div>
                    </div>
                    
                    <div class="my-auto">
                      <button type="button" id="send_msg" name="send_msg" class="action-button send-button">
                        Send
                      </button>                      
                    </div>
                  </div>
                </form>
                <?php } ?>
              </div>
          </div>
        </div>
      </div>
    </div>
    </div>
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
    <script src="../assets/script/message.js"></script>
    <?php if(empty($_SESSION['id'])){ ?>
    <script src="../assets/script/modals.js"></script>
    <?php } ?>
  </body>
</html>
