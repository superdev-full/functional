<?php
session_start();
if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/chat_controller.php";

$chat_ctrl = new ChatController(true);

echo $chat_ctrl->process_send_message();