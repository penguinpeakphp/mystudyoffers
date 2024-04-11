<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "../PHPMailer/vendor/autoload.php";
require_once "../globaldata.php";

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

//Function for sending email for the activation of the account, with the generated token
function sendactivationmail($to, $subject, $activationtoken, $id)
{
    try 
    {
        //Using global variables for using them in the email content
        global $sitephone;
        global $siteemail;
        global $emailimageurl;
        global $siteurl;

        //Replace the content inside the email content
        $emailContent = file_get_contents('activationemail.html');
        $emailContent = str_replace('[name]', $_POST["name"], $emailContent);
        $emailContent = str_replace('[subject]', $subject, $emailContent);

        $emailContent = str_replace('[sitephone]' , $sitephone , $emailContent);
        $emailContent = str_replace('[siteemail]' , $siteemail , $emailContent);
        $emailContent = str_replace('[imageurl]' , $emailimageurl , $emailContent);
        $emailContent = str_replace('[activatelink]' , $siteurl."/activate.php?id={$id}&token={$activationtoken}" , $emailContent);

        //Use global mail variable for sending mail to the dedicated recipient
        global $mail;

        $mail->addAddress($to);

        //Send email as HTML
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $emailContent;
        $mail->send();
    } 
    catch (Exception $e) 
    {
        return false;
    }

    return true;
}
