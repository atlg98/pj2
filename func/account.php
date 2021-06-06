<?php
$errors = [];
if (isset($_POST['login'])) {
	checkLogin($_POST, $errors, $conn);
	
} elseif (isset($_POST['create'])) {
	checkCreate($_POST, $errors, $conn);
}

// Create profile section
if(isset($_POST['profile_update'])) {
	updateProfile(
		$conn,
		$_POST['phone'],
		$_POST['location'],
		$_SESSION['user_id'],
		$_POST['email'],
		$_POST['birth']
	);
	getProfile(getProfileRow($_SESSION['user_id'], $conn));
	header("Location: profile.php?update=success");
}

//check the login form for errors
function checkLogin($post, &$errors, $conn)
{
	$name = $post['username'];
	$password = $post['password'];
	if (checkForUser($name, $conn) != 1) {
		$errorMsg = "Username not found!";
		$errors['login_username'] = $errorMsg;
	} else {
		$user_row = getUserRow($name, $conn);
		if (!password_verify($password, $user_row['user_hash'])) {
			$errorMsg = "Incorred Password!";
			$errors['login_password'] = $errorMsg;
		}
	}
	if (empty($errors)) {
		getProfile(getProfileRowByUserID($user_row['id'], $conn));
		loginUser($user_row['user_name'], $user_row['ID'], $user_row['user_role'], $user_row['user_email']);
	}
}


function checkCreate($post, &$errors, $conn)
{
	$username = $post['username'];
	$email = $post['email'];
	$password1 = $post['password1'];
	$password2 = $post['password2'];

	if (!minmaxChars($username, 5, 20)) {
		$errorMsg = "Username must be between 5-20 characters long!";
		$errors['create_username'] = $errorMsg;
	} elseif (checkForUser($username, $conn) == 1) {
		$errorMsg = "Username already take!";
		$errors['create_username'] = $errorMsg;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errorMsg = "Invalid email!";
		$errors['create_email'] = $errorMsg;
	}

	if (!minmaxChars($password1, 5) || $password1 != $password2) {
		$errorMsg = "Password is too short or does not match!";
		$errors['create_password'] = $errorMsg;
	}

	if (empty($errors)) {
		$user_id = createUser($conn, $username, $email, $password1);
		if ($user_id != 0) {
			$profile_id = createProfile(
				$conn,
				"1231241423",
				"No where",
				$user_id,
				"second@email.com"
			);
			getProfile(getProfileRow($profile_id, $conn));
			loginUser($username, $user_id, 2, $email);
		}
	}
}

function getProfileRowByUserID($user_id, $conn){
	$sql = "SELECT * FROM profiles WHERE user_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$results = $stmt->get_result();
	return $results->fetch_assoc();
}

function checkForUser($username, $conn)
{
	$sql = "SELECT * FROM users WHERE user_name = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$results = $stmt->get_result();
	return $results->num_rows;
}

function getUserRow($username, $conn)
{
	$sql = "SELECT * FROM users WHERE user_name = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$results = $stmt->get_result();
	return $results->fetch_assoc();
}

function getProfileRow($id, $conn){
	$sql = "SELECT * FROM profiles WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$results = $stmt->get_result();
	return $results->fetch_assoc();
}

function createUser($conn, $user_name, $user_email, $user_password)
{
	$user_hash = password_hash($user_password, PASSWORD_DEFAULT);
	$sql = "INSERT INTO users (user_name, user_email, user_hash) VALUES (?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sss", $user_name, $user_email, $user_hash);
	$stmt->execute();
	if ($stmt->affected_rows == 1) {
		return $stmt->insert_id;
	} else {
		return 0;
	}
}

function createProfile($conn, $phone, $location, $user_id, $email)
{
	$sql = "INSERT INTO profiles (user_id, location, email, phone) VALUES (?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("isss" ,$user_id, $location, $email, $phone);
	$stmt->execute();
	if ($stmt->affected_rows == 1) {
		return $stmt->insert_id;
	} else {
		return 0;
	}
}

function updateProfile($conn, $phone, $location, $user_id, $email, $birth){
	$sql = "UPDATE profiles SET 'location' = ?, birth = ?, email = ?, phone = ? WHERE user_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($location, $birth, $email, $phone, $user_id);
	$stmt->execute();
	return $stmt->affected_rows == 1;
}

function minmaxChars($string, $min, $max = 1000)
{
	if (strlen($string) < $min || strlen($string) > $max) {
		return false;
	} else {
		return true;
	}
}

function loginUser($user_name, $user_id, $user_role, $user_email)
{
	$_SESSION['loggedin'] = true;
	$_SESSION['user_name'] = $user_name;
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_email'] = $user_email;
	$_SESSION['user_role'] = $user_role;
	header("Location: index.php?login=success");
}

function getProfile($profile){
	$_SESSION['second_email'] = $profile['email'];
	$_SESSION['phone'] =  $profile['phone'];
	$_SESSION['location'] = $profile['location'];
	$_SESSION['bio'] = $profile['bio'];
	$_SESSION['birth'] = $profile['birth'];
	$_SESSION['avatar'] = $profile['avatar'];
}
