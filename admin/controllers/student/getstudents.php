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

        //Declare variable for storing student lead
        $response["students"] = [];
        
        //Query the database for fetching the student data
        $result = $db->query("SELECT * FROM student");
        if($result == false)
        {
            failure($response , "Error while fetching student list");
            goto end;
        }

        //Loop through the result and push the data into the array
        while($row =$result->fetch_assoc())
        {
            array_push($response["students"] , $row);
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