<?php
session_start();
require('./config.php');

$client->setAccessToken($_SESSION['token']);

if ($client->isAccessTokenExpired()) {
    header('Location: logout.php');
    exit;
}
$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

$first_name = $user_info['given_name'];
$last_name = $user_info['family_name'];
$email  = $user_info['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "files/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array("jpg", "jpeg", "png", "pdf", "docx");
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only PDF, DOCX, JPG, JPEG, PNG files are allowed.";
        } else {
            // Establish the database connection
            $db_host = 'localhost';
            $db_user = 'root';
            $db_password = '';
            $db_name = 'cvsuaccr_db';

            $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            // CHECK DATABASE CONNECTION
            if ($db_connection->error) {
                die("Connection Failed - " . $db_connection->connect_error);
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $file_name = $_FILES["file"]["name"];
                $file_size = $_FILES["file"]["size"];
                $file_type = $_FILES["file"]["type"];
                $file_owner = $first_name . " " . $last_name;
                $file_directory = $_POST["directories"];
                $file_course = $_POST["course"];
                $file_area = $_POST["area"];
                $owner_email = $email;
                $file_tags = $_POST["tags"]; // Get file tags from the form
                $valid_until = isset($_POST["validUntil"]) ? $_POST["validUntil"] : null; // New input for "Valid Until"

                // Escape the file_tags and valid_until to prevent SQL injection
                $escaped_file_tags = $db_connection->real_escape_string($file_tags);
                $escaped_valid_until = $db_connection->real_escape_string($valid_until);

                // Remove unexpected characters from file_tags and separate tags with commas
                $cleaned_file_tags = preg_replace('/[^a-zA-Z0-9,\s]/', '', $escaped_file_tags);

                // Remove leading and trailing commas
                $cleaned_file_tags = trim($cleaned_file_tags, ',');
                
                // Use a prepared statement to prevent SQL injection
                $stmt = $db_connection->prepare("SELECT * FROM files WHERE file_name = ?");
                $stmt->bind_param("s", $file_name);
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Check if the file exists in the database
                if ($result->num_rows > 0) {
                    echo "File '$file_name' already exists in the database.";
                } else {
                    $sql = "INSERT INTO files (file_name, file_size, file_type, file_owner, file_directory, file_course, file_area, owner_email, file_tags, valid_until) VALUES ('$file_name', '$file_size', '$file_type', '$file_owner', '$file_directory', '$file_course', '$file_area', '$owner_email', '$cleaned_file_tags', '$escaped_valid_until')";

                    if ($db_connection->query($sql) === TRUE) {
                        // Retrieve college of the current user from users table
                        $retrieve_college_query = $db_connection->prepare("SELECT `college` FROM `users` WHERE `email`=?");
                        $retrieve_college_query->bind_param("s", $email);
                        $retrieve_college_query->execute();
                        $college_result = $retrieve_college_query->get_result();
                        $college_row = $college_result->fetch_assoc();
                        $college = $college_row['college'];
    
                        // Log file upload activity
                        $activity_message = $email . ' has uploaded a file: ' . $file_name . ' at ' . $file_directory;
                        $log_activity_query = $db_connection->prepare("INSERT INTO `logs` (`email`, `user_level`, `college`, `time`, `activity`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)");
                        $log_activity_query->bind_param("siss", $email, $_SESSION['user_level'], $college, $activity_message);
                        $log_activity_query->execute();
    
                        echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded in the database.";
                    } else {
                        echo "Sorry, there was an error uploading your file: " . $db_connection->error;
                    }
                }

                // Close the prepared statement
                $stmt->close();
            }
        }
    } else {
        echo "No file was uploaded.";
    }
}
header("Location: upload_success.php");
?>