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
        $select = $db->prepare("SELECT queryid qi, querytopic , querytypeid qti, (SELECT querytypename FROM querytype WHERE querytypeid = qti) AS querytypename , (SELECT studentid FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS studentid , (SELECT adminid FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS adminid , (SELECT DATE_FORMAT(messagetime, '%d-%m-%Y') FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS lastdate FROM studentquery WHERE studentid = ?");
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

         //Declare qyerytypes array for storing the data of different query types
         $response["querytypes"] = [];

         //Query the database for selecting all the query type data from the query type table
         $select = $db->query("SELECT * FROM querytype");
         if($select == false)
         {
             failure($response , "Error while fetching query type list");
             goto end;
         }
 
         //Loop through all the rows and push the query type data into the array one by one
         while($row = $select->fetch_assoc())
         {
             array_push($response["querytypes"] , $row);
         }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching query list - " . $e->getCode());
    }

    echo json_encode($response);

?>