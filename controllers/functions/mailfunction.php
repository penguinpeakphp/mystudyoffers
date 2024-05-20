<?php

require_once "../globaldata.php";

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
        global $emailreferenceurl;
        global $activateimageurl;

        //Replace the content inside the email content
        $emailContent = file_get_contents('activationemail.html');
        $emailContent = str_replace('[name]', $_POST["name"], $emailContent);
        $emailContent = str_replace('[subject]', $subject, $emailContent);

        $emailContent = str_replace('[sitephone]' , $sitephone , $emailContent);
        $emailContent = str_replace('[siteemail]' , $siteemail , $emailContent);
        $emailContent = str_replace('[imageurl]' , $emailimageurl , $emailContent);
        $emailContent = str_replace('[activateimageurl]' , $activateimageurl , $emailContent);
        $emailContent = str_replace('[activatelink]' , $siteurl."/activate.php?id={$id}&token={$activationtoken}" , $emailContent);
        $emailContent = str_replace('[emailreferenceurl]' , $emailreferenceurl , $emailContent);

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

function sendrecoverymail($to, $subject, $token)
{
    try 
    {
        //Using global variables for using them in the email content
        global $sitephone;
        global $siteemail;
        global $emailimageurl;
        global $siteurl;
        global $emailreferenceurl;

        //Replace the content inside the email content
        $emailContent = file_get_contents('activationemail.html');
        $emailContent = str_replace('[name]', $_POST["name"], $emailContent);
        $emailContent = str_replace('[subject]', $subject, $emailContent);

        $emailContent = str_replace('[sitephone]' , $sitephone , $emailContent);
        $emailContent = str_replace('[siteemail]' , $siteemail , $emailContent);
        $emailContent = str_replace('[imageurl]' , $emailimageurl , $emailContent);
        $emailContent = str_replace('[forgotlink]' , $siteurl."/{$token}", $emailContent);
        $emailContent = str_replace('[emailreferenceurl]' , $emailreferenceurl , $emailContent);

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
