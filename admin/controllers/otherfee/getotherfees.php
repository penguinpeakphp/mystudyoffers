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

        //Declare otherfee array for storing the data of different otherfees
        $response["otherfees"] = [];

        //Query the database for selecting all the otherfee data from the otherfee table
        $select = $db->query("SELECT * FROM otherfee");
        if($select == false)
        {
            failure($response , "Error while fetching otherfee list");
            goto end;
        }

        //Loop through all the rows and push the otherfee data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["otherfees"] , $row);
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