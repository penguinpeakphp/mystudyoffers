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
        if(!isset($_POST["followuptemplatename"]) || !isset($_POST["followuptemplatestatus"]) || !isset($_POST["followuptemplatebody"]) || $_POST["followuptemplatename"] == "" || $_POST["followuptemplatestatus"] == "" || $_POST["followuptemplatebody"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting followuptemplate into the database
        $insert = $db->prepare("INSERT INTO followuptemplate(followuptemplatename , followuptemplatebody , followuptemplatestatus) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the follow up template");
            goto end;
        }
        else
        {
            //Bind the country name and status
            $insert->bind_param("ssi" , $_POST["followuptemplatename"] , $_POST["followuptemplatebody"] , $_POST["followuptemplatestatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the follow up template");
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