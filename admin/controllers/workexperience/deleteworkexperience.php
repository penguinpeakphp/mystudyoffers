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

        //Check if the workexperienceid has been received
        if(!isset($_POST["workexperienceid"]))
        {
            failure($response , "Not enough data for deleting work experience");
            goto end;
        }

        //Query the database for deleting the workexperience with the help of workexperienceid
        $delete = $db->prepare("DELETE FROM workexperience WHERE workexperienceid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the work experience");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["workexperienceid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error wihle deleting the work experience");
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