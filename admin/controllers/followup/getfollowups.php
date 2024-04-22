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

        //Declare an array for storing followups
        $response["followups"] = [];

        //Query the database for fetching student follow ups
        $result = $db->query("SELECT followupid , followup , DATE_FORMAT(noteaddedon,'%d-%m-%Y %H:%i:%s') AS noteaddedon , DATE_FORMAT(nextfollowupdate,'%d-%m-%Y') AS nextfollowupdate FROM studentfollowup");
        if($result == false)
        {
            failure($response , "Error while fetching student followups");
            goto end;
        }

        //Loop through all the follow ups and push the data
        while($row = $result->fetch_assoc())
        {
            array_push($response["followups"] , $row);
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