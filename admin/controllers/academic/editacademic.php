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
        if(!isset($_POST["academicid"]) || !isset($_POST["academicname"]) || !isset($_POST["academicstatus"]) || $_POST["academicname"] == "" || $_POST["academicstatus"] == "" || $_POST["academicid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing academic based on the academic id
        $update = $db->prepare("UPDATE academic SET academicname = ? , academicstatus = ? WHERE academicid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the academic qualification");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["academicname"] , $_POST["academicstatus"] , $_POST["academicid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the academic qualification");
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