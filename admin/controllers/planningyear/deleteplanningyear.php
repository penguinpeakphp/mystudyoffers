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

        //Check if the planningyearid has been received
        if(!isset($_POST["planningyearid"]))
        {
            failure($response , "Not enough data for deleting year of planning");
            goto end;
        }

        //Query the database for deleting the planning year with the help of planningyearid
        $delete = $db->prepare("DELETE FROM planningyear WHERE planningyearid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the year of planning");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["planningyearid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the year of planning");
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