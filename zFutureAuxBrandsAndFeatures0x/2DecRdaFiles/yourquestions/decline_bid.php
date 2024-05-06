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
$bid_id 		= $_GET["bid_id"];
$owner_id 		= $_SESSION['id'];

$response = $bids_ctrl->decline_bid($question_id, $bid_id, $owner_id);
echo $response;