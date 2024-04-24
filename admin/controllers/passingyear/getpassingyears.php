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

        //Declare passingyears array for storing the data of different passing years
        $response["passingyears"] = [];

        //Query the database for selecting all the passing year data from the passingyear table
        $select = $db->query("SELECT * FROM passingyear");
        if($select == false)
        {
            failure($response , "Error while fetching passing year list");
            goto end;
        }

        //Loop through all the rows and push the passing year data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["passingyears"] , $row);
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