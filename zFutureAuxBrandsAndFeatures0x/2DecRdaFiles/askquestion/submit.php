<?php
session_start();
if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/question_controller.php";

$question_ctrl = new QuestionController(true);

$question_ctrl->process_submit();