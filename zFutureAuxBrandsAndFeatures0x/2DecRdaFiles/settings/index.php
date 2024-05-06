<?php
include '../main.php';
// Check logged-in
check_loggedin($con);
// output message (errors, etc)
$msg = '';
// Retrieve additional account info from the database because we don't have them stored in sessions
$stmt = $con->prepare('SELECT `avatar`,`password`, `email`, `activation_code`, `role`, `registered` FROM `accounts` WHERE id = ?');
// In this case, we can use the account ID to retrieve the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($avatar,$password, $email, $activation_code, $role, $registered_date);
$stmt->fetch();
$stmt->close();

// Handle change avatar
if( !empty($_FILES['file-input']['name']) ){
	include_once '../controllers/upload_controller.php';
	include_once '../models/rda_db.php';

	// Upload the file
	$upload_ctrl = new UploadController();
	$path = $upload_ctrl->create_secure_path();

	// Generate a unique name of the attachment
	$newfilename = $upload_ctrl->create_secure_filname();

	// get extension
	$tmp = explode(".",$_FILES['file-input']['name']);
	$newfilename .= "." . $tmp[ count($tmp)-1 ];

	$uploadfile = AVATARS_UPLOAD_PATH . $path . basename($newfilename);

	// echo '<pre>';
	if (move_uploaded_file($_FILES['file-input']['tmp_name'], $uploadfile)) {
		// Update the DB
		$model = new RdaDB();

		$sql = "UPDATE `accounts` set `avatar`='".$path . basename($newfilename)."'  WHERE `id`=".$_SESSION['id'] . ";";
		$result  = $model->db_query_update( $sql );

		if($result){
			// $status = "OK";
		}else{
			$msg = 'Something went wrong, the new avatar could not be uploaded.';
		}		
	} else {
		$msg = 'Something went wrong, the new avatar could not be uploaded.';
	}
	
	
}

