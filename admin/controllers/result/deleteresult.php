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

        //Check if the resultid has been received
        if(!isset($_POST["resultid"]))
        {
            failure($response , "Not enough data for deleting result");
            goto end;
        }

        //Query the database for deleting the result with the help of resultid
        $delete = $db->prepare("DELETE FROM result WHERE resultid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the result");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["resultid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the result");
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