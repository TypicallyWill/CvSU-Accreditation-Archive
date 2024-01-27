<?php
session_start();
require('./config.php');

$client->setAccessToken($_SESSION['token']);

if($client->isAccessTokenExpired()){
  header('Location: logout.php');
  exit;
}
$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

$first_name = $user_info['given_name'];
$last_name = $user_info['family_name'];
$owner_email = $user_info['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'cvsuaccr_db';

    $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

    // CHECK DATABASE CONNECTION
    if($db_connection->error){
        die ("Connection Failed - ".$db_connection->connect_error);
    }

    $new_firstName = $_POST['firstName'];
    $new_lastName = $_POST['lastName'];
    $new_email = $_POST['userEmail'];
    $new_userLevel = $_POST['userLevel'];
    $new_college = $_POST['userCollege'];

    if ($new_userLevel == 2) {
        if ($new_college == "") {
            echo "Sorry, please input a college.";
        }
        else {
            $sql = "UPDATE users SET user_level = '$new_userLevel', college = '$new_college' WHERE first_name = '$new_firstName' && last_name = '$new_lastName' && email = '$new_email'";
        }
    }
    else {
        $sql = "UPDATE users SET user_level = '$new_userLevel', college = '' WHERE first_name = '$new_firstName' && last_name = '$new_lastName' && email = '$new_email'";
    }

    if ($db_connection->query($sql) === TRUE) {
        // Retrieve college of the current user from users table
        $retrieve_college_query = $db_connection->prepare("SELECT `college` FROM `users` WHERE `email`=?");
        $retrieve_college_query->bind_param("s", $owner_email);
        $retrieve_college_query->execute();
        $college_result = $retrieve_college_query->get_result();
        $college_row = $college_result->fetch_assoc();
        $college = $college_row['college'];

        // Log add user activity
        $activity_message = $owner_email . ' has changed the info of user: ' . $new_email;
        $log_activity_query = $db_connection->prepare("INSERT INTO `logs` (`email`, `user_level`, `college`, `time`, `activity`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)");
        $log_activity_query->bind_param("siss", $owner_email, $_SESSION['user_level'], $college, $activity_message);
        $log_activity_query->execute();

        echo "The user " . $new_email . " information has been edited.";
    } else {
        echo "Sorry, there was an error adding the user: " . $db_connection->error;
    }
}
header("Location: user_list.php");
?>