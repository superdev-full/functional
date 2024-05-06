<?php
session_start();

if(empty($_SESSION['id'])){
	exit();
}
include_once "../controllers/question_controller.php";

$question_id = $_GET["question_id"];

$question_ctrl = new QuestionController(false);
$question_detail = $question_ctrl->get_question_detail( $question_id );
echo $question_detail;