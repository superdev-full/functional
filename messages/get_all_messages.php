<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/chat_controller.php";

$chat_ctrl = new ChatController(true);

$user_id 	= $_SESSION['id'];
if(!empty($_GET['member_id'])){
	$member_id = $_GET['member_id'];
  }else{
	$member_id = -1;
  }

$chat_messages_view = $chat_ctrl->get_chats_list( $user_id, $member_id );
echo $chat_messages_view[0];
