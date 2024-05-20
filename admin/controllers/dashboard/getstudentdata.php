<?php

    require_once "../../database/db.php";
    require_once "../globalfunctions.php";

    try
    {
        $response["success"] = true;

        // Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        // Get student data
        $result = $db->query("SELECT * FROM student where studentid = " . $_SESSION["studentid"]);
        // Check if query was successful
        if($result == false)
        {
            $response["success"] = false;
            $response["error"] = "Some Error Occurred";
            goto end;
        }

        // If query was successful, return data
        $response["data"] = $result->fetch_assoc();
        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>