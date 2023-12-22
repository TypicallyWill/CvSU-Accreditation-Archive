<?php

    require_once 'dbConfig.php';

    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    if(!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth') {

        $credential = !empty($jsonObj->credential)?$jsonObj->credential:'';

        list($header, $payload, $signature) = explode (".", $credential);
        $responsePayload = json_decode(base64_decode($payload));

        if(!empty($responsePayload)) {

            $oauth_provider = 'google';
            $oauth_uid = !empty($responsePayload->sub)?$responsePayload->sub:'';
            $first_name = !empty($responsePayload->given_name)?$responsePayload->given_name:'';
            $last_name = !empty($responsePayload->family_name)?$responsePayload->family_name:'';
            $email = !empty($responsePayload->email)?$responsePayload->email:'';
            $picture = !empty($responsePayload->picture)?$responsePayload->picture:'';

            $query = "SELECT * FROM users WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
            $result = $db->query($query);

            if($result->num_rows > 0) {

                $query = "UPDATE users SET first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', picture = '".$picture."', modified = NOW() WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
                $update = $db->query($query);
            }

            else {
                
                $query = "INSERT INTO users VALUES (NULL, '".$oauth_provider."', '".$oauth_uid."', '".$first_name."', '".$last_name."', '".$email."', '".$picture."', NOW(), NOW())";
                $insert = $db->query($query);
            }

            $output = [
                'status' => 1,
                'msg' => 'Account data inserted successfully!',
                'pdata' => $responsePayload
            ];

            echo json_decode($output);
        }

        else {
            echo json_decode(['error' => 'Account data is not available!']);
        }
    }

?>