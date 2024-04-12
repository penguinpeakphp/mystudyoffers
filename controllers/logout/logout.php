<?php

    try
    {
        $response["success"] = true;

        //Start the session before destroying
        session_start();

        //Unset the variables used in this session
        session_unset();

        //Destroy the entire session
        session_destroy();
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Could not logout";
    }

    echo json_encode($response);
?>