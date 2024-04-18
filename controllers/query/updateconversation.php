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

        //Check if we have got all the information that we needed
        if(!isset($_POST["queryid"]) || !isset($_POST["reply"]) || $_POST["reply"] == "" || $_POST["queryid"] == "")
        {
            failure($response , "Please enter all the information needed to make a reply");
            goto end;
        }

        //Query the database to insert the reply into the database
        $insert = $db->prepare("INSERT INTO queryconversation(queryid , studentid , message) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding your reply to the conversation");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("iis" , $_POST["queryid"] , $_SESSION["studentid"] , $_POST["reply"]);

            //Excecute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while adding your reply to the conversation");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating the conversation - " . $e->getCode());
    }

    echo json_encode($response);

?>