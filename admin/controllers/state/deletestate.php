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

        //Check if the stateid has been received
        if(!isset($_POST["stateid"]))
        {
            failure($response , "Not enough data for deleting state");
            goto end;
        }

        //Query the database for deleting the state with the help of stateid
        $delete = $db->prepare("DELETE FROM state WHERE stateid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the state");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["stateid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the state");
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