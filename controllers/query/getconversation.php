<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check if the user has already logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare array for storing conversation
        $response["conversation"] = [];

        //Query the database for fetching the conversation
        $select = $db->prepare("SELECT * , DATE_FORMAT(messagetime, '%m/%d/%Y . %h:%i %p') AS timestring FROM queryconversation WHERE queryid = ? ORDER BY conversationid DESC");
        if($select == false)
        {
            failure($response , "Error while fetching conversation");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_GET["queryid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching conversation");
                goto end;
            }

            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["conversation"] , $row);
            }
        }

        //Query the database to mark all unread conversation
        $update = $db->prepare("UPDATE queryconversation SET readbystudent = 1 WHERE queryid = ? AND readbystudent = 0 AND studentid IS NULL");
        if($update == false)
        {
            failure($response , "Error while marking conversation as read");
            goto end;
        }
        else
        {
            //Bind the parameters
            $update->bind_param("i" , $_GET["queryid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while marking conversation as read");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching conversation - " . $e->getCode());
    }

    echo json_encode($response);

?>