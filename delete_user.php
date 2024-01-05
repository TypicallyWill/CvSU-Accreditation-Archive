<?php   
session_start();

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

require('./config.php');

 include './dbconfig.php';  

 $client = new Google\Client();
 $client->setAccessToken($_SESSION['token']);
 
 $google_oauth = new Google_Service_Oauth2($client);
 $user_info = $google_oauth->userinfo->get();
 
 $owner_email = $user_info['email'];

 $db_host = 'localhost';
 $db_user = 'root';
 $db_password = '';
 $db_name = 'cvsuaccr_db';

 $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

 if($db_connection->error){
    die ("Connection Failed - ".$db_connection->connect_error);
}

// Check if the id is provided
if (isset($_POST['id'])) {
    // Get the id from the POST request
    $id = $_POST['id'];
    $email = $_POST['email'];

    // Perform the deletion query
    $sql = "DELETE FROM users WHERE id = '$id'";

    if($db_connection->query($sql) === TRUE){
        // Retrieve college of the current user from users table
        $retrieve_college_query = $db_connection->prepare("SELECT `college` FROM `users` WHERE `email`=?");
        $retrieve_college_query->bind_param("s", $owner_email);
        $retrieve_college_query->execute();
        $college_result = $retrieve_college_query->get_result();
        $college_row = $college_result->fetch_assoc();
        $college = $college_row['college'];

        // Log add user activity
        $activity_message = $owner_email . ' has deleted a user from the database';
        $log_activity_query = $db_connection->prepare("INSERT INTO `logs` (`email`, `user_level`, `college`, `time`, `activity`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)");
        $log_activity_query->bind_param("siss", $owner_email, $_SESSION['user_level'], $college, $activity_message);
        $log_activity_query->execute();

        echo "The user has been deleted from the database.";
    } else {
        echo "Sorry, there was an error deleting the user: " . $db_connection->error;
    }

} else {
    // fileId is not provided, handle the error
    echo "User id not provided";
}
?>