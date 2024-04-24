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
        if(!isset($_POST["passingyearid"]) || !isset($_POST["passingyear"]) || !isset($_POST["passingyearstatus"]) || $_POST["passingyear"] == "" || $_POST["passingyearstatus"] == "" || $_POST["passingyearid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing passingyear based on the passingyearid
        $update = $db->prepare("UPDATE passingyear SET passingyear = ? , passingyearstatus = ? WHERE passingyearid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the passing year");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["passingyear"] , $_POST["passingyearstatus"] , $_POST["passingyearid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the passing year");
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