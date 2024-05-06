<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/assignment_controller.php";

$assignment_id = $_GET["assignment_id"];

$assignment_ctrl = new AssignmentController(false);
$assignment_detail = $assignment_ctrl->get_assignment_detail( $assignment_id );
echo $assignment_detail;