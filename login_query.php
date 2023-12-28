<?php
function handleAuthorizationCode($client)
{
    session_start();
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        header('Location: login.php');
        exit;
    }

    $_SESSION['token'] = $token;

    $client->setAccessToken($token);
    $google_oauth = new Google_Service_Oauth2($client);
    $user_info = $google_oauth->userinfo->get();

    return trim($user_info['email']);
}

function performLogin($client, $db_connection, $email)
{
    require('./dbConfig.php');

    $check_email = $db_connection->prepare("SELECT * FROM `users` WHERE `email`=?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $_SESSION['user_level'] = $user_data['user_level'];

        // Check if oauth_uid column is empty
        if (empty($user_data['oauth_uid'])) {
            // Retrieve oauth_uid from $user_info['id']
            $google_oauth = new Google_Service_Oauth2($client);
            $user_info = $google_oauth->userinfo->get();
            $oauth_uid = trim($user_info['id']);

            // Update oauth_uid in the users table
            $update_oauth_uid_query = $db_connection->prepare("UPDATE `users` SET `oauth_uid`=? WHERE `email`=?");
            $update_oauth_uid_query->bind_param("ss", $oauth_uid, $email);
            $update_oauth_uid_query->execute();
        }

        // Update the active_status to 'online' when the user logs in
        $update_status_query = $db_connection->prepare("UPDATE `users` SET `active_status`='online' WHERE `email`=?");
        $update_status_query->bind_param("s", $email);
        $update_status_query->execute();

        // Log user activity
        $activity_message = $email . ' has logged into the system';
        $log_activity_query = $db_connection->prepare("INSERT INTO `logs` (`email`, `user_level`, `college`, `time`, `activity`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, ?)");
        $log_activity_query->bind_param("siss", $email, $_SESSION['user_level'], $user_data['college'], $activity_message);
        $log_activity_query->execute();

        switch ($_SESSION['user_level']) {
            case '1':
                header('Location: admin_dashboard.php');
                exit;
            case '2':
                header('Location: ido_dashboard.php');
                exit;
            case '3':
                // Check user's college and redirect accordingly
                $college = $user_data['college'];
                switch ($college) {
                    case 'CAFENR':
                        header('Location: cafenr.php');
                        exit;
                    case 'CAS':
                        header('Location: cas.php');
                        exit;
                    case 'CCJ':
                        header('Location: ccj.php');
                        exit;
                    case 'CED':
                        header('Location: ced.php');
                        exit;
                    case 'CEMDS':
                        header('Location: cemds.php');
                        exit;
                    case 'CEIT':
                        header('Location: ceit.php');
                        exit;
                    case 'CON':
                        header('Location: nursing.php');
                        exit;
                    case 'CSPEAR':
                        header('Location: cspear.php');
                        exit;
                    case 'CVMBS':
                        header('Location: cvmbs.php');
                        exit;
                    case 'College of Medicine':
                        header('Location: com.php');
                        exit;
                    case 'Graduate School':
                        header('Location: graduate_school.php');
                        exit;
                    // Add more cases for other colleges as needed
                    default:
                        echo "<script>
                                alert('Error: This account is not assigned to a specific college.');
                                window.location.href = 'login.php';
                              </script>";
                        exit;
                }
            default:
                echo "<script>
                        alert('Error: This account is not authorized to access the system.');
                        window.location.href = 'register.php';
                      </script>";
                exit;
        }
    } else {
        echo "<script>alert('User not registered. Please contact the administrator.');
        window.location.href = 'register.php';
        </script>";
        exit;
    }
}
?>