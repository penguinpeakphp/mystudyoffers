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
        if(!isset($_POST["workexperienceid"]) || !isset($_POST["workexperiencename"]) || !isset($_POST["workexperiencestatus"]) || $_POST["workexperiencename"] == "" || $_POST["workexperiencestatus"] == "" || $_POST["workexperienceid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing workexperience based on the workexperienceid
        $update = $db->prepare("UPDATE workexperience SET workexperiencename = ? , workexperiencestatus = ? WHERE workexperienceid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the work experience");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["workexperiencename"] , $_POST["workexperiencestatus"] , $_POST["workexperienceid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the work experience");
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