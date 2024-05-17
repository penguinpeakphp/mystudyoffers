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
    $mail->Host = "mail.mystudyoffers.com";
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password     
    $mail->Username = "noreply@mystudyoffers.com";
    $mail->Password = "KdlA(Zj@zBmi";
    
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "TLS";
    //Set TCP port to connect to
    $mail->Port = 587;      

    $mail->From = "noreply@mystudyoffers.com";
    $mail->FromName = "MSO"; 
    $mail->addreplyto('admin@mystudyoffers.com', 'MSO');   
?>