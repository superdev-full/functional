<?php 
$unread_message_count = 0;
$session_id = $_POST['session_id'];
if($session_id > 0){
	include_once "../controllers/chat_controller.php";

	$chat_ctrl = new ChatController(true);
	$unread_message_count = $chat_ctrl->unread_message_count_handle( $session_id, false );
    $response = array('status' => 'success', 'message' => $unread_message_count);
    echo json_encode($response);

}
else {
    $response = array('status' => 'failed', 'message' => "error");
    echo json_encode($response);
}

