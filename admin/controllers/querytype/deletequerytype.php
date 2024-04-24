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

        //Check if the querytypeid has been received
        if(!isset($_POST["querytypeid"]))
        {
            failure($response , "Not enough data for deleting query type");
            goto end;
        }

        //Query the database for deleting the querytype with the help of querytypeid
        $delete = $db->prepare("DELETE FROM querytype WHERE querytypeid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the querytype");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["querytypeid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the query type");
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