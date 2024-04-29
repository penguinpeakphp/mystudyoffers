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

        //Check if the otherfeeid has been received
        if(!isset($_POST["otherfeeid"]))
        {
            failure($response , "Not enough data for deleting other fee");
            goto end;
        }

        //Query the database for deleting the otherfee with the help of otherfeeid
        $delete = $db->prepare("DELETE FROM otherfee WHERE otherfeeid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the other fee");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["otherfeeid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the other fee");
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