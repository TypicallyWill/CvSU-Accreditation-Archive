<?php
session_start();

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

require('./config.php');
require('./dbConfig.php');

$client->setAccessToken($_SESSION['token']);

if ($client->isAccessTokenExpired()) {
    header('Location: logout.php');
    exit;
}

// Use the userinfo to get the user's email
$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {   
    die("Connection failed: " . mysqli_connect_error());
}

$email = $user_info['email'];
$email = mysqli_real_escape_string($conn, $email); // to prevent SQL injection

// Assuming your 'users' table has a column named 'email' to store user emails
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userLevel = $row['user_level'];

    // Debug: Output user level
    echo "User Level: " . $userLevel;

    if ($userLevel == '2' || $userLevel == '3') {
        $college = $row['college'];

        switch ($college) {
            case 'CAFENR':
                header('Location: course.php');
                exit;
            case 'CAS':
                header('Location: course.php');
                exit;
            case 'CCJ':
                header('Location: course.php');
                exit;
            case 'CED':
                header('Location: course.php');
                exit;
            case 'CEMDS':
                header('Location: course.php');
                exit;
            case 'CEIT':
                header('Location: course.php');
                exit;
            case 'CON':
                header('Location: course.php');
                exit;
            case 'CSPEAR':
                header('Location: course.php');
                exit;
            case 'CVMBS':
                header('Location: course.php');
                exit;
            case 'Colege of Medicine':
                header('Location: course.php');
                exit;
            case 'Graduate School':
                header('Location: course.php');
                exit;

            // Add more cases for other colleges as needed

            default:
                echo "<script>
                        alert('Error: This account is not assigned to a specific college.');
                        window.location.href = 'login.php';
                      </script>";
                exit;
        }
    } else {
        echo "<script>
                alert('Error: This account is not authorized to access the directory.');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Error: User not found in the database.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

mysqli_close($conn); // Close the database connection
?>