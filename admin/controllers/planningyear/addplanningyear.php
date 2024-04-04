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
        if(!isset($_POST["planningyear"]) || !isset($_POST["planningyearstatus"]) || $_POST["planningyear"] == "" || $_POST["planningyearstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting planning year into the database
        $insert = $db->prepare("INSERT INTO planningyear(planningyear , planningyearstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the planning year");
            goto end;
        }
        else
        {
            //Bind the planning year name and status
            $insert->bind_param("si" , $_POST["planningyear"] , $_POST["planningyearstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the planning year");
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