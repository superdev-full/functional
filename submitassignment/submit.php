<?php
session_start();
if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/assignment_controller.php";

$assignment_ctrl = new AssignmentController(true);

$assignment_ctrl->process_submit();