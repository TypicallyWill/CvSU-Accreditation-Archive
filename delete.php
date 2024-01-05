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

$user_email = trim($user_info['email']);

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'cvsuaccr_db';

$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($db_connection->error) {
    die("Connection Failed - " . $db_connection->connect_error);
}

// Check if the fileId is provided
if (isset($_POST['fileId'])) {
    // Get the fileId from the POST request
    $fileId = $_POST['fileId'];

    // Retrieve file information for logging before deletion
    $retrieve_file_info_query = $db_connection->prepare("SELECT * FROM files WHERE file_id = ?");
    $retrieve_file_info_query->bind_param("s", $fileId);
    $retrieve_file_info_query->execute();
    $file_info_result = $retrieve_file_info_query->get_result();

    if ($file_info = $file_info_result->fetch_assoc()) {
        $file_name = $file_info['file_name'];
        $file_owner = $file_info['file_owner'];
        $file_directory = $file_info['file_directory'];
        $owner_email = $file_info['owner_email'];

        // Perform the deletion query
        $delete_file_query = $db_connection->prepare("DELETE FROM files WHERE file_id = ?");
        $delete_file_query->bind_param("s", $fileId);

        if ($delete_file_query->execute()) {
            // Log file deletion activity with the email of the currently logged-in user
            $activity_message = "File '$file_name' owned by '$file_owner' in '$file_directory' was deleted by '$user_email'";
            $log_activity_query = $db_connection->prepare("INSERT INTO `logs` (`email`, `user_level`, `college`, `time`, `activity`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)");
            $log_activity_query->bind_param("siss", $user_email, $_SESSION['user_level'], $file_directory, $activity_message);
            $log_activity_query->execute();

            echo "<script>
                    alert('File deleted successfully');
                </script>";
        } else {
            echo "<script>
                    alert('File cannot be deleted.');
                </script>";
        }
    } else {
        echo "<script>
                alert('File information not found.');
            </script>";
    }
} else {
    // fileId is not provided, handle the error
    echo "<script>
            alert('File ID Not Provided.');
        </script>";
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>