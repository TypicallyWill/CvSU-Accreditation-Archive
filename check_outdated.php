<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Replace with your database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cvsuaccr_db';

// Replace with your SMTP email configuration
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'cvsuaccreditation.access@gmail.com';
$smtpPassword = 'fdrfuvjxtgyneqio';
$smtpPort = 587;
$smtpEncryption = 'tls';

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date
$currentDate = date('Y-m-d');

    // Query to retrieve files with validity dates exceeded
    $sql = "SELECT * FROM files WHERE valid_until = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ownerEmail = $row['owner_email'];
            $fileOwner = $row['file_owner'];
            $fileName = $row['file_name'];
            $validUntil = $row['valid_until'];

            // Send notification email using PHPMailer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                              //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
                $mail->SMTPAuth   = true;             //Enable SMTP authentication
                $mail->Username   = 'cvsuaccreditation.access@gmail.com';   //SMTP write your email
                $mail->Password   = 'fdrfuvjxtgyneqio';      //SMTP password
                $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
                $mail->Port       = 465;      

                // Recipients
                $mail->setFrom('cvsuaccreditation.access@gmail.com', 'CvSU Accreditation Archive');
                $mail->addAddress($ownerEmail);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'File Validity Exceeded';
                $mail->Body = "Dear " .$fileOwner. ",<br><br>The validity date of your file " .$fileName. " has exceeded at " .$validUntil. ".<br><br>Please check your outdated files in the system to make actions.";

                $mail->send();
                echo "Email sent to: $ownerEmail\n<br>Subject: File Validity Exceeded\n";
            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
            }
        }
    } else {
        echo "No files with validity dates exceeded found.";
    }

// Close the database connection
$conn->close();

?>