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

        //Declare an array for storing query lists
        $response["queries"] = [];

        //Query the database for fetching student queries
        $select = $db->prepare("SELECT queryid qi, querytopic , (SELECT studentid FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS studentid , (SELECT adminid FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS adminid , (SELECT DATE_FORMAT(messagetime, '%m-%d-%Y') FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS lastdate FROM studentquery WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching query list");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching query list");
                goto end;
            }

            //Fetch the result and loop through the query lists
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["queries"] , $row);
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching query list - " . $e->getCode());
    }

    echo json_encode($response);

?>