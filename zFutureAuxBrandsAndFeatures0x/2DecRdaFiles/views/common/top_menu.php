<?php
$unread_message_count = 0;
if(!empty($_SESSION['id'])){
	include_once "../controllers/chat_controller.php";

	$chat_ctrl = new ChatController(true);
	$unread_message_count = $chat_ctrl->unread_message_count_handle( $_SESSION['id'], false );
}


?>	
	<ul class="menu" id="menu">
		<?php if(empty($_SESSION['id'])){ ?>

		<li><!-- signInFormModal-->
			<button
			id="signInModalBtn"
			type="button"
			data-toggle="modal"
			data-target="#signInFormModal"
			data-backdrop="static"
			data-keyboard="false"
			>
			Sign In
			</button>
		</li>

		<?php }else{ ?>

		<li class="menu-item">
			<a href="../askquestion" class="menu-link <?php echo ($current_page=="askquestion" ? ' active ' : '' );?>">Ask Question</a>
		</li>
		<li class="menu-item">
			<a href="../yourquestions" class="menu-link <?php echo ($current_page=="yourquestions" ? ' active ' : '' );?>">Your Questions</a>
		</li>
		<li class="menu-item">
			<a href="../messages" class="menu-link <?php echo ($current_page=="messages" ? ' active ' : '' );?>"><?php echo ($unread_message_count==0 ? ' Messages ' : 'Messages<span style="color:red">('.$unread_message_count.')</span>' );?></a>
		</li>
		<li class="menu-item">
			<a href="../settings" class="menu-link <?php echo ($current_page=="settings" ? ' active ' : '' );?>">Settings</a>
		</li>

		<?php } ?>

	</ul>