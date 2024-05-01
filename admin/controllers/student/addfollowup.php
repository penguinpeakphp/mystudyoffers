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

        //Check if all the data has been receievd
        if(!isset($_POST["studentid"]) || !isset($_POST["remarks"]) || !isset($_POST["nextfollowupdate"]) || !isset($_POST["followuptemplatebody"]) || !isset($_POST["followuptemplateid"]) || $_POST["studentid"] == "" || $_POST["remarks"] == "" || $_POST["nextfollowupdate"] == "" || $_POST["followuptemplatebody"] == "" || $_POST["followuptemplateid"] == "")
        {
            failure($response , "Please provide all the information");
            goto end;
        }

        //Query the database for inserting follow up
        $insert = $db->prepare("INSERT INTO studentfollowup(studentid , remarks , nextfollowupdate , followuptemplateid , followuptemplatebody) VALUES(? , ? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while inserting follow up");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("issis" , $_POST["studentid"] , $_POST["remarks"] , $_POST["nextfollowupdate"] , $_POST["followuptemplateid"] , $_POST["followuptemplatebody"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while inserting follow up");
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