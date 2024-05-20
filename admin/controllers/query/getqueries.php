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

        //Check if the logged in user is admin or not
        if($_SESSION["admintype"] == "admin")
        {
            //Query the database for fetching all student queries
            $select = $db->prepare("SELECT queryid qi, querytopic , querytypeid qti , (SELECT querytypename FROM querytype WHERE querytypeid = qti) AS querytypename , (SELECT DATE_FORMAT(messagetime,'%d-%m-%Y %h:%i %p') FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS messagetime , (SELECT readbyadmin FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS readbyadmin , sq.studentid , name FROM studentquery sq INNER JOIN student s ON sq.studentid = s.studentid ORDER BY messagetime DESC");   
        }

        //Check if the logged in user is telecaller or not
        if($_SESSION["admintype"] == "telecaller")
        {
            //Query the database for fetching relevant student queries related to telecaller
            $select = $db->prepare("SELECT queryid qi, querytopic , querytypeid qti , (SELECT querytypename FROM querytype WHERE querytypeid = qti) AS querytypename , (SELECT DATE_FORMAT(messagetime,'%d-%m-%Y %h:%i %p') FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS messagetime , (SELECT readbyadmin FROM queryconversation WHERE queryid = qi ORDER BY conversationid DESC LIMIT 1) AS readbyadmin , sq.studentid , name FROM studentquery sq INNER JOIN student s ON sq.studentid = s.studentid INNER JOIN studenttelecaller st ON s.studentid = st.studentid WHERE telecallerid = ? ORDER BY messagetime DESC");

            //Bind the parameters
            $select->bind_param("i" , $_SESSION["adminid"]);
        }

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

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>