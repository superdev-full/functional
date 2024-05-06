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
$role = "Member"; //$_SESSION['role']
$response = $bids_ctrl->get_candidates_list( $assignment_id, $_SESSION['id'] , $role);
echo "<h3 class='mb-2 text-center'>Candidates</h3>\n" . $response[1];