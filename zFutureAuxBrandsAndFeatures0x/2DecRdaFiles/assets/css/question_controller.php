<?php
include_once "../config.php";

include_once "../controllers/upload_controller.php";

class QuestionController{

	var $debug = false;

	function __constructor($debug = false){
		$this->debug = $debug;
	}

	/**
	 * A method to create the list of questions
	 * based on user_id
	 * 
	 * @return $view , HTML
	 */			
	function get_questions_list( $user_id ){

		$sql = "SELECT * FROM questions WHERE `user_id` = ".$user_id." AND status=1 ORDER BY `id` DESC";

		$params = array(
			$user_id
		);

		$result = $this->db_query_select( $sql  );

		$template1 = file_get_contents("../views/question1.html");

		$view = "";
		$first_question_id = -1;

		while($question = $result->fetch_assoc()) {
			if($first_question_id == -1){
				$first_question_id = $question["id"];
			}
			$view_tmp = str_replace("[Q_ID]", $question["id"], $template1);
			$view_tmp = str_replace("[Q_TITLE]", $question["title"], $view_tmp);
			$emergency = trim( str_replace("????", "", $question["emergency"]) );
			if( $emergency == "Just a question on my mind"){
				$emergency = "🤔 " . $emergency ;
			}else if( $emergency == "Need a response to continue"){
				$emergency = "😉 " . $emergency ;
			}else if( $emergency == "Need a response right now"){
				$emergency = "😤 " . $emergency ;
			}else if( $emergency == "Need a response ASAP"){
				$emergency = "😡 " . $emergency ;
			}else if( $emergency == "Life or death question"){
				$emergency = "☠️ " . $emergency ;
			}
		
			$view_tmp = str_replace("[Q_EMERGENCY]",$emergency , $view_tmp);
			$description_short = $question["description"];
			if(strlen($description_short)>101){
				$description_short = substr($description_short,0,100);
			}
			$view_tmp = str_replace("[Q_DESCRIPTION_SHORT]", $description_short, $view_tmp);
			$view_tmp = str_replace("[RELEVANT_IMAGE]", $this->get_relevant_image($question["topic"]), $view_tmp);

			

			$view .= $view_tmp;
		}

		return [$first_question_id , $view ] ;
	}

	/**
	 * A method to create the list of questions
	 * based on user_id
	 * 
	 * @return $view , HTML
	 */			
	function get_relevant_image( $topics_list ){
		include "../yourquestions/relevant_images.php";
		$image = $relevant_images["default"];
		

		$topics = explode(",",$topics_list);

		foreach($topics as $topic){
			$key = strtolower($topic);
			$found_topic = $relevant_images[$key ];
			
			if(!empty($found_topic) && $found_topic!=null){
				$image =  $found_topic;
				break;
			}			
		}


		return $image;
	}	

	/**
	 * A method to create the details of a question
	 * based on question_id
	 * @param $question_id, int
	 * 
	 * @return $view , HTML
	 */			
	function get_question_detail( $question_id = -1 ){
		$view = "";
		if($question_id == -1){
			$template_emty = file_get_contents("../views/question_detail_empty.html");
			$view = $template_emty;
		}else{

			$sql = "SELECT * FROM questions WHERE `id` = ".$question_id;

			$result = $this->db_query_select( $sql  );

			
			$template1 = file_get_contents("../views/question_detail1.html");

			
			$question = $result->fetch_assoc();
			$view_tmp = str_replace("[Q_TITLE]",  $question["title"] , $template1);

			$topics = $question["topic"];
			$topics_view = "";
			if($topics!=""){
				$template_topic = file_get_contents("../views/topic.html");

				$items = explode(",", $topics);
				foreach($items as $topic_title){
					$item_view = str_replace("[TOPIC_TITLE]",$topic_title,$template_topic);
					$topics_view .= $item_view;
				}

			}else{
				$topics_view = "";
			}
			$view_tmp = str_replace("[Q_TOPICS]", $topics_view, $view_tmp);



			$view_tmp = str_replace("[Q_EMERGENCY]", $question["emergency"], $view_tmp);
			$view_tmp = str_replace("[Q_DESCRIPTION_SHORT]", $this->pretty_question( $question["description"]  ), $view_tmp);
			// $view_tmp = str_replace("[Q_DESCRIPTION_SHORT]", $question["description"], $view_tmp);

			$attachment = $question["attachment"];
			if( $attachment != ""){
				$tmp = explode( "." , $attachment );
				if( strtolower($tmp[1]) == "jpg" || strtolower($tmp[1]) == "jpeg" || strtolower($tmp[1]) == "png" || strtolower($tmp[1]) == "gif" || strtolower($tmp[1]) == "tiff"){
					$attachment ="<a href='/uploads/".$attachment."' target='_blank' title='click to view image'><img class='w-100'	src='/uploads/".$attachment."' alt=''/></a>";
				}else if( strtolower($tmp[1]) == "zip"){
					$attachment ="<a href='/uploads/".$attachment."' target='_blank'>Download</a>";
				}else{

				}

			}else{
				$attachment = "";
			}
			$view_tmp = str_replace("[Q_ATTACHMENT]", $attachment, $view_tmp);
			
			$view = $view_tmp;

		}

		return $view;
	}	

	/**
	 * A method to create the list of candidates of a question
	 * based on question_id
	 * @param $question_id, int
	 * 
	 * @return $view , HTML
	 */			
	function pretty_question( $content ){
		
		$pretty_content = $content;
		// preg_match_all('/<code>(.*)<\/code>/si',$content,$matches);
		$pretty_content =  preg_replace('/<code>(.*)<\/code>/si', "<pre style='background-color:#efefef;padding:5px;'>$1</pre>", $pretty_content,-1);

		$pretty_content = str_replace("\n" , "<br>" , $pretty_content);

		return $pretty_content;
	}	

	/**
	 * A method to create the list of candidates of a question
	 * based on question_id
	 * @param $question_id, int
	 * 
	 * @return $view , HTML
	 */			
	function get_question_candidates_list( $question_id = -1 ){
		$view = "";
		if($question_id == -1){
			$template_emty = file_get_contents("../views/candidates_empty.html");
			$view = $template_emty;
		}else{
			$template_emty = file_get_contents("../views/candidates_empty.html");
			$view = $template_emty;
			// $sql = "SELECT * FROM questions WHERE `id` = ".$question_id;

			// $result = $this->db_query_select( $sql  );

			
			// $template1 = file_get_contents("../views/question_detail1.html");

			
			// $question = $result->fetch_assoc();
			// $view_tmp = str_replace("[Q_TITLE]", $question["title"], $template1);
			// $view_tmp = str_replace("[Q_EMERGENCY]", $question["emergency"], $view_tmp);
			// $view_tmp = str_replace("[Q_DESCRIPTION_SHORT]", $question["description"], $view_tmp);
			// $view = $view_tmp;

		}

		return $view;
	}	

	/**
	 * A method to  handle new questions
	 * Gets the post of the form
	 * 
	 * @return void
	 */		
	function process_submit(){

		// user id
		$user_id = $_SESSION['id'];

		// Grab form inputs
		$question_title 	= htmlspecialchars( trim($_POST["qtitle"]) );
		$question_body 		= htmlspecialchars( trim($_POST["description"]) );
		$question_topic 	= trim($_POST["qtopics"]);
		$question_emergency = trim($_POST["qemergency"]);

		$path = "";
		if( !empty($_FILES['file-input']['name']) ){
			// print_r($_FILES);

			$upload_ctrl = new UploadController();
			$path = $upload_ctrl->create_secure_path();

			// Generate a unique name of the attachment
			$newfilename = $upload_ctrl->create_secure_filname();

			// get extension
			$tmp = explode(".",$_FILES['file-input']['name']);
			$newfilename .= "." . $tmp[ count($tmp)-1 ];

			$uploadfile = UPLOAD_PATH . $path . basename($newfilename);

			// echo '<pre>';
			if (move_uploaded_file($_FILES['file-input']['tmp_name'], $uploadfile)) {
				// echo "uploaded.\n";
			} else {
				// echo "error uploading!\n";
			}
		}else{
			$newfilename = "";
		}

		$created_at = date('Y-m-d\TH:i:s');

		$params = array(
			$user_id,
			$question_title,
			$question_body,
			$question_topic,
			$question_emergency,
			$path . $newfilename,
			$created_at,
			1

		);		

		$sql = "INSERT INTO questions (`user_id`,`title`, `description`, `topic`, `emergency`, `attachment`, `created_at`,`status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$this->db_query_insert( $sql , $params );
		
		
		// var_dump($question_title);
		// var_dump($question_body);
		// var_dump($question_topic);
		// print "</pre>";

		header('Location: ' . "../yourquestions");
	}

	/**
	 * A method to get the questions of a user
	 * @param $user_id, int
	 * 
	 * @return $items, An array with the data
	 */	
	function db_query_select( $sql  ){
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
		$result = $con->query($sql);
	
		return $result;
	}

	/**
	 * A method to insert new questions
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
		$stmt->bind_param( 'issssssi', $params[0],$params[1],$params[2],$params[3],$params[4],$params[5], $params[6],$params[7] );
		$stmt->execute();
		$stmt->close();		
	}
}