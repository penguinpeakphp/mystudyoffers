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

        //Check if the qualificationsubid has been received
        if(!isset($_POST["qualificationsubid"]))
        {
            failure($response , "Not enough data for deleting Qualification sub");
            goto end;
        }

        //Query the database for deleting the qualificationsub with the help of qualificationsubid
        $delete = $db->prepare("DELETE FROM qualificationsub WHERE qualificationsubid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the Qualification sub");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["qualificationsubid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the Qualification sub");
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