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

        //Check if the majorsubjectid has been received
        if(!isset($_POST["majorsubjectid"]))
        {
            failure($response , "Not enough data for deleting major subject");
            goto end;
        }

        //Query the database for deleting the major subject with the help of majorsubjectid
        $delete = $db->prepare("DELETE FROM majorsubject WHERE majorsubjectid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the major subject");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["majorsubjectid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the major state");
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