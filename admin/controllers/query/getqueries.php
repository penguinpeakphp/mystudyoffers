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

        //Declare array for storing queries
        $response["queries"] = [];

        //Query the database for fetching student queries
        $select = $db->prepare("SELECT queryid qi, querytopic , (SELECT messagetime FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS messagetime , sq.studentid , name FROM studentquery sq INNER JOIN student s ON sq.studentid = s.studentid");
        if($select == false)
        {
            failure($response , "Error while fetching query list");
            goto end;
        }
        else
        {
            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching query list");
                goto end;
            }

            //Fetch the result
            $result = $select->get_result();

            //Loop through all the queries and push the data into the array
            while($row = $result->fetch_assoc())
            {
                array_push($response["queries"] , $row);
            }
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