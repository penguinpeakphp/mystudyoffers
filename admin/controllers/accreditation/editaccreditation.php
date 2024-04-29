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
        if(!isset($_POST["accreditationid"]) || !isset($_POST["accreditationname"]) || !isset($_POST["accreditationstatus"]) || $_POST["accreditationname"] == "" || $_POST["accreditationstatus"] == "" || $_POST["accreditationid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing accreditation based on the accreditation id
        $update = $db->prepare("UPDATE accreditation SET accreditationname = ? , accreditationstatus = ? WHERE accreditationid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the accreditation");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["accreditationname"] , $_POST["accreditationstatus"] , $_POST["accreditationid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the accreditation");
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