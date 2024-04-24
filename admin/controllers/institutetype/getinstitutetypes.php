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

        //Declare institutetypes array for storing the data of different institute types
        $response["institutetypes"] = [];

        //Query the database for selecting all the test type data from the test type table
        $select = $db->query("SELECT * FROM institutetype");
        if($select == false)
        {
            failure($response , "Error while fetching test institute list");
            goto end;
        }

        //Loop through all the rows and push the institute type data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["institutetypes"] , $row);
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