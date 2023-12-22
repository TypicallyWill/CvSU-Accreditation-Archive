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

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'cvsuaccr_db';

$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

/*if (isset($_GET['file_name']) && isset($_GET['file_id']) && isset($_GET['view_link']) && isset($_GET['download_link'])) {
    echo $file_name = $_GET['file_name'];
    echo $file_id = $_GET['file_id'];
    echo $file_viewLink = $_GET['view_link'];
    echo $file_downloadLink = $_GET['download_link'];*/

    /*$data = json_decode(file_get_contents("php://input"), true);

    $file_name = $data["fileName"];
    $file_id = $data["fileId"];
    $file_viewLink = $data["viewLink"];
    $file_downloadLink = $data["downloadLink"];*/

    $file_id = $_COOKIE['file_id'];
    $file_name = $_COOKIE['file_name'];
    $file_viewLink = $_COOKIE['view_link'];
    $file_downloadLink = $_COOKIE['download_link'];

    // CHECK DATABASE CONNECTION
    if($db_connection->error){
        die ("Connection Failed - ".$db_connection->connect_error);
    }

    $sql = "UPDATE files SET file_id = '$file_id', file_viewLink = '$file_viewLink', file_downloadLink = '$file_downloadLink' WHERE file_name = '$file_name'";

    if ($db_connection->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Sorry, there was an error uploading your file: " . $db_connection->error;
    }
  header("Location: uploaded_files.php");
?>