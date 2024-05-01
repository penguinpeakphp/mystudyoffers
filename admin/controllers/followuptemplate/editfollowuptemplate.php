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
        if(!isset($_POST["followuptemplateid"]) || !isset($_POST["followuptemplatename"]) || !isset($_POST["followuptemplatestatus"]) || !isset($_POST["followuptemplatebody"]) || $_POST["followuptemplatename"] == "" || $_POST["followuptemplatestatus"] == "" || $_POST["followuptemplateid"] == "" || $_POST["followuptemplatebody"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing followuptemplate based on the followuptempate id
        $update = $db->prepare("UPDATE followuptemplate SET followuptemplatename = ? , followuptemplatebody = ? ,followuptemplatestatus = ? WHERE followuptemplateid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the follow up template");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("ssii" , $_POST["followuptemplatename"] , $_POST["followuptemplatebody"] , $_POST["followuptemplatestatus"] , $_POST["followuptemplateid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the follow up template");
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