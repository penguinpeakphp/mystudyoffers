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
        if(!isset($_POST["testscoreid"]) || !isset($_POST["testscore"]) || !isset($_POST["testscorestatus"]) || $_POST["testscore"] == "" || $_POST["testscorestatus"] == "" || $_POST["testscoreid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing testscore based on the testscore id
        $update = $db->prepare("UPDATE testscore SET testscore = ? , testscorestatus = ? WHERE testscoreid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the test score");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["testscore"] , $_POST["testscorestatus"] , $_POST["testscoreid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the test score");
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