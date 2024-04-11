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

        //Declare results array for storing the data of different results
        $response["results"] = [];

        //Query the database for selecting all the result data from the result table
        $select = $db->query("SELECT * FROM result");
        if($select == false)
        {
            failure($response , "Error while fetching result list");
            goto end;
        }

        //Loop through all the rows and push the result data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["results"] , $row);
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