<?php
 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
 
//Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {
 
  $mail = new PHPMailer(true);

  $name = $_POST["first_name"] . " " . $_POST["last_name"];
 
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'cvsuaccreditation.access@gmail.com';   //SMTP write your email
    $mail->Password   = 'fdrfuvjxtgyneqio';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    
 
    //Recipients
    $mail->setFrom( $_POST["email"], $name); // Sender Email and name
    $mail->addAddress('laicadennise.miranda@cvsu.edu.ph');     //Add a recipient email  
    $mail->addReplyTo($_POST["email"], $name); // reply to sender email
 
    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = $_POST["subject"];   // email subject headings

    $level = $_POST["user_level"];
    if ($level == "2") {
      $mail->Body    = "Name: " . $name . "<br>Email: " . $_POST["email"] . "<br>Access Level: Faculty <br>College: " . $_POST["college"]; //email message
    }
    elseif ($level == "3") {
      $mail->Body    = "Name: " . $name . "<br>Email: " . $_POST["email"] . "<br>Access Level: Student <br>College: " . $_POST["college"]; //email message
    }
    else {
      $mail->Body    = "Name: " . $name . "<br>Email: " . $_POST["email"] . "<br>Access Level: IDO"; //email message
    }

    // Success sent message alert
    $mail->send();
    echo
    " 
    <script> 
     alert('Request sent successfully! Please wait while we redirect you back.');
     window.close();
    </script>
    ";
}
?>