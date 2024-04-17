<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check the session for user authentication
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if the query has been received
        if(!isset($_POST["query"]))
        {
            failure($response , "Please enter your query");
            goto end;
        }

        //Query the database to insert the student query
        $insert = $db->prepare("INSERT INTO studentquery(studentid , querytopic) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error Occurred while creating student query");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("is" , $_SESSION["studentid"] , $_POST["query"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error Occurred while creating student query");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while adding new query - " . $e->getCode());
    }

    echo json_encode($response);

?>