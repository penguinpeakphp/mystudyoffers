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

        //Declare test scores array for storing the data of different test scores
        $response["testscores"] = [];

        //Query the database for selecting all the test score data from the test score table
        $select = $db->query("SELECT * FROM testscore");
        if($select == false)
        {
            failure($response , "Error while fetching test score list");
            goto end;
        }

        //Loop through all the rows and push the test score data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["testscores"] , $row);
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