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

        //Declare academics array for storing the data of different academic qualifications
        $response["academics"] = [];

        //Query the database for selecting all the academic data from the academic table
        $select = $db->query("SELECT * FROM academic");
        if($select == false)
        {
            failure($response , "Error while fetching academic qualification list");
            goto end;
        }

        //Loop through all the rows and push the academic data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["academics"] , $row);
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