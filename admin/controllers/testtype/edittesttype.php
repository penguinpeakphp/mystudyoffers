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
        if(!isset($_POST["testid"]) || !isset($_POST["testname"]) || !isset($_POST["teststatus"]) || $_POST["testname"] == "" || $_POST["teststatus"] == "" || $_POST["testid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing test type based on the testid
        $update = $db->prepare("UPDATE testtype SET testname = ? , teststatus = ? WHERE testid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the test type");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["testname"] , $_POST["teststatus"] , $_POST["testid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the test type");
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