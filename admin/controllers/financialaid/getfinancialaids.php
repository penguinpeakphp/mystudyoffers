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

        //Declare financialaids array for storing the data of different financialaids
        $response["financialaids"] = [];

        //Query the database for selecting all the financialaid data from the financialaid table
        $select = $db->query("SELECT * FROM financialaid");
        if($select == false)
        {
            failure($response , "Error while fetching financial aid list");
            goto end;
        }

        //Loop through all the rows and push the financialaid data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["financialaids"] , $row);
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