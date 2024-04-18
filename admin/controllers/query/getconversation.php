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

        //Check if query id is provided
        if(!isset($_GET["queryid"]))
        {
            failure($response , "Incomplete information for fetching conversation");
            goto end;
        }

        //Declare an array for storing the conversation
        $response["conversation"] = [];

        //Query the database for fetching the conversation from the table
        $select = $db->prepare("SELECT * , DATE_FORMAT(messagetime, '%m/%d/%Y . %h:%i %p') AS timestring FROM queryconversation WHERE queryid = ? ORDER BY conversationid DESC");
        if($select == false)
        {
            failure($response , "Error while fetching conversation");
            goto end;
        }
        else
        {
            //Bind the parametes
            $select->bind_param("i" , $_GET["queryid"]);

            //Exceute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching conversation");
                goto end;
            }

            //Get the result
            $result = $select->get_result();

            //Loop through the result and push the data into the array
            while($row = $result->fetch_assoc())
            {
                array_push($response["conversation"] , $row);
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