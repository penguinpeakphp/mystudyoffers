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
        if(!isset($_POST["businessid"]) || !isset($_POST["businessname"]) || !isset($_POST["businessstatus"]) || $_POST["businessname"] == "" || $_POST["businessstatus"] == "" || $_POST["businessid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing business nature based on the business id
        $update = $db->prepare("UPDATE businessnature SET businessname = ? , businessstatus = ? WHERE businessid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the business nature");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["businessname"] , $_POST["businessstatus"] , $_POST["businessid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the business nature");
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