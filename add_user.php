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

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $user_level = $_POST['user_level'];
    $college = $_POST['college'];

    if ($user_level == 2 || $user_level == 3) {
        if ($college == "") {
            echo "Sorry, please input a college.";
        }
        else {
            $sql = "INSERT INTO users (first_name, last_name, email, birthdate, gender, user_level, college) VALUES ('$first_name', '$last_name', '$email', '$birthdate', '$gender', '$user_level', '$college')";
        }
    }
    else {
        $sql = "INSERT INTO users (first_name, last_name, email, birthdate, gender, user_level, college) VALUES ('$first_name', '$last_name', '$email', '$birthdate', '$gender', '$user_level', '$college')";
    }

    if ($db_connection->query($sql) === TRUE) {
        echo "The user " . $first_name . " " . $last_name . " has been added to the database.";
    } else {
        echo "Sorry, there was an error adding the user: " . $db_connection->error;
    }
}
header("Location: users.php");
?>