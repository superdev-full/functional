<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/question_controller.php";
include_once "../controllers/bids_controller.php";

$question_ctrl = new QuestionController(false);
$bids_ctrl = new BidsController(false);

$question_id 	= $_GET["question_id"];
$role = "Member"; //$_SESSION['role']
$response = $bids_ctrl->get_candidates_list( $question_id, $_SESSION['id'] , $role);
echo "<h3 class='mb-2 text-center'>Candidates</h3>\n" . $response[1];