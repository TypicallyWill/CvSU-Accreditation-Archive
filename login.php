<?php
require('./config.php');
require('./login_query.php');

$login_url = $client->createAuthUrl();

if (isset($_GET['code'])) {
    $email = handleAuthorizationCode($client);
    performLogin($client, $db_connection, $email);
}
?>

<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CvSU Accreditation Archive System</title>
        <link rel="stylesheet" type="text/css" href="styles/style2.css" />

    </head>
    <body>

        <div class="container">
            <div class="nav-bar">
                <img src="images/cvsu-logo.png" class="logo">
                    <p class="title"><a></a>CvSU Accreditation Archive System</p>

                <nav>
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="aboutus.php">ABOUT US</a></li>
                        <li><a href="login.php">LOGIN</a></li>
                    </ul>
                </nav>
                <div class="menu">
                    <button class="menu-button">
                        <img src="images/menu.png" class="menu-icon">
                    </button>
                    <div class="menu-content">
                        <a rel="noopener" target="_blank" href="register.php">Register</a>
                    </div>
                </div>
            </div>

            <div class="sign-in-box">
                <div class="sign-in-message">
                    <p>Log in using your CvSU/Google account to continue.</p>
                </div>

                <div class="authorize-button" id="authorize_button"
                    value="Authorize">
                    <div class="content-wrapper">
                        <div class="logo-wrapper">
                            <img src="https://developers.google.com/identity/images/g-logo.png">
                        </div>
                        <span class="text-container">
                            <span><a href="<?= $login_url ?>" class="login-url">Sign in with CvSU account</a></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="content" class="success message"><?php if(isset($message)) { echo $message; } ?>
        </div>

        <script type="text/javascript" src="./js/gapi-upload.js"></script>
        <script async defer src="https://apis.google.com/js/api.js"
            onload="gapiLoaded()"></script>
        <script async defer src="https://accounts.google.com/gsi/client"
            onload="gisLoaded()"></script>
    </body>
</html>