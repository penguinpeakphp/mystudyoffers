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
        if(!isset($_POST["resultid"]) || !isset($_POST["resultname"]) || !isset($_POST["resultstatus"]) || $_POST["resultname"] == "" || $_POST["resultstatus"] == "" || $_POST["resultid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing result based on the result id
        $update = $db->prepare("UPDATE result SET resultname = ? , resultstatus = ? WHERE resultid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the result");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["resultname"] , $_POST["resultstatus"] , $_POST["resultid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the result");
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