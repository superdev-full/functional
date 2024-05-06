<?php
include_once "../config.php";

include_once "../controllers/upload_controller.php";
include_once "../models/maver_db.php";

class ChatController{

	var $debug = false;
	var $model = null;

	function __construct($debug = false){
		$this->debug = $debug;
		$this->model = new MaverDB($debug);
	}

	/**
	 * A method to create the list of chats
	 * based on user_id
	 * 
	 * @return $view , HTML
	 */			
	function get_chats_list( $user_id ,$member_id = -1){

		// Find the ID of the requested chat
		$sql = "SELECT * FROM chats WHERE (`user1_id` = ".$user_id." AND `user2_id` = ".$member_id.") OR (`user2_id` = ".$user_id." AND `user1_id` = ".$member_id.")";
		$result = $this->model->db_query_select_row( $sql  );
		if($result){
			$selected_chat_id = $result["id"];
		}else{
			if($member_id != -1){
				// You need to create a new channel
				$date = date("Y-m-d h:s:i");
				$sql = "INSERT INTO chats(`user1_id`,`user2_id`,`created_at`,`updated_at`,`status`) VALUES(".$user_id .",".$member_id.",'".$date."','".$date."',1);";
				$result = $this->model->db_query_update( $sql  );

				$sql = "SELECT * FROM chats WHERE (`user1_id` = ".$user_id." AND `user2_id` = ".$member_id.") OR (`user2_id` = ".$user_id." AND `user1_id` = ".$member_id.")";
				$result = $this->model->db_query_select_row( $sql  );
				$selected_chat_id = $result["id"];				
			}else{
				$selected_chat_id = -1;
			}
			
		}
		$selected_chat_view = "";

		$sql = "SELECT * FROM chats WHERE (`user1_id` = ".$user_id." OR `user2_id` = ".$user_id.") ORDER BY `updated_at` DESC";

		$params = array(
			$user_id
		);

		$result = $this->model->db_query_select( $sql  );

		$template1 = file_get_contents("../views/chat_list_item1.html");

		$view = "";
		$first_chat_id = -1;

		while($chat = $result->fetch_assoc()) {

			if($selected_chat_id != -1){
				$first_chat_id = $selected_chat_id;
			}else{
				if($first_chat_id == -1){
					$first_chat_id = $chat["id"];
				}
			}

			$count = 0;
			$sql1 = "SELECT COUNT(*) as total FROM messages WHERE chat_id=" . $chat["id"];
			$sql1 .= " AND user_id!=" . $user_id;				// Unread
			$result1 = $this->model->db_query_select( $sql1  );
			$result1temp = $result1->fetch_assoc();
			$count = $result1temp['total'];
			$count_diff = 0;
			// if($is_save == true){
			// 	$sqlupdate = "UPDATE accounts SET seen_message_count='". $count ."' WHERE id=" . $user_id;
			// 	$resultupdate = $this->model->db_query_update( $sqlupdate  );		
			// }else{
				$sql1 = "SELECT * FROM chats WHERE id=" . $chat["id"];
				$result1 = $this->model->db_query_select( $sql1  );
				$result1temp = $result1->fetch_assoc();
				
				$count_diff = $count - $result1temp["user1_seen_message_count"];
				if($result1temp["user2_id"] == $user_id)
					$count_diff = $count - $result1temp["user2_seen_message_count"];
			// }

			if( $chat["user1_id"] == $user_id){
				$other_user_id = $chat["user2_id"];
				$user_is_host = true;
			}else{
				$other_user_id = $chat["user1_id"];
				$user_is_host = false;
			}

			$sql2 = "SELECT `username`,`avatar` FROM accounts WHERE id=" . $other_user_id;
			$result2 = $this->model->db_query_select_row( $sql2  );
			$other_username = $result2["username"];
			$other_avatar = $result2["avatar"];


			$avatar = "<img class='mr-2' src='" . AVATARS_PATH_URL .$other_avatar."' alt='user avatar' style='width:30px;height:30px;' />";
			
			$seen_mark_color = $count_diff > 0? 'red' : 'white';
			$seen_mark = "<span class='unread-mark' style='background-color:".$seen_mark_color."; border-radius:50%; width:15px; height:15px;'></span>";
			$view_tmp = str_replace("[CHAT_ID]", $chat["id"], $template1);
			$view_tmp = str_replace("[MEMBER_ID]", $other_user_id, $view_tmp);
			$view_tmp = str_replace("[CHAT_SEEN_MARK]", $seen_mark, $view_tmp);
			$view_tmp = str_replace("[CHAT_AVATAR]", $avatar, $view_tmp);



		
			$view_tmp = str_replace("[CHAT_USERNAME]",$other_username , $view_tmp);

			$chat_updated = $chat["updated_at"];	
			$tmp1 = explode(" " , $chat_updated );
			$tmp2 = explode("-" , $tmp1[0] );
			// $chat_updated =   $tmp2[1] . "/" . $tmp2[2] . "/" . $tmp2[0] . " " . $tmp1[1];
			$chat_updated =   $tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2) ;

			$view_tmp = str_replace("[CHAT_UPDATED]", $chat_updated, $view_tmp);

			if($selected_chat_id == $chat["id"] ){
				$selected_chat_view = $view_tmp;
			}else{
				$view .= $view_tmp;
			}
		}

		$view = $selected_chat_view . $view;

		return [$first_chat_id , $view ] ;
	}
	
	/**
	 * A method to create the list of chats
	 * based on user_id
	 * 
	 * @return $view , HTML
	 */			
	function unread_message_count_handle( $user_id, $is_save ){

		// Find the ID of the requested chat
		$sql = "SELECT * FROM chats WHERE (`user1_id` = ".$user_id." OR `user2_id` = ".$user_id.")";
		$result = $this->model->db_query_select( $sql  );
		$count = 0;
		if($result){
			while($chat = $result->fetch_assoc()) {
				$sql1 = "SELECT COUNT(*) as total FROM messages WHERE chat_id=" . $chat["id"];
				$sql1 .= " AND user_id!=$user_id ";				// Unread
				$result1 = $this->model->db_query_select( $sql1  );
				$result1temp = $result1->fetch_assoc();
				$count += $result1temp['total'];
			}
		}
		
		if($is_save == true){
			$sqlupdate = "UPDATE accounts SET seen_message_count='". $count ."' WHERE id=" . $user_id;
			$resultupdate = $this->model->db_query_update( $sqlupdate  );		
		}else{
			$sql1 = "SELECT * FROM accounts WHERE id=" . $user_id;
			$result1 = $this->model->db_query_select( $sql1  );
			$result1temp = $result1->fetch_assoc();
			return $count - $result1temp["seen_message_count"];
		}

		return $count ;
	}

	/**
	 * A method to create the messages of a chat
	 * based on chat_id
	 * @param $assignment_id, int
	 * 
	 * @return $view , HTML
	 */			
	function get_chat_messages( $user_id, $chat_id = -1 , $unread = 0){

		// Find the ID of the requested chat
		$count = 0;
		$sql1 = "SELECT COUNT(*) as total FROM messages WHERE chat_id=" . $chat_id;
		$sql1 .= " AND user_id!=" . $user_id;				// Unread
		$result1 = $this->model->db_query_select( $sql1  );
		$result1temp = $result1->fetch_assoc();
		$count = $result1temp['total'];
		// if($is_save == true){
			$sql1 = "SELECT * FROM chats WHERE id=" . $chat_id;
			$result1 = $this->model->db_query_select( $sql1  );
			$result1temp = $result1->fetch_assoc();
			
			$sqlupdate = "UPDATE chats SET user1_seen_message_count='". $count ."' WHERE id=" . $chat_id;
			if($result1temp["user2_id"] == $user_id)
				$sqlupdate = "UPDATE chats SET user2_seen_message_count='". $count ."' WHERE id=" . $chat_id;
			$resultupdate = $this->model->db_query_update( $sqlupdate  );		
		// }else{
			// $sql1 = "SELECT * FROM chats WHERE id=" . $chat["id"];
			// $result1 = $this->model->db_query_select( $sql1  );
			// $result1temp = $result1->fetch_assoc();
			
			// $count_diff = $count - $result1temp["user1_seen_message_count"];
			// if($result1temp["user2_id"] = $user_id)
			// 	$count_diff = $count - $result1temp["user2_seen_message_count"];
		// }


		$template_emty = file_get_contents("../views/chat_messages_empty.html");
		$template_msg = file_get_contents("../views/chat_message1.html");
		$template_date = file_get_contents("../views/chat_message_date.html");

		$view = "";
		if($chat_id == -1){			
			$view = $template_emty;
		}else{

			$sql = "SELECT * FROM messages WHERE chat_id=" . $chat_id ;
			if($unread == 1){
				$sql .= " AND status=0 ";				// Unread
				$sql .= " AND (user_id!= " . $user_id . " OR attachment!='')";   // MEssages from the other member or messages with attachment
			}	
			$sql .= " ORDER BY CREATED_AT ASC";
			$result = $this->model->db_query_select( $sql  );

			$today = date("Y-m-d");

			$active_date = "";

			$update_status_ids = "";
			$user_message_count = 0;
			if( $result && mysqli_num_rows($result) > 0 ){
				while( $message = $result->fetch_assoc() ){
					$user_message_count ++;
					// Our message
					if( $message["user_id"] == $user_id ){
						$message_class = "me";
					}else{
					// The other member message
						$message_class = "user";
					}

					$message_content = str_replace( "\n","<br>", $message["content"]);

					$created_at = $message["created_at"];

					$tmp1 = explode(" " , $created_at );
					$tmp2 = explode("-" , $tmp1[0] );

					$msg_date = $tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2) ;

					// The msg has been posted today
					if( $tmp1[0] == $today){
						// show only the time
						$created_at_date =   "" ;					
						$created_at_time =   $tmp1[1];	
					}else{
						$created_at_date =   "";//$tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2) ;					
						$created_at_time =   $tmp1[1];	
					}

					if($active_date==""){
						$active_date= $msg_date;
						$view_tmp = str_replace("[MSG_DATE]", $active_date, $template_date);
						$view .= $view_tmp;
					}else{
						if($active_date!=$msg_date){
							$active_date= $msg_date;
							$view_tmp = str_replace("[MSG_DATE]", $active_date, $template_date);
							$view .= $view_tmp;
						}
					}

					

					$view_tmp = str_replace("[MSG_DATE]", $created_at_date, $template_msg);
					$view_tmp = str_replace("[MSG_TIME]", $created_at_time, $view_tmp );
					$view_tmp = str_replace("[MSG_CLASS]", $message_class, $view_tmp );
					$view_tmp = str_replace("[MSG_CONTENT]", $message_content, $view_tmp);	
					$view .= $view_tmp;		
					
					if($update_status_ids==""){
						$update_status_ids = $message["id"] ;
					}else{
						$update_status_ids .= "," . $message["id"] ;
					}
					
				}
				$updated_at = date('Y-m-d\TH:i:s');
				$sql3 = "UPDATE messages SET status=1,readed_at='". $updated_at ."' WHERE id IN (" . $update_status_ids . ")";
				$result3 = $this->model->db_query_update( $sql3  );				
			}else{
				if($unread == 1){
					$view = "";
				}else{
					$view = $template_emty;
				}
				
			}

		}

		return $view;
	}		

	/**
	 * A method to create the header of the messages of a chat
	 * based on chat_id
	 * @param $assignment_id, int
	 * 
	 * @return $view , HTML
	 */			
	function get_chat_messages_header( $user_id, $chat_id = -1 ){
		$view = "";
		$template1 = file_get_contents("../views/chat_messages_member.html");
		if($chat_id == -1){
			$member_avatar = "default_avatar_s.jpg";
			$member_username = "N/A";
		}else{

			$sql = "SELECT * FROM chats WHERE id=" . $chat_id;
			$result = $this->model->db_query_select_row( $sql  );

			if( $result["user1_id"] == $user_id){
				$other_user_id = $result["user2_id"];
				$user_is_host = true;
			}else{
				$other_user_id = $result["user1_id"];
				$user_is_host = false;
			}

			$sql2 = "SELECT `username`,`avatar` FROM accounts WHERE id=" . $other_user_id;
			$result2 = $this->model->db_query_select_row( $sql2  );
			$member_username = $result2["username"];
			$member_avatar = $result2["avatar"];

		}

		$view_tmp = str_replace("[AVATARS_PATH_URL]", AVATARS_PATH_URL, $template1);
		$view_tmp = str_replace("[MEMBER_AVATAR]", $member_avatar, $view_tmp);
		$view_tmp = str_replace("[MEMBER_USERNAME]", $member_username, $view_tmp);

		$view = $view_tmp;

		return $view;
	}		


	/**
	 * A method to  handle new messages
	 * Gets the post of the form
	 * 
	 * @return void
	 */		
	function process_send_message(){

		// user id
		$user_id = $_SESSION['id'];

		// Grab form inputs
		$chat_id 	= trim($_POST["chat_id"]);
		$member_id 	= trim($_POST["member_id"]);
		$msg 		= trim($_POST["msg"]);

		// Validate input
		if( !is_numeric( $chat_id ) || !is_numeric( $member_id ) ){
			return "[ERROR]";
		}		
		//-----------


		// Check first if the chat exists and the user has access to it.
		$sql = "SELECT * FROM chats WHERE id=" . $chat_id . " AND (user1_id=".$user_id." OR user2_id=".$user_id.")";
		$result = $this->model->db_query_select_row( $sql  );

		if( !$result){
			return "[ERROR]";
		}	
		//-------------	
		

		if( !empty($_FILES['file-input']['name']) ){
			// print_r($_FILES);

			// Generate a unique name of the attachment
			$newfilename = time();

			// get extension
			$tmp = explode(".",$_FILES['file-input']['name']);
			$newfilename .= "." . $tmp[ count($tmp)-1 ];

			$uploadfile = UPLOAD_PATH . basename($newfilename);

			if (move_uploaded_file($_FILES['file-input']['tmp_name'], $uploadfile)) {
			} else {}
		}else{
			$newfilename = "";
		}

		$created_at = date('Y-m-d\TH:i:s');
		$updated_at = "0000-00-00 00:00:00";
		$readed_at = "0000-00-00 00:00:00";

		$params = array(
			$user_id,
			$chat_id,
			$msg,
			$newfilename,
			$created_at,
			$updated_at,
			$readed_at,
			0
		);		

		$sql = "INSERT INTO `messages` (`user_id`,`chat_id`, `content`, `attachment`, `created_at`, `updated_at`, `readed_at`,`status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$this->db_query_insert( $sql , $params );
		// Update Chat meta
		$updated_at = $created_at;
		$sql3 = "UPDATE chats SET updated_at='". $updated_at ."' WHERE id=" . $chat_id;
		$result3 = $this->model->db_query_update( $sql3  );		

		return "[OK]";
	}

	/**
	 * A method to send a file to the chat
	 * 
	 * @return string
	 */	
	function process_send_file(){
		// user id
		$user_id = $_SESSION['id'];

		// Grab form inputs
		$chat_id 	= trim($_POST["chat_id"]);
		$member_id 	= trim($_POST["member_id"]);
		$msg 		= "";

		// Validate input
		if( !is_numeric( $chat_id ) || !is_numeric( $member_id ) ){
			return "[ERROR]";
		}		
		//-----------


		// Check first if the chat exists and the user has access to it.
		$sql = "SELECT * FROM chats WHERE id=" . $chat_id . " AND (user1_id=".$user_id." OR user2_id=".$user_id.")";
		$result = $this->model->db_query_select_row( $sql  );

		if( !$result){
			return "[ERROR]";
		}	
		//-------------	
		
		$path = "";
		if( !empty($_FILES['file-input']['name']) ){
			// print_r($_FILES);

			$upload_ctrl = new UploadController();
			$path = $upload_ctrl->create_secure_path();

			// Generate a unique name of the attachment
			$newfilename = $upload_ctrl->create_secure_filname();

			// get extension
			$tmp = explode(".",$_FILES['file-input']['name']);
			$ext = $tmp[ count($tmp)-1 ];
			$newfilename .= "." . $ext;

			$uploadfile 	= UPLOAD_PATH . $path . basename($newfilename);
			$attachment_url = UPLOAD_PATH_URL. $path . basename($newfilename);

			if (move_uploaded_file($_FILES['file-input']['tmp_name'], $uploadfile)) {
				if($ext =="zip"){
					$msg .= "<a href='".$attachment_url."' title='Download attachment' target='_blank'>" . $newfilename ."</a>";
				}else{
					$msg .= "<a href='".$attachment_url."' title='View image' target='_blank'><img src='".$attachment_url."' style='height:100px;'></a>";
				}
			} else {}
		}else{
			$newfilename = "";
		}

		$created_at = date('Y-m-d\TH:i:s');
		$updated_at = "0000-00-00 00:00:00";
		$readed_at = "0000-00-00 00:00:00";

		$params = array(
			$user_id,
			$chat_id,
			$msg,
			$path . $newfilename,
			$created_at,
			$updated_at,
			$readed_at,
			0
		);		

		$sql = "INSERT INTO `messages` (`user_id`,`chat_id`, `content`, `attachment`, `created_at`, `updated_at`, `readed_at`,`status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$this->db_query_insert( $sql , $params );
		// Update Chat meta
		$updated_at = $created_at;
		$sql3 = "UPDATE chats SET updated_at='". $updated_at ."' WHERE id=" . $chat_id;
		$result3 = $this->model->db_query_update( $sql3  );		

		return "[OK]";
	}


	/**
	 * A method to insert new assignments
	 * @param $sql, SQL query
	 * @param $params, An array with the data
	 */
	function db_query_insert( $sql , $params ){
		// mysqli_report(MYSQLI_REPORT_ERROR);
		// Connect to the MySQL database using MySQLi
		$con = mysqli_connect(db_host, db_user, db_pass, db_name);
		// If there is an error with the MySQL connection, stop the script and output the error
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		// Update the charset
		mysqli_set_charset($con, db_charset);	

		// Prepare query; prevents SQL injection
		$stmt = $con->prepare($sql);

		// Bind our variables to the query
		$stmt->bind_param( 'iisssssi', $params[0],$params[1],$params[2],$params[3],$params[4],$params[5], $params[6],$params[7] );
		$stmt->execute();
		$stmt->close();		
	}
}	