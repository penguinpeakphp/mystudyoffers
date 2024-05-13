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

        //Declare rankawardingbodies array for storing the data of different rankawardingbodies
        $response["rankawardingbodies"] = [];

        //Query the database for selecting all the rank awarding body data from the rank awarding body table
        $select = $db->query("SELECT * FROM rankawardingbody");
        if($select == false)
        {
            failure($response , "Error while fetching rank awarding body list");
            goto end;
        }

        //Loop through all the rows and push the rank awarding body data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["rankawardingbodies"] , $row);
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