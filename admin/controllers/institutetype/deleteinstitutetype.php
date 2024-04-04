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

        //Check if the instituteid has been received
        if(!isset($_POST["instituteid"]))
        {
            failure($response , "Not enough data for deleting institute type");
            goto end;
        }

        //Query the database for deleting the institute type with the help of instituteid
        $delete = $db->prepare("DELETE FROM institutetype WHERE instituteid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the institute type");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["instituteid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the institute type");
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