<?php
    require_once "../../../controllers/globaldata.php";
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";

    //Function for sending email for new message
    function sendnewmessageemail($to , $subject , $name)
    {
        //Using global variables for using them in the email content
        global $sitephone;
        global $siteemail;
        global $emailimageurl;
        global $siteurl;
        global $emailreferenceurl;

        //Replace the content inside the email content
        $emailContent = file_get_contents('newmessageemail.html');
        $emailContent = str_replace('[name]', $name, $emailContent);
        $emailContent = str_replace('[subject]', $subject, $emailContent);

        $emailContent = str_replace('[siteurl]' , $siteurl , $emailContent);
        $emailContent = str_replace('[sitephone]' , $sitephone , $emailContent);
        $emailContent = str_replace('[siteemail]' , $siteemail , $emailContent);
        $emailContent = str_replace('[imageurl]' , $emailimageurl , $emailContent);
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

    //Function for fetching extension of file
    function getFileExtension($filename) 
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Start the transaction as there are multiple operations for one functionality
        $db->begin_transaction();

        //Check if enough information has been provided for updating the conversation
        if(!isset($_POST["reply"]) || !isset($_POST["queryid"]) || $_POST["reply"] == "" || $_POST["queryid"] == "")
        {
            failure($response , "Please enter enough information for updating conversation");
            $db->rollback();
            goto end;
        }

        //Query the database for inserting new conversationm
        $insert = $db->prepare("INSERT INTO queryconversation(queryid , adminid , message) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while updating the conversation");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("iss" , $_POST["queryid"] , $_SESSION["adminid"] , $_POST["reply"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while updating the conversation");
                $db->rollback();
                goto end;
            }
        }

        //Get the latest auto incremented id
        $conversationid = $db->insert_id;

        //Check if the file is uploaded and then only perform upload action
        if(isset($_FILES["file"]))
        {
            //Generate the filename
            $filename = $conversationid.".".getFileExtension($_FILES["file"]["name"]);

            //Move the file to the respective directory
            if(move_uploaded_file($_FILES["file"]["tmp_name"] , "../../../conversationfiles/".$filename) == false)
            {
                failure($response , "Error while uploading the file");
                $db->rollback();
                goto end;
            }

            //Update the query for setting the file name
            $update = $db->query("UPDATE queryconversation SET filename = '{$filename}' WHERE conversationid = '{$conversationid}'");
            if($update == false)
            {
                failure($response , "Error while uploading the file location in database");
                $db->rollback();
                goto end;
            }
        }

        $result = $db->query("SELECT name , email FROM student WHERE studentid = (SELECT sq.studentid FROM queryconversation qc INNER JOIN studentquery sq ON qc.queryid = sq.queryid WHERE qc.conversationid = '{$conversationid}')");
        if($result == false)
        {
            failure($response , "Error fetching name and email of student");
            goto end;
        }
        $row = $result->fetch_assoc();
        sendnewmessageemail($row["email"] , "New Message Notification" , $row["name"]);
        

        //Commit the database if everything goes well
        if($response["success"] == true)
        {
            $db->commit();
        }

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>