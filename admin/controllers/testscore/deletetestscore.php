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

        //Check if the testscoreid has been received
        if(!isset($_POST["testscoreid"]))
        {
            failure($response , "Not enough data for deleting test score");
            goto end;
        }

        //Query the database for deleting the test score with the help of testscoreid
        $delete = $db->prepare("DELETE FROM testscore WHERE testscoreid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the test score");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["testscoreid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the test score");
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