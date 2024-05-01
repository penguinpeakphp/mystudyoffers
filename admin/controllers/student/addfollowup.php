<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";
    require_once "../../../controllers/globaldata.php";

    //Function for sending email for new follow up
    function sendnewfollowupemail($to , $subject , $name , $followupbody)
    {
        //Using global variables for using them in the email content
        global $sitephone;
        global $siteemail;
        global $emailimageurl;
        global $siteurl;
        global $emailreferenceurl;

        //Replace the content inside the email content
        $emailContent = file_get_contents('newfollowupmessage.html');
        $emailContent = str_replace('[name]', $name, $emailContent);
        $emailContent = str_replace('[subject]', $subject, $emailContent);

        $emailContent = str_replace('[siteurl]' , $siteurl , $emailContent);
        $emailContent = str_replace('[sitephone]' , $sitephone , $emailContent);
        $emailContent = str_replace('[siteemail]' , $siteemail , $emailContent);
        $emailContent = str_replace('[imageurl]' , $emailimageurl , $emailContent);
        $emailContent = str_replace('[emailreferenceurl]' , $emailreferenceurl , $emailContent);
        $emailContent = str_replace('[followupbody]' , $followupbody , $emailContent);

        //Use global mail variable for sending mail to the dedicated recipient
        global $mail;

        $mail->addAddress($to);

        //Send email as HTML
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $emailContent;
        $mail->send();
    }

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if all the data has been receievd
        if(!isset($_POST["studentid"]) || !isset($_POST["remarks"]) || !isset($_POST["nextfollowupdate"]) || !isset($_POST["followuptemplatebody"]) || !isset($_POST["followuptemplateid"]) || $_POST["studentid"] == "" || $_POST["remarks"] == "" || $_POST["nextfollowupdate"] == "" || $_POST["followuptemplatebody"] == "" || $_POST["followuptemplateid"] == "")
        {
            failure($response , "Please provide all the information");
            goto end;
        }

        //Query the database for inserting follow up
        $insert = $db->prepare("INSERT INTO studentfollowup(studentid , remarks , nextfollowupdate , followuptemplateid , followuptemplatebody) VALUES(? , ? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while inserting follow up");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("issis" , $_POST["studentid"] , $_POST["remarks"] , $_POST["nextfollowupdate"] , $_POST["followuptemplateid"] , $_POST["followuptemplatebody"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while inserting follow up");
                goto end;
            }
        }

        //Query the database for fetching email of the student
        $select = $db->prepare("SELECT name , email FROM student WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching student email");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_POST["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching student email");
                goto end;
            }

            $result = $select->get_result();
            $row = $result->fetch_assoc();
        }

        //Send email for new follow up to the student
        //sendnewfollowupemail($row["email"] , "New Follow Up Notification" , $row["name"] , $_POST["followuptemplatebody"]);

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>