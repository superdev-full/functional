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

echo $chats_view_list;

?>