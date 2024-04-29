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

        //Check if the accreditationid has been received
        if(!isset($_POST["accreditationid"]))
        {
            failure($response , "Not enough data for deleting accreditation");
            goto end;
        }

        //Query the database for deleting the accreditation with the help of accreditationid
        $delete = $db->prepare("DELETE FROM accreditation WHERE accreditationid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the accreditation");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["accreditationid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the accreditation");
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