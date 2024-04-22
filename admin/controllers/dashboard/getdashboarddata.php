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


        $today = date("Y-m-d");

        //Fetch number of students registered today
        $result = $db->query("SELECT count(*) AS newstudents FROM student WHERE registeredon > '{$today}'");
        if($result == false)
        {
            failure($response , "Error fetching number of students");
            goto end;
        }
        $row = $result->fetch_assoc();
        $response["newstudents"] = $row["newstudents"];

        //Fetch number of queries asked today
        $result = $db->query("SELECT count(*) AS newqueries FROM studentquery WHERE createdate > '{$today}'");
        if($result == false)
        {
            failure($response , "Error fetching number of new queries");
            goto end;
        }
        $row = $result->fetch_assoc();
        $response["newqueries"] = $row["newqueries"];

        //Fetch number of conversations replied today
        $result = $db->query("SELECT count(*) AS chats FROM queryconversation WHERE DATE(messagetime) > '{$today}'");
        if($result == false)
        {
            failure($response , "Error fetching number of new chats");
            goto end;
        }
        $row = $result->fetch_assoc();
        $response["newchats"] = $row["chats"];

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>