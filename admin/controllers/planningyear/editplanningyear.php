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

        //Check if all the fields are set and have some value
        if(!isset($_POST["planningyearid"]) || !isset($_POST["planningyear"]) || !isset($_POST["planningyearstatus"]) || $_POST["planningyear"] == "" || $_POST["planningyearstatus"] == "" || $_POST["planningyearid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing planning year based on the planning year id
        $update = $db->prepare("UPDATE planningyear SET planningyear = ? , planningyearstatus = ? WHERE planningyearid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the planning year");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["planningyear"] , $_POST["planningyearstatus"] , $_POST["planningyearid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the planning year");
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