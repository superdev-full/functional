<?php
include 'main.php';
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['cpassword'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('<center>Please complete the registration form!</center>');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('<center>Please complete the registration form!</center>');
}
// Check to see if the email is valid.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('<center>Please provide a valid email address!</center>');
}
// Username must contain only characters and numbers.
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    exit('<center>Username must contain only letters and numbers!</center>');
}
// Password must be between 5 and 20 characters long.
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('<center>Password must be between 5 and 20 characters long!</center>');
}
// Check if both the password and confirm password fields match
if ($_POST['cpassword'] != $_POST['password']) {
	exit('<center>Passwords do not match!</center>');
}
// We need to check if the account with that username exists.
$stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ? OR email = ?');
// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
$stmt->bind_param('ss', $_POST['username'], $_POST['email']);
$stmt->execute();
$stmt->store_result();
// Store the result so we can check if the account exists in the database.
if ($stmt->num_rows > 0) {
	// Username already exists
	echo '<center>Username and/or email exists!</center>';
} else {
	$stmt->close();
	// Username doesnt exists, insert new account
	// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	// Generate unique activation code
	$uniqid = account_activation ? uniqid() : 'activated';
	// Default role
	$role = 'Member';
	// Current date
	$date = date('Y-m-d\TH:i:s');
	// Prepare query; prevents SQL injection
	$stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code, role, registered, last_seen) VALUES (?, ?, ?, ?, ?, ?, ?)');
	// Bind our variables to the query
	$stmt->bind_param('sssssss', $_POST['username'], $password, $_POST['email'], $uniqid, $role, $date, $date);
	$stmt->execute();
	$stmt->close();

	//establish new chat thread between support and newly created user
	// $stmt = $con->prepare('SELECT id FROM accounts WHERE username = ? OR email = ?');
	// $stmt->bind_param('ss', $_POST['username'], $_POST['email']);
	// $stmt->execute();
	// $stmt->store_result();
	// $stmt->bind_result($user_id);
	// $stmt->fetch();

	$user_id = $con->insert_id;
	$stmt = $con->prepare('INSERT INTO chats(user1_id, user2_id, created_at, updated_at, status, user1_seen_message_count, user2_seen_message_count) VALUES(1, ?, ?, ?, 1, 0, 0)');
	$stmt->bind_param('iss', $user_id, $date, $date);
	$stmt->execute();
	$stmt->close();

	//add auto support's welcome message to this thread
	// $stmt = $con->prepare('SELECT id FROM chats WHERE (user1_id = 1 AND user2_id = ?)');
	// $stmt->bind_param('i', $user_id);
	// $stmt->execute();
	// $stmt->store_result();
	// $stmt->bind_result($chat_id);
	// $stmt->fetch();
	// $stmt->close();
	$chat_id = $con->insert_id;
	$stmt = $con->prepare('INSERT INTO messages (user_id, chat_id, content, attachment, created_at, updated_at, readed_at, status) VALUES (1, ?, ?, ?, ?, ?, ?, 1)');
	$updated_at = "0000-00-00 00:00:00";
	$readed_at = "0000-00-00 00:00:00";
	$content = "welcome";
	$attachment = "welcome";
	// Bind our variables to the query
	$stmt->bind_param('isssss', $chat_id, $content, $attachment, $date, $updated_at, $readed_at);
	$stmt->execute();
	$stmt->close();

	// If account activation is required, send activation email
	if (account_activation) {
		// Account activation required, send the user the activation email with the "send_activation_email" function from the "main.php" file
		send_activation_email($_POST['email'], $uniqid);
		echo '<center>Please check your email to activate your account!</center>';
	} else {
		// Automatically authenticate the user if the option is enabled
		if (auto_login_after_register) {
			// Regenerate session ID
			session_regenerate_id();
			// Declare session variables
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $user_id;
			$_SESSION['role'] = $role;
			echo 'autologin';
		} else {
			echo '<center>You have successfully registered! You can now login!</center>';
		}
	}
	// Send new account email
	send_new_account_email($_POST['email']);
}
?>
