<?php
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

    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['user_email'];
    $user_level = $_POST['user_access'];
    $college = $_POST['user_college'];

    if ($user_level == 2 || $user_level == 3) {
        if ($college == "") {
            echo "Sorry, please input a college.";
        }
        else {
            $sql = "INSERT INTO access_request (first_name, last_name, email, user_level, college) VALUES ('$first_name', '$last_name', '$email', '$user_level', '$college')";
        }
    }
    else {
        $sql = "INSERT INTO access_request (first_name, last_name, email, user_level, college) VALUES ('$first_name', '$last_name', '$email', '$user_level', '$college')";
    }

    if ($db_connection->query($sql) === TRUE) {
        echo "The user " . $first_name . " " . $last_name . " has successfully sent an access request.";
    } else {
        echo "Sorry, there was an error adding the user: " . $db_connection->error;
    }
}
header("Location: register.php");
?>