<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check if the user has already logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if the type has been supplied
        if(!isset($_GET["type"]) || $_GET["type"] == "")
        {
            failure($response , "Invalid data requested");
            goto end;
        }

        //Declare array for storing the data
        $response["data"] = [];

        //Query the respective table as recieved in the get query
        $result = $db->query("SELECT * FROM {$_GET["type"]} WHERE {$_GET["type"]}status = true");
        if($result == false)
        {
            failure($response , "Error while fetching data");
            goto end;
        }

        //Push the data into the associative array
        while($row = $result->fetch_assoc())
        {
            array_push($response["data"] , $row);
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating data - " . $e->getMessage());
    }

    echo json_encode($response);

?>