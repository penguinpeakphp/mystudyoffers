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

        //Check if the testid has been received
        if(!isset($_POST["testid"]))
        {
            failure($response , "Not enough data for deleting test type");
            goto end;
        }

        //Query the database for deleting the test type with the help of testid
        $delete = $db->prepare("DELETE FROM testtype WHERE testid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the test type");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["testid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the test type");
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