// Handle edit profile post data
if (isset($_POST['username'], $_POST['password'], $_POST['cpassword'], $_POST['email'])) {
	// Make sure the submitted registration values are not empty.
	if (empty($_POST['username']) || empty($_POST['email'])) {
		$msg = 'The input fields must not be empty!';
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$msg = 'Please provide a valid email address!';
	} else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
	    $msg = 'Username must contain only letters and numbers!';
	} else if (!empty($_POST['password']) && (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5)) {
		$msg = 'Password must be between 5 and 20 characters long!';
	} else if ($_POST['cpassword'] != $_POST['password']) {
		$msg = 'Passwords do not match!';
	}
	// No validation errors... Process update
	if (empty($msg)) {
		// Check if new username or email already exists in the database
		$stmt = $con->prepare('SELECT * FROM accounts WHERE (username = ? OR email = ?) AND username != ? AND email != ?');
		$stmt->bind_param('ssss', $_POST['username'], $_POST['email'], $_SESSION['name'], $email);
		$stmt->execute();
		$stmt->store_result();
		// Account exists? Output error...
		if ($stmt->num_rows > 0) {
			$msg = 'Account already exists with that username and/or email!';
		} else {
			// No errors occured, update the account...
			$stmt->close();
			// If email has changed, generate a new activation code
			$uniqid = account_activation && $email != $_POST['email'] ? uniqid() : $activation_code;
			$stmt = $con->prepare('UPDATE accounts SET username = ?, password = ?, email = ?, activation_code = ? WHERE id = ?');
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $password;
			$stmt->bind_param('ssssi', $_POST['username'], $password, $_POST['email'], $uniqid, $_SESSION['id']);
			$stmt->execute();
			$stmt->close();
			// Update the session variables
			$_SESSION['name'] = $_POST['username'];
			if (account_activation && $email != $_POST['email']) {
				// Account activation required, send the user the activation email with the "send_activation_email" function from the "main.php" file
				send_activation_email($_POST['email'], $uniqid);
				// Logout the user
				unset($_SESSION['loggedin']);
				$msg = 'You have changed your email address! You need to re-activate your account!';
			} else {
				// Profile updated successfully, redirect the user back to the profile page
				header('Location: index.php');
				exit;
			}
		}
	}
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RubberDuckyAnswers</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/all.css"/>
	<link rel="stylesheet" href="../assets/css/all2.css" />
    <link rel="stylesheet" href="../assets/css/settings.css"/>
  </head>
  <body class="settings-page">
    <header>
      <nav class="navbar">
        <div class="navbrand d-flex">
          <div class="mr-3">
            <a href=<?php echo rdaEnvironment ?> class="brand">
              <img class="img-fluid" width="240px" src="../assets/images/logo.png" alt="" />
            </a>
          </div>
          <div class="burger" id="burger">
            <span class="burger-open">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16">
                <g fill="#252a32" fill-rule="evenodd">
                  <path d="M0 0h24v2H0zM0 7h24v2H0zM0 14h24v2H0z" />
                </g>
              </svg>
            </span>
            <span class="burger-close">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path
                  fill="#252a32"
                  fill-rule="evenodd"
                  d="M17.778.808l1.414 1.414L11.414 10l7.778 7.778-1.414\
                   1.414L10 11.414l-7.778 7.778-1.414-1.414L8.586 10 .808\
                    2.222 2.222.808 10 8.586 17.778.808z"
                />
              </svg>
            </span>
          </div>
        </div>
        <div>
        <?php 
        $current_page = "settings";
        include_once "../views/common/top_menu.php";
        ?>           			
        </div>
      </nav>
    </header>
    <div class="main-container">
        <div class="card py-4 px-3 mt-5">
		<?php if (!isset($_GET['action'])): ?>
		<div class="content profile">

			<h2>Profile Page</h2>

			<div class="block">

				<p>Your account details are below.</p>
				<div class="profile-detail">
					<img src="<?php echo AVATARS_PATH_URL . $avatar;?>" alt="avatar" style="width:30px;height:30px;">
					Your Avatar 
					<?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Tutor'): ?>
					 (<a class="profile-btn" href="index.php?action=change_avatar">Change</a>)
					<?php endif; ?>
					<br><br>
				</div>

				<div class="profile-detail">
					<strong>Username</strong>
					<?=$_SESSION['name']?>
				</div>

				<div class="profile-detail">
					<strong>Email</strong>
					<?=$email?>
				</div>

				<div class="profile-detail">
					<strong>Role</strong>
					<?=$role?>
				</div>

				<div class="profile-detail">
					<strong>Registered</strong>
					<?=$registered_date?>
				</div>
				<br>
				<a class="profile-btn" href="index.php?action=edit">Edit Details</a>

			</div>

		</div>
		<?php elseif ($_GET['action'] == 'edit'): ?>
		<div class="content profile">

			<h2>Edit Profile Page</h2>
			
			<div class="block">

				<form action="index.php?action=edit" method="post">

					<label for="username">Username</label>
					<input type="text" value="<?=$_SESSION['name']?>" name="username" id="username" placeholder="Username">

					<label for="password">New Password</label>
					<input type="password" name="password" id="password" placeholder="New Password">

					<label for="cpassword">Confirm Password</label>
					<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">

					<label for="email">Email</label>
					<input type="email" value="<?=$email?>" name="email" id="email" placeholder="Email">

					<div>
						<input class="profile-btn" type="submit" value="Save">
					</div>

					<?php if(!empty($msg)){ ?>
					<br>
					<div style="color:#773333;"><p><?=$msg?></p></div>
					<?php } ?>

				</form>

			</div>

		</div>
		<?php elseif ($_GET['action'] == 'change_avatar' && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Tutor') ): ?>
		<div class="content profile">

			<h2>Change your avatar</h2>
			
			<div class="block">

				<form action="index.php?action=change_avatar" method="post" enctype="multipart/form-data">
					<div>
					<label for="username">Current avatar</label>
					<img src="<?php echo AVATARS_PATH_URL . $avatar;?>" alt="avatar" style="width:30px;height:30px;">
					<br>
					</div>

					<div>
					<label for="password">New Avatar</label>
					<input type="file" name="file-input" id="file-input" accept=".png,.jpg,.gif,.jpeg">
					</div>
					<br>

					<div>
						<input class="profile-btn" type="submit" value="Upload & Save">
					</div>

					<?php if(!empty($msg)){ ?>
					<br>
					<div style="color:#773333;"><p><?=$msg?></p></div>
					<?php } ?>

				</form>

			</div>

		</div>		
		<?php endif; ?>
		
		<?php if ($_SESSION['role'] == 'Admin'): ?>
		<a href="../admin/index.php" target="_blank">Admin Panel</a>
		<?php endif; ?>
		<?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Tutor'): ?>
		<a href="../tutor/index.php" target="_blank">Tutor Panel</a>
		<?php endif; ?>
		<a href="../logout">Logout <?=$_SESSION['name']?></a>
		
		</div>
	</div>
<?php 
if(empty($_SESSION['id'])){
include_once "../views/modals/signin_modal.php";
include_once "../views/modals/signup_modal.php";
}
?>
    <footer class="px-3 flex-column flex-lg-row">
      <p class="mb-0">@2022 RubberDuckyAnswers</p>
      <ul class="flex-column flex-sm-row">
        <li><a href="../terms">Terms of Service</a></li>
        <li><a href="../privacy">Privacy Policy</a></li>
        <li><a href="../contact">Contact Us</a></li>
        <li><a href="../investors">Investors</a></li>
      </ul>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="../assets/script/script.js"></script>
	<?php if(empty($_SESSION['id'])){ ?>
	<script src="../assets/script/modals.js"></script>
	<?php } ?>
  </body>
</html>
