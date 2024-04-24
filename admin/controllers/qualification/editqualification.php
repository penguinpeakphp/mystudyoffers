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
        if(!isset($_POST["qualificationid"]) || !isset($_POST["qualificationname"]) || !isset($_POST["qualificationstatus"]) || $_POST["qualificationname"] == "" || $_POST["qualificationstatus"] == "" || $_POST["qualificationid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing qualification based on the qualification id
        $update = $db->prepare("UPDATE qualification SET qualificationname = ? , qualificationstatus = ? WHERE qualificationid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the qualification");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["qualificationname"] , $_POST["qualificationstatus"] , $_POST["qualificationid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the qualification");
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