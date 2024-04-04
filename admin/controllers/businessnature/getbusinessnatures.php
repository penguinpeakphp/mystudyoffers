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

        //Declare business natures array for storing the data of different business natures
        $response["businessnatures"] = [];

        //Query the database for selecting all the business nature data from the businessnature table
        $select = $db->query("SELECT * FROM businessnature");
        if($select == false)
        {
            failure($response , "Error while fetching business nature list");
            goto end;
        }

        //Loop through all the rows and push the business nature data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["businessnatures"] , $row);
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