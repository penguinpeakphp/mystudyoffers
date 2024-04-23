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

        //Check if all the fields are set and have some value
        if(!isset($_POST["querytypeid"]) || !isset($_POST["querytypename"]) || !isset($_POST["querytypestatus"]) || $_POST["querytypename"] == "" || $_POST["querytypestatus"] == "" || $_POST["querytypeid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing querytype based on the querytype id
        $update = $db->prepare("UPDATE querytype SET querytypename = ? , querytypestatus = ? WHERE querytypeid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the query type");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["querytypename"] , $_POST["querytypestatus"] , $_POST["querytypeid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the query type");
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