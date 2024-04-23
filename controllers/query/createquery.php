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
        if(!isset($_POST["query"]) || !isset($_POST["querytypeid"]) || $_POST["query"] == "" || $_POST["querytypeid"] == "")
        {
            failure($response , "Please enter both query and query type");
            goto end;
        }

        //Query the database to insert the student query
        $insert = $db->prepare("INSERT INTO studentquery(studentid , querytopic , querytypeid) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error Occurred while creating student query");
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("isi" , $_SESSION["studentid"] , $_POST["query"] , $_POST["querytypeid"]);

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