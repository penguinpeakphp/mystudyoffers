<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once "PHPMailer/vendor/autoload.php";

    $sitephone = "+91 89800 04238 ";
    $siteemail = "admin@mystudyoffers.com";

    $emailimageurl = "https://demo.mystudyoffers.com/images/logo-img.png";
    $activateimageurl = "https://demo.mystudyoffers.com/images/active_now.png";
    $siteurl = "http://localhost:8000";
    $emailreferenceurl = "https://demo.mystudyoffers.com";

    $mail = new PHPMailer(true);

    //Enable SMTP debugging.
    $mail->SMTPDebug = 0;
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();
    //Set SMTP host name                          
    $mail->Host = "smtp.hostinger.com";
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password     
    $mail->Username = "php@penguinpeak.com";
    $mail->Password = "r@hiL@602";
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "ssl";
    //Set TCP port to connect to
    $mail->Port = 465;

    $mail->From = "php@penguinpeak.com";
    $mail->FromName = "Penguin Peak";
?>