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
        if(!isset($_POST["instituteid"]) || !isset($_POST["institutename"]) || !isset($_POST["institutestatus"]) || $_POST["institutename"] == "" || $_POST["institutestatus"] == "" || $_POST["instituteid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing institute type based on the testid
        $update = $db->prepare("UPDATE institutetype SET institutename = ? , institutestatus = ? WHERE instituteid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the institute type");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["institutename"] , $_POST["institutestatus"] , $_POST["instituteid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the institute type");
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