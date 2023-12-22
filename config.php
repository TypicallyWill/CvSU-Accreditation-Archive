<?php
require('./vendor/autoload.php');

# Add your client ID and Secret
$client_id = "75132863473-h6i0tqj5tuc7jbm6ptjgrlb7snvv8im6.apps.googleusercontent.com";
$client_secret = "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";

$client = new Google\Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);

# redirection location is the path to login.php
$redirect_uri = 'http://localhost/cvsu_accrsystem/login.php';
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
?>