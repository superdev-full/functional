<?php
include_once "../config.php";

include_once "../controllers/upload_controller.php";
include_once "../models/maver_db.php";

class AssignmentController{

	var $debug = false;
	var $model = null;

	function __construct($debug = false){
		$this->debug = $debug;
		$this->model = new MaverDB($debug);
	}

	/**
	 * A method to create the list of assignments
	 * based on user_id
	 * 
	 * @return $view , HTML
	 */			
	function get_assignments_list( $user_id ){

		$sql = "SELECT * FROM assignments WHERE `user_id` = ".$user_id." AND status=1 ORDER BY `id` DESC";

		$params = array(
			$user_id
		);

		$result = $this->model->db_query_select( $sql  );

		$template1 = file_get_contents("../views/assignment1.html");

		$view = "";
		$first_assignment_id = -1;

		while($assignment = $result->fetch_assoc()) {
			if($first_assignment_id == -1){
				$first_assignment_id = $assignment["id"];
			}
			$view_tmp = str_replace("[A_ID]", $assignment["id"], $template1);
			$view_tmp = str_replace("[A_TITLE]", $assignment["title"], $view_tmp);
			$emergency = trim( str_replace("????", "", $assignment["emergency"]) );
			if( $emergency == "Just a assignment on my mind"){
				$emergency = "🤔 " . $emergency ;
			}else if( $emergency == "Need a response to continue"){
				$emergency = "😉 " . $emergency ;
			}else if( $emergency == "Need a response right now"){
				$emergency = "😤 " . $emergency ;
			}else if( $emergency == "Need a response ASAP"){
				$emergency = "😡 " . $emergency ;
			}else if( $emergency == "Life or death assignment"){
				$emergency = "☠️ " . $emergency ;
			}
		
			$view_tmp = str_replace("[A_EMERGENCY]",$emergency , $view_tmp);
			$description_short = $assignment["description"];
			if(strlen($description_short)>101){
				$description_short = substr($description_short,0,100);
			}
			$view_tmp = str_replace("[A_DESCRIPTION_SHORT]", $description_short, $view_tmp);
			$view_tmp = str_replace("[RELEVANT_IMAGE]", $this->get_relevant_image($assignment["topic"]), $view_tmp);

			

			$view .= $view_tmp;
		}

		return [$first_assignment_id , $view ] ;
	}

	/**
	 * A method to create the list of assignments
	 * based on user_id
	 * 
	 * @return $view , HTML
	 */			
	function get_relevant_image( $topics_list ){
		include "../yourassignments/relevant_images.php";
		$image = $relevant_images["default"];
		
		$topics = explode(",",$topics_list);

		foreach($topics as $topic){
			$key = strtolower($topic);
			
			if(  array_key_exists($key, $relevant_images) ){
				$image = $relevant_images[$key ];
				break;
			}			
		}

		return $image;
	}	

	/**
	 * A method to create the details of a assignment
	 * based on assignment_id
	 * @param $assignment_id, int
	 * 
	 * @return $view , HTML
	 */			
	function get_assignment_detail( $assignment_id = -1 ){
		$view = "";
		if($assignment_id == -1 || $assignment_id == "undefined"){
			$template_emty = file_get_contents("../views/assignment_detail_empty.html");
			$view = $template_emty;
		}else{

			$sql = "SELECT * FROM assignments WHERE `id` = ".$assignment_id;

			$result = $this->model->db_query_select( $sql  );
			
			$template1 = file_get_contents("../views/assignment_detail1.html");
			
			$assignment = $result->fetch_assoc();
			$view_tmp = str_replace("[A_TITLE]",  $assignment["title"] , $template1);

			$topics = $assignment["topic"];
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
			$view_tmp = str_replace("[A_TOPICS]", $topics_view, $view_tmp);

			$view_tmp = str_replace("[A_EMERGENCY]", $assignment["emergency"], $view_tmp);
			$view_tmp = str_replace("[A_DESCRIPTION_SHORT]", $this->pretty_assignment( $assignment["description"]  ), $view_tmp);
			// $view_tmp = str_replace("[A_DESCRIPTION_SHORT]", $assignment["description"], $view_tmp);

			$attachment = $assignment["attachment"];
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
			$view_tmp = str_replace("[A_ATTACHMENT]", $attachment, $view_tmp);
			
			$view = $view_tmp;

		}

		return $view;
	}	

	/**
	 * A method to create the list of candidates of a assignment
	 * based on assignment_id
	 * @param $assignment_id, int
	 * 
	 * @return $view , HTML
	 */			
	function pretty_assignment( $content ){
		
		$pretty_content = $content;
		// preg_match_all('/<code>(.*)<\/code>/si',$content,$matches);
		$pretty_content = preg_replace('/&lt;code&gt;(.*)&lt;\/code&gt;/si', "<p><span style='background-color:#efefef;width:500px;white-space: pre-wrap;'>$1</span><p>", $pretty_content,-1);

		$pretty_content = str_replace("\n" , "<br>" , $pretty_content);

		return $pretty_content;
	}	

	/**
	 * A method to create the list of candidates of a assignment
	 * based on assignment_id
	 * @param $assignment_id, int
	 * 
	 * @return $view , HTML
	 */			
	function get_assignment_candidates_list( $assignment_id = -1 ){
		$view = "";
		if($assignment_id == -1){
			$template_emty = file_get_contents("../views/candidates_empty.html");
			$view = $template_emty;
		}else{
			$template_emty = file_get_contents("../views/candidates_empty.html");
			$view = $template_emty;
			// $sql = "SELECT * FROM assignments WHERE `id` = ".$assignment_id;

			// $result = $this->model->db_query_select( $sql  );

			
			// $template1 = file_get_contents("../views/assignment_detail1.html");

			
			// $assignment = $result->fetch_assoc();
			// $view_tmp = str_replace("[A_TITLE]", $assignment["title"], $template1);
			// $view_tmp = str_replace("[A_EMERGENCY]", $assignment["emergency"], $view_tmp);
			// $view_tmp = str_replace("[A_DESCRIPTION_SHORT]", $assignment["description"], $view_tmp);
			// $view = $view_tmp;

		}

		return $view;
	}	

	/**
	 * A method to  handle new assignments
	 * Gets the post of the form
	 * 
	 * @return void
	 */		
	function process_submit(){

		// user id
		$user_id = $_SESSION['id'];

		// Grab form inputs
		$assignment_title 	= htmlspecialchars( trim($_POST["atitle"]) );
		$assignment_body 		= htmlspecialchars( trim($_POST["description"]) );
		$assignment_topic 	= trim($_POST["atopics"]);
		$assignment_emergency = trim($_POST["aemergency"]);

		$path = "";
		if( !empty($_FILES['file-input']['name']) ){
			// print_r($_FILES);
		    //RICH FIX.
		    // Upload the file
		    $upload_ctrl = new UploadController();
		    $path = $upload_ctrl->create_secure_path();
		
		    // Generate a unique name of the attachment
		    $newfilename = $upload_ctrl->create_secure_filname();
		    //END OF RICH FIX.


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
			$assignment_title,
			$assignment_body,
			$assignment_topic,
			$assignment_emergency,
			$path . $newfilename,
			$created_at,
			1

		);		

		$sql = "INSERT INTO assignments (`user_id`,`title`, `description`, `topic`, `emergency`, `attachment`, `created_at`,`status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$this->db_query_insert( $sql , $params );
		
		
		// var_dump($assignment_title);
		// var_dump($assignment_body);
		// var_dump($assignment_topic);
		// print "</pre>";

		header('Location: ' . "../yourassignments");
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
		$stmt->bind_param( 'issssssi', $params[0],$params[1],$params[2],$params[3],$params[4],$params[5], $params[6],$params[7] );
		$stmt->execute();
		$stmt->close();		
	}
}