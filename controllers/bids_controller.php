<?php
include_once "../config.php";
include_once "../models/maver_db.php";
include_once "../controllers/upload_controller.php";

class BidsController{

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
	function get_candidates_list( $assignment_id, $user_id , $role = "Member"){

		$sql = "SELECT a.id,a.applied_at,a.selected_at,a.rejected_at,a.paid_at,a.answered_at,a.bid_amount,a.solution,a.attachment,b.id as user_id,b.username,b.avatar FROM bids as a INNER JOIN accounts as b ON b.id=a.candidate_id WHERE (a.assignment_id = ".$assignment_id." ) ORDER BY a.applied_at DESC";
        // var_dump($sql);
		$result = $this->model->db_query_select( $sql  );

		$template_tutor = file_get_contents("../views/candidates_list_item_tutor.html");
        $template_admin = file_get_contents("../views/candidates_list_item_admin.html");
        $template_member = file_get_contents("../views/candidates_list_item_member.html");
		$template_member_actions = file_get_contents("../views/candidates_list_item_member_actions.html");
		$template_emty = file_get_contents("../views/candidates_empty.html");
		

		$view = "";

		if($result && mysqli_num_rows($result)>0){
        
			while($candidate = $result->fetch_assoc()) {

				if($role == "Tutor"){
					$view_tmp = str_replace("[CANDIDATE_USERNAME]", $candidate["username"], $template_tutor);
				}else if($role == "Admin"){
					$view_tmp = str_replace("[CANDIDATE_USERNAME]", $candidate["username"], $template_admin);
				}else{
					// Change the template if answered
					if( $candidate["answered_at"]!=null){
						$template_member = file_get_contents("../views/candidates_list_item_member_solution.html");
					}
					$view_tmp = str_replace("[CANDIDATE_USERNAME]", $candidate["username"], $template_member);
				}


				$applied_at = $candidate["applied_at"];	
				$tmp1 = explode(" " , $applied_at );
				$tmp2 = explode("-" , $tmp1[0] );
				// $applied_at =   $tmp2[1] . "/" . $tmp2[2] . "/" . $tmp2[0] . " " . $tmp1[1];
				$applied_at =   $tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2) ;

				$view_tmp = str_replace("[APPLIED]", $applied_at, $view_tmp);

				$view_tmp = str_replace("[AVATARS_PATH_URL]", AVATARS_PATH_URL, $view_tmp);
				$view_tmp = str_replace("[CANDIDATE_AVATAR]", $candidate["avatar"], $view_tmp);
				$view_tmp = str_replace("[CANDIDATE_TITLE]", "-", $view_tmp);

				$bid_amount = number_format($candidate["bid_amount"],2,".","");

				/**
				 *  Possible actions / texts	| filled date fields
				 * 
				 * SELECTED - WAIT PAYMENT		: selected_at
				 * SELECTED - Wait Anwet- PAID	: selected_at , paid_at
				 * SELECTED - Answered - PAID	: selected_at , paid_at , answered_at
				 * REJECTED 					: rejected_at
				 * Reject - Accept 				: all date fields are null
				 */


				if($role == "Tutor" || $role == "Admin"){
					if($candidate["selected_at"]!=null){
						if( $candidate["paid_at"]!=null){
							if( $candidate["answered_at"]!=null){
								$view_tmp = str_replace("[BADGE]", "<span class='msg success'>SELECTED ANSWERED - PAID $".$bid_amount."</span>", $view_tmp);				
							}else{
								$view_tmp = str_replace("[BADGE]", "<span class='msg success'>SELECTED - WAITING FOR ANSWER - PAID $".$bid_amount."</span>", $view_tmp);
							}						
						}else{
							$view_tmp = str_replace("[BADGE]", "<span class='msg success'>SELECTED - WAITING FOR PAYMENT $".$bid_amount."</span>", $view_tmp);
						}
					}elseif($candidate["rejected_at"]!=null){
						$view_tmp = str_replace("[BADGE]", "<span class='msg error'>REJECTED</span>", $view_tmp);
					}else{
						$view_tmp = str_replace("[BADGE]", "", $view_tmp);
					}	
				// Role is member
				}else{
					if($candidate["selected_at"]!=null){
						if( $candidate["paid_at"]!=null){
							if( $candidate["answered_at"]!=null){
								// $view_tmp = str_replace("[ACTIONS]", "<span class='msg success'>SELECTED ANSWERED - PAID $".$bid_amount."</span>", $view_tmp);
								$solution = $candidate["solution"];
								$solution = str_replace("\n", "<br>", $solution);
								if($candidate["attachment"]!=""){
									$attachment_url = $candidate["attachment"];
									$tmp = explode(".", $attachment_url );
									$ext = $tmp[ count($tmp)-1 ];              
									if($ext =="zip"){
										$attachment_link = "<div><a href='".$attachment_url."' title='Download attachment' target='_blank'>Attachment</a></div>";
									}else{
										$attachment_link = "<div><a href='".$attachment_url."' title='View image' target='_blank'><img src='".$attachment_url."' style='height:100px;'></a></div>";
									}                                  
								}else{
									$attachment_link = "";
								}		
								$solution .= $attachment_link;		
								$view_tmp = str_replace("[SOLUTION]", $solution, $view_tmp);								
							}else{
								$view_tmp = str_replace("[ACTIONS]", "<span class='msg success'>SELECTED - WAITING FOR ANSWER - PAID $".$bid_amount."</span>", $view_tmp);
							}						
						}else{
							$view_tmp = str_replace("[ACTIONS]", "<div class='msg success'>SELECTED - WAITING FOR PAYMENT $".$bid_amount."  <span><a href='".PAYPAL_PAYMENT_PAGE_URL."?product_id=".$candidate["id"]."' target='_blank'>Pay!</a></span></div>", $view_tmp);
						}
					}elseif($candidate["rejected_at"]!=null){
						$view_tmp = str_replace("[ACTIONS]", "<div class='msg error'>REJECTED</div>", $view_tmp);
					}else{

						$view_tmp_actions = str_replace("[ASSIGNMENT_ID]", $assignment_id, $template_member_actions);
						$view_tmp_actions = str_replace("[BID_ID]", $candidate["id"], $view_tmp_actions);
						$view_tmp_actions = str_replace("[BID_AMOUNT]", $bid_amount, $view_tmp_actions);
						$view_tmp = str_replace("[ACTIONS]", $view_tmp_actions, $view_tmp);
					}
				}	

				if($user_id == $candidate["user_id"]){
					$view_tmp = str_replace("[CLASS_NAME]", "msg success", $view_tmp);
				}else{
					$view_tmp = str_replace("[CLASS_NAME]", "", $view_tmp);
				}
				

				$view .= $view_tmp ;
			}
		}else{
			$view = $template_emty;
		}


		return [1 , $view ] ;
	}	

	/**
	 * A method to check if a user can bid
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function get_selected_bid( $assignment_id ,$role = "Member" ){
		$winner = "N/A";
		$solution = "N/A";

		if( $role == "Tutor" || $role == "Admin" || $role == "Member"){
			// check if the user has alread bid
			$sql = "SELECT a.id,a.notes,a.solution,a.attachment,a.applied_at,a.selected_at,a.rejected_at,b.id as user_id,b.username,b.avatar FROM bids as a INNER JOIN accounts as b ON b.id=a.candidate_id  WHERE a.assignment_id=" . $assignment_id . " AND a.selected_at IS NOT NULL";
			$result = $this->model->db_query_select_row( $sql );
			if($result){
				// user alread bid
				$id 		= $result["id"];
				$winner 	= $result["username"];
				$notes 		= $result["notes"];
				$solution 	= $result["solution"];
				$attachment = $result["attachment"];
			}else{
				$id 		= -1;
				$winner 	= "N/A";
				$notes 		= "N/A";
				$solution 	= "N/A";
				$attachment = "N/A";
			}
			
		}

		return [ "id" =>  $id, "winner" =>  $winner, "notes" => $notes, "solution" => $solution, "attachment" => $attachment ];
	}	

	/**
	 * A method to get the bid's info
	 * based on bid id
	 * 
	 * @return $info , array
	 */			
	function get_bid( $id ){
		$status 	= -1;
		$assignment_id= -1;
		$message 	= "";
		$bid_amount = "";
		$selected 	= false;
		$rejected 	= false;
		$paid 		= false;
		$finalised	= false;


		// check if the  bid exists
		$sql = "SELECT * FROM `bids` WHERE id=" . $id;
		$result = $this->model->db_query_select_row( $sql  );
		if($result){
			// user already bid
			$assignment_id= $result["assignment_id"];
			$status =1;
			$message 	= "Bid found.";
			$bid_amount = $result["bid_amount"];
			if($result["selected_at"] != NULL){
				$selected = true;
			}
			if($result["rejected_at"] != NULL){
				$rejected = true;
			}
			if($result["paid_at"] != NULL){
				$paid = true;
			}		
			if($result["answered_at"] != NULL){
				$finalised = true;
			}						
					
		}else{
			$status = -1;
			$message = "Bid not found";
		}

		return [ "status" =>  $status, "message" => $message, "assignment_id" => $assignment_id, "bid_amount" => $bid_amount, "selected" => $selected, "rejected" => $rejected, "paid" => $paid, "finalised" => $finalised ];
	}

	/**
	 * A method to set the payment date to a bid
	 * 
	 * 
	 * @return void
	 */			
	function set_payment_date( $bid_id ){
		$paid_at = date('Y-m-d h:i:s');
		// check if the  transaction exists
		$sql = "UPDATE bids set paid_at='".$paid_at."' WHERE id = " . $bid_id;
		$result = $this->model->db_query_update( $sql  );
	}

	/**
	 * A method to get the payment's info
	 * based on trx id
	 * 
	 * @return $info , array
	 */			
	function get_payment( $txn_id ){
		$status 		= -1;
		$message 		= "";
		$payment_id 	= "";
		$payment_gross 	= "";
		$payment_status = "";

        $payment_id     = $payment_info['payment_id'];
        $payment_gross  = $payment_info['payment_gross'];
        $payment_status = $payment_info['payment_status'];

		// check if the  transaction exists
		$sql = "SELECT * FROM payments WHERE txn_id = '".$txn_id."'";
		$result = $this->model->db_query_select_row( $sql  );

		if($result){
			// transaction exists
			$status =1;
			$message 	= "transaction found.";
			$payment_id 	= $result["payment_id"];
			$payment_gross 	= $result["payment_gross"];
			$payment_status = $result["payment_status"];
		}else{
			$status = -1;
			$message = "transaction not found";
		}

		return [ "status" =>  $status, "message" => $message, "payment_id" => $payment_id, "payment_gross" => $payment_gross, "payment_status" => $payment_status ];
	}

	/**
	 * A method to create the payment's info
	 * based on trx data
	 * 
	 * @return $payment_id , int
	 */			
	function create_payment( $data ){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		// Connect to the MySQL database using MySQLi
		$con = mysqli_connect(db_host, db_user, db_pass, db_name);
		// If there is an error with the MySQL connection, stop the script and output the error
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		// Update the charset
		mysqli_set_charset($con, db_charset);	

		// Prepare query; prevents SQL injection
		$sql = "INSERT INTO payments(item_number,txn_id,payment_gross,currency_code,payment_status) VALUES(?,?,?,?,?)";
		$stmt = $con->prepare($sql);

		// var_dump($params);
		// var_dump($stmt);
		// exit();
		try{

		if($stmt){
		// Bind our variables to the query
		$stmt->bind_param( 'ssdss', $data["item_number"],$data["txn_id"],$data["payment_gross"],$data["currency_code"],$data["payment_status"]);
		$status = $stmt->execute();
		$stmt->close();		
		$payment_id = $con->insert_id;
		}else{
			$status = false;
			$payment_id = -1;
		}
		}catch( Exception $ex){
			var_dump($ex);
			$status = false;
			$payment_id = -1;
		}
        	
		return $payment_id;	
	}	

	/**
	 * A method to check if a user can bid
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function can_user_bid( $assignment_id, $user_id ,$role ){
		$status 	= -1;
		$message 	= "You cannot bid for this assignment";
		$bid_amount = "";
		$selected 	= false;
		$rejected 	= false;
		$paid 		= false;
		$finalised	= false;

		if( $role == "Tutor" ){
			// check if the user has already bid
			$sql = "SELECT * FROM `bids` WHERE assignment_id=" . $assignment_id . " AND candidate_id=" . $user_id;
			$result = $this->model->db_query_select_row( $sql  );
			if($result){
				// user already bid
				$status = 0;
				$message 	= "You have already placed your Bid for this assignment.";
				$bid_amount = $result["bid_amount"];
				if($result["selected_at"] != NULL){
					$selected = true;
				}
				if($result["rejected_at"] != NULL){
					$rejected = true;
				}
				if($result["paid_at"] != NULL){
					$paid = true;
				}		
				if($result["answered_at"] != NULL){
					$finalised = true;
				}						
						
			}else{
				$status = 1;
				$message = "You can bid";
			}
			
		}else{
			$message = "You cannot bid for this assignment. Wrong member role.";
		}

		return [ "status" =>  $status, "message" => $message, "bid_amount" => $bid_amount, "selected" => $selected, "rejected" => $rejected, "paid" => $paid, "finalised" => $finalised ];
	}

	/**
	 * A method to set a user's bid
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function decline_bid( $assignment_id, $bid_id , $owner_id ){
		$status = -1;
		$message = "An error occured. Your bid has not been updated.";

		$date = date("Y-m-d H-i-s");


		$sql = "UPDATE `bids` set  `rejected_at`='".$date."'  WHERE `assignment_id`=".$assignment_id." AND `id`=".$bid_id." AND `owner_id`=".$owner_id . ";";
		$result  = $this->model->db_query_update( $sql );

		if($result){
			$status = "OK";
		}else{
			$status = "ERROR";
			
		}

		return $status;		
	}	

	/**
	 * A method to set a user's bid
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function accept_bid( $assignment_id, $bid_id , $owner_id ){

		$sql = "SELECT a.id,a.applied_at,a.selected_at,a.rejected_at,a.paid_at,a.answered_at,a.bid_amount,a.solution,a.attachment,b.id as user_id,b.username,b.avatar FROM bids as a INNER JOIN accounts as b ON b.id=a.candidate_id WHERE (a.assignment_id = ".$assignment_id." ) ORDER BY a.applied_at DESC";
        // var_dump($sql);
		$result = $this->model->db_query_select( $sql  );
		if($result && mysqli_num_rows($result)>0){
			while($candidate = $result->fetch_assoc()) {
				$this->decline_bid($assignment_id, $candidate["id"], $owner_id);
			}
		}


		$status = -1;
		$message = "An error occured. Your bid has not been updated.";

		$date = date("Y-m-d H-i-s");


		$sql = "UPDATE `bids` set  `selected_at`='".$date."'  WHERE `assignment_id`=".$assignment_id." AND `id`=".$bid_id." AND `owner_id`=".$owner_id . ";";
		$result  = $this->model->db_query_update( $sql );

		if($result){
			$status = "OK";
		}else{
			$status = "ERROR";
			
		}

		return $status;		
	}		


	/**
	 * A method to set a user's bid
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function set_user_bid( $assignment_id, $owner_id, $bid_amount, $candidate_id ){
		$status = -1;
		$message = "An error occured. Your bid has not been placed.";

		$date = date("Y-m-d H-i-s");
		$null_date = NULL;

		$params = array(
			$assignment_id,
			$owner_id,
			$candidate_id,
			$bid_amount,
			" ",
			$date,
			$null_date,
			$null_date,
			$null_date,
			$null_date
		);	

		if($this->can_user_bid( $assignment_id, $candidate_id ,"Tutor" )[ "status" ] == 1){

			$sql = "INSERT INTO `bids` (`assignment_id`,`owner_id`, `candidate_id`, `bid_amount`, `notes`, `applied_at`, `retracked_at`, `selected_at` , `rejected_at` , `updated_at`) VALUES (?, ?, ?, ? ,?, ?, ?, ?, ?, ?);";
			$result  = $this->db_query_insert( $sql , $params );

			if($result){
				// user succesffuly bid
				$status = 1;
				$message = "You have successfully placed your bid for this assignment!";
			}else{
				$status = -1;
				
			}
		}else{
			$status = -1;
			$message = "You have already placed your bid for this assignment!";
		}
			


		return [ "status" =>  $status, "message" => $message];		
	}	

	/**
	 * A method to set a user's bid
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function retract_user_bid( $assignment_id, $owner_id, $candidate_id ){
		$status = -1;
		$message = "An error occured. Your bid has not been retracted.";

		$date = date("Y-m-d H-i-s");
		$null_date = "0000-00-00 00:00:00";


		$sql = "DELETE FROM `bids` WHERE `assignment_id` = ".$assignment_id." AND `owner_id` = ".$owner_id." AND  `candidate_id`=" . $candidate_id;
		$result  = $this->model->db_query_update( $sql );

		if($result){

			$status = 1;
			$message = "You have successfully retracted your bid for this assignment!";
		}else{
			$status = -1;
			
		}
			


		return [ "status" =>  $status, "message" => $message];		
	}	
	
	/**
	 * A method to update a tutor's solution
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function update_solution( $assignment_id,$bid_id , $owner_id, $solution ){
		$status = -1;
		$message = "An error occured. Your solution has not been updated.";

		$date = date("Y-m-d H-i-s");
		$null_date = "0000-00-00 00:00:00";

		$path = "";
		$attachment_msg = "";
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
					$attachment_msg = "<a href='".$attachment_url."' title='Download attachment' target='_blank'>" . $newfilename ."</a>";
				}else{
					$attachment_msg = "<a href='".$attachment_url."' title='View image' target='_blank'><img src='".$attachment_url."' style='height:100px;'></a>";
				}
			} else {}
		}else{
			$newfilename = "";
			$attachment_url = "";
		}


		$sql = "UPDATE `bids` set `solution`='". $solution ."',`attachment`='". $attachment_url ."',updated_at='".$date."' WHERE `id` = ".$bid_id." AND `assignment_id` = ".$assignment_id." AND `owner_id` = ".$owner_id;
		$result  = $this->model->db_query_update( $sql );

		if($result){

			$status = 1;
			$message = "You have successfully updated your solution for this assignment!";
		}else{
			$status = -1;
			
		}

		return [ "status" =>  $status, "message" => $message];		
	}
	
	/**
	 * A method to finalise a tutor's solution
	 * based on user_id
	 * 
	 * @return $status , boolean
	 */			
	function finalise_solution( $assignment_id ,$bid_id ,$owner_id, $solution ){
		$status = -1;
		$message = "An error occured. Your solution has not been finalised.";

		$date = date("Y-m-d H-i-s");
		$null_date = "0000-00-00 00:00:00";

		$path = "";
		$attachment_msg = "";
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
					$attachment_msg = "<a href='".$attachment_url."' title='Download attachment' target='_blank'>" . $newfilename ."</a>";
				}else{
					$attachment_msg = "<a href='".$attachment_url."' title='View image' target='_blank'><img src='".$attachment_url."' style='height:100px;'></a>";
				}
			} else {}
		}else{
			$newfilename = "";
		}		



		$sql = "UPDATE `bids` set `solution`='". $solution ."',`attachment`='". $attachment_url ."',updated_at='".$date."',answered_at='".$date."' WHERE `id` = ".$bid_id." AND `assignment_id` = ".$assignment_id." AND `owner_id` = ".$owner_id;
		$result  = $this->model->db_query_update( $sql );

		if($result){

			$status = 1;
			$message = "You have successfully finalised your solution for this assignment!";
		}else{
			$status = -1;
			
		}

		return [ "status" =>  $status, "message" => $message];		
	}	


	/**
	 * A method to insert new assignments
	 * @param $sql, SQL query
	 * @param $params, An array with the data
	 */
	function db_query_insert( $sql , $params ){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
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

		// var_dump($params);
		// var_dump($stmt);
		// exit();
		try{

		if($stmt){
		// Bind our variables to the query
		$stmt->bind_param( 'iiidssssss', $params[0],$params[1],$params[2],$params[3],$params[4],$params[5], $params[6],$params[7] , $params[8], $params[9]);
		$status = $stmt->execute();
		$stmt->close();		
		}else{
			$status = false;
		}
		}catch( Exception $ex){
			var_dump($ex);
			$status = false;
		}
		return $status ;
	}	
}
