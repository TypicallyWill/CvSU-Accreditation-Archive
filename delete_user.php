<?php
session_start();

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

require('./config.php');

$client->setAccessToken($_SESSION['token']);

if ($client->isAccessTokenExpired()) {
    header('Location: logout.php');
    exit;
}

$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

$user = 'root';
$password = '';

$database = 'cvsuaccr_db';

$servername = '127.0.0.1';
$mysqli = new mysqli($servername, $user, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$query = "SELECT oauth_uid FROM users WHERE email = '$email'";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $oauth_uid = $row['oauth_uid'];

    // Perform deletion in the database
    $deleteQuery = "DELETE FROM users WHERE email = '$email'";
    $deleteResult = $mysqli->query($deleteQuery);

    if ($deleteResult) {
        // Additional actions after successful deletion, if needed
        echo "User deleted successfully!";
    } else {
        // Handle deletion failure
        echo "Error deleting user: " . $mysqli->error;
    }
} else {
    // Handle query failure
    echo "Error retrieving user data: " . $mysqli->error;
}

$mysqli->close();
?>
