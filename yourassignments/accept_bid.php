<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/assignment_controller.php";
include_once "../controllers/bids_controller.php";

$assignment_ctrl = new AssignmentController(false);
$bids_ctrl = new BidsController(false);

$assignment_id 	= $_GET["assignment_id"];
$bid_id 		= $_GET["bid_id"];
$owner_id 		= $_SESSION['id'];

$response = $bids_ctrl->accept_bid($assignment_id, $bid_id, $owner_id);
echo $response;