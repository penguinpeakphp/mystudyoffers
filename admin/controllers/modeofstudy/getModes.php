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

        //Declare states array for storing the data of different modes
        $response["modes"] = [];

        //Query the database for selecting all the modes data from the mode table
        $select = $db->query("SELECT * FROM mode_of_study");
        if($select == false)
        {
            failure($response , "Error while fetching mode list");
            goto end;
        }

        //Loop through all the rows and push the state data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["modes"] , $row);
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