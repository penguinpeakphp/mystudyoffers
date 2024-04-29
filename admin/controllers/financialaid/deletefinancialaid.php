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

        //Check if the financialaidid has been received
        if(!isset($_POST["financialaidid"]))
        {
            failure($response , "Not enough data for deleting financial aid");
            goto end;
        }

        //Query the database for deleting the financial aid with the help of financial aid
        $delete = $db->prepare("DELETE FROM financialaid WHERE financialaidid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the financial aid");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["financialaidid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the financial aid");
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