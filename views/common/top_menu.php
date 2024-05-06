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
			<a href="../submitassignment" class="menu-link <?php echo ($current_page=="submitassignment" ? ' active ' : '' );?>" style="color: white;">Submit Assignment</a>
		</li>
		<li class="menu-item">
			<a href="../yourassignments" class="menu-link <?php echo ($current_page=="yourassignments" ? ' active ' : '' );?>" style="color: white;">Your Assignments</a>
		</li>
		<li class="menu-item" id="message_tag">
			<a href="../messages" class="menu-link <?php echo ($current_page=="messages" ? ' active ' : '' );?>" style="color: white;"><?php echo ($unread_message_count==0 ? ' Messages ' : 'Messages<span style="color:red">('.$unread_message_count.')</span>' );?></a>
		</li>
		<li class="menu-item">
			<a href="../settings" class="menu-link <?php echo ($current_page=="settings" ? ' active ' : '' );?>" style="color: white;">Settings</a>
		</li>

		<?php } ?>

	</ul>

	<script>
		setInterval(() => {
			confirm_new()
		}, 5000);
		function confirm_new() {
			let session_id = "<?= $_SESSION['id']?>";
			$.ajax({
				url: '../controllers/confirm_new.php',
				type: 'POST',
				data: {session_id: session_id},
				dataType: 'json',
				success: function(response){
					let message_tag_html = "";
					if(response.message > 0){
						message_tag_html = `
						<a href="../messages" class="menu-link <?php echo ($current_page=="messages" ? ' active ' : '' );?>" style="color: white;">Messages<span style="color:red">(${response.message})</span></a>
						`;
					} else {
						message_tag_html = `
						<a href="../messages" class="menu-link <?php echo ($current_page=="messages" ? ' active ' : '' );?>" style="color: white;">Messages</a>
						`
					}
					$("#message_tag").html(message_tag_html);

					console.log('response is ', response);
				},
				error: function(){
					alert('Error occurred');
				}
			});
		}
	</script>