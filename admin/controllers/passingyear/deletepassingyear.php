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

        //Check if the passingyearid has been received
        if(!isset($_POST["passingyearid"]))
        {
            failure($response , "Not enough data for deleting passing year");
            goto end;
        }

        //Query the database for deleting the passing year with the help of passingyearid
        $delete = $db->prepare("DELETE FROM passingyear WHERE passingyearid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the passing year");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["passingyearid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the passing year");
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