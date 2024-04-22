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

        //Check if the studentid and followup has been receievd
        if(!isset($_POST["studentid"]) || !isset($_POST["followup"]) || !isset($_POST["nextfollowupdate"]) || $_POST["studentid"] == "" || $_POST["followup"] == "" || $_POST["nextfollowupdate"] == "")
        {
            failure($response , "Please provide all the information");
            goto end;
        }

        //Query the database for inserting follow up
        $insert = $db->prepare("INSERT INTO studentfollowup(studentid , followup , nextfollowupdate) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while inserting follow up");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("iss" , $_POST["studentid"] , $_POST["followup"] , $_POST["nextfollowupdate"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while inserting follow up");
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