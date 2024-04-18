<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if enough information has been provided for updating the conversation
        if(!isset($_POST["reply"]) || !isset($_POST["queryid"]) || $_POST["reply"] == "" || $_POST["queryid"] == "")
        {
            failure($response , "Please enter enough information for updating conversation");
            goto end;
        }

        //Query the database for inserting new conversationm
        $insert = $db->prepare("INSERT INTO queryconversation(queryid , adminid , message) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while updating the conversation");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("iis" , $_POST["queryid"] , $_SESSION["adminid"] , $_POST["reply"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while updating the conversation");
                goto end;
            }
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