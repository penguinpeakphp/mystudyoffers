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

        //Declare qyerytypes array for storing the data of different query types
        $response["querytypes"] = [];

        //Query the database for selecting all the query type data from the query type table
        $select = $db->query("SELECT * FROM querytype");
        if($select == false)
        {
            failure($response , "Error while fetching query type list");
            goto end;
        }

        //Loop through all the rows and push the query type data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["querytypes"] , $row);
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