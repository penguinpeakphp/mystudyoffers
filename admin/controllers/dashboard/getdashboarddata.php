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
        $result = $db->query("SELECT count(*) AS newstudents FROM student WHERE registeredon >= '{$today}'");
        if($result == false)
        {
            failure($response , "Error fetching number of students");
            goto end;
        }
        $row = $result->fetch_assoc();
        $response["newstudents"] = $row["newstudents"];

        //Fetch number of queries asked today
        $result = $db->query("SELECT count(*) AS newqueries FROM studentquery WHERE createdate >= '{$today}'");
        if($result == false)
        {
            failure($response , "Error fetching number of new queries");
            goto end;
        }
        $row = $result->fetch_assoc();
        $response["newqueries"] = $row["newqueries"];

        //Fetch followups
        $response["followups"] = [];
        $result = $db->query("SELECT followupid , remarks , name  FROM studentfollowup sf INNER JOIN student s ON sf.studentid = s.studentid WHERE nextfollowupdate = '{$today}'");
        if($result == false)
        {
            failure($response , "Error fetching followups");
            goto end;
        }
        while($row = $result->fetch_assoc())
        {
            array_push($response["followups"] , $row);
        }

        //Fetch chats
        $response["chats"] = [];
        $result = $db->query("SELECT message , queryid FROM queryconversation WHERE studentid IS NOT NULL AND readbyadmin = 0");
        if($result == false)
        {
            failure($response , "Error fetching new conversations");
            goto end;
        }
        $i = 0;
        while($row = $result->fetch_assoc())
        {
            array_push($response["chats"] , $row);
            $i++;
        }
        $response["newchats"] = $i; 

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>