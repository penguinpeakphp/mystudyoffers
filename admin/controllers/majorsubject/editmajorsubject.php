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
        if(!isset($_POST["majorsubjectid"]) || !isset($_POST["majorsubjectname"]) || !isset($_POST["majorsubjectstatus"]) || !isset($_POST["academicid"]) || $_POST["majorsubjectid"] == "" || $_POST["majorsubjectname"] == "" || $_POST["majorsubjectstatus"] == "" || $_POST["academicid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing major subject based on the major subject id
        $update = $db->prepare("UPDATE majorsubject SET majorsubjectname = ? , majorsubjectstatus = ? , academicid = ? WHERE majorsubjectid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the major subject");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("siii" , $_POST["majorsubjectname"] , $_POST["majorsubjectstatus"] , $_POST["academicid"] , $_POST["majorsubjectid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the major subject");
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