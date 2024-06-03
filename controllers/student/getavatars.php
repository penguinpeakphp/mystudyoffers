<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare avatars array for storing the data of different avatars
        $response["avatars"] = [];

        //Query the database for selecting all the avatar data from the avatar table
        $select = $db->query("SELECT * FROM avatar WHERE avatargender = '{$_GET["avatargender"]}' AND avatarstatus = 1");
        if($select == false)
        {
            failure($response , "Error while fetching avatar list");
            goto end;
        }

        //Loop through all the rows and push the avatar data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["avatars"] , $row);
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