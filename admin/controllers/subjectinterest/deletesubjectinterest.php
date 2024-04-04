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

        //Check if the subjectinterestid has been received
        if(!isset($_POST["subjectinterestid"]))
        {
            failure($response , "Not enough data for deleting subject interest");
            goto end;
        }

        //Query the database for deleting the subject interest with the help of subjectinterestid
        $delete = $db->prepare("DELETE FROM subjectinterest WHERE subjectinterestid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the subject interest");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["subjectinterestid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error wihle deleting the subject interest");
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