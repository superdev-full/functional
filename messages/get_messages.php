<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/chat_controller.php";

$chat_ctrl = new ChatController(true);

$user_id 	= $_SESSION['id'];
$chat_id 	= $_GET["chat_id"];

$unread 	= $_GET["unread"];


$chat_messages_view = $chat_ctrl->get_chat_messages( $user_id, $chat_id, $unread );
echo $chat_messages_view;
