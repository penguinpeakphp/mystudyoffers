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

        //Declare the variable for storing the cities
        $response["cities"] = [];

        //Call the function and store the cities in the response object
        getcities($response , $response["cities"]);

        //Declare the variable for storing levelofcourses
        $response["levelofcourses"] = [];

        //Call the function and store the level of courses in the response object
        getlevelofcourses($response , $response["levelofcourses"]);

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>