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
        if(!isset($_POST["otherfeeid"]) || !isset($_POST["otherfeename"]) || !isset($_POST["otherfeestatus"]) || $_POST["otherfeename"] == "" || $_POST["otherfeestatus"] == "" || $_POST["otherfeeid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing otherfee based on the otherfee id
        $update = $db->prepare("UPDATE otherfee SET otherfeename = ? , otherfeestatus = ? WHERE otherfeeid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the other fee");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["otherfeename"] , $_POST["otherfeestatus"] , $_POST["otherfeeid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the other fee");
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