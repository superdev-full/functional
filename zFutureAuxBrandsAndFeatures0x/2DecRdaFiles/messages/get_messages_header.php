<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/chat_controller.php";

$chat_ctrl = new ChatController(true);

$user_id = $_SESSION['id'];
$chat_id = $_GET["chat_id"];


$chat_messages_header_view = $chat_ctrl->get_chat_messages_header( $user_id, $chat_id );
echo $chat_messages_header_view;
