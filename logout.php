<?php
session_start();

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

require('config.php');
require('dbConfig.php');

$client = new Google\Client();
$client->setAccessToken($_SESSION['token']);

$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

$user_email = trim($user_info['email']);

// Update the active_status to 'offline' when the user logs out
$update_status_query = $db_connection->prepare("UPDATE `users` SET `active_status`='offline' WHERE `email`=?");
$update_status_query->bind_param("s", $user_email);
$update_status_query->execute();

// Log user activity for logout
$activity_message = $user_email . ' has logged out from the system';
$user_level = isset($_SESSION['user_level']) ? $_SESSION['user_level'] : null;

// Retrieve the college information from the users table
$retrieve_college_query = $db_connection->prepare("SELECT `college` FROM `users` WHERE `email`=?");
$retrieve_college_query->bind_param("s", $user_email);
$retrieve_college_query->execute();
$college_result = $retrieve_college_query->get_result();
$college_row = $college_result->fetch_assoc();
$college = $college_row['college'];

$log_activity_query = $db_connection->prepare("INSERT INTO `logs` (`email`, `user_level`, `college`, `time`, `activity`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)");
$log_activity_query->bind_param("siss", $user_email, $user_level, $college, $activity_message);
$log_activity_query->execute();

// Revoking the Google access token
$client->revokeToken();

// Deleting the session that we stored
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
else {
    header("Location: index.php");
}

session_destroy();
header("Location: index.php");
exit;
?>