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
        if(!isset($_POST["testscore"]) || !isset($_POST["testscorestatus"]) || $_POST["testscore"] == "" || $_POST["testscorestatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting testscore into the database
        $insert = $db->prepare("INSERT INTO testscore(testscore , testscorestatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the test score");
            goto end;
        }
        else
        {
            //Bind the testscore and status
            $insert->bind_param("si" , $_POST["testscore"] , $_POST["testscorestatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the test score");
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