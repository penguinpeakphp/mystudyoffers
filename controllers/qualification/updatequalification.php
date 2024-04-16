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

        //Check if the user has atleaset filled the information
        if(!isset($_POST["chkqualilevel"]) || !isset($_POST["chkquali"]))
        {
            failure($response , "Please fill the information");
            goto end;
        }

        //Check if the user has entered more than 2 qualification levels
        if(count($_POST["chkqualilevel"]) > 2)
        {
            failure($response , "Qualification Level can only be 2 at max");
            goto end;
        }

        //Check if the user has entered more than 3 next qualifications
        if(count($_POST["chkquali"]) > 3)
        {
            failure($response , "Next Qualification can only be 3 at max");
            goto end;
        }

        //Begin transaction as there are two queries needed to be run for one functionality
        $db->begin_transaction();

        //Query the database to delete old student qualification data using student id
        $delete = $db->prepare("DELETE FROM studentqualification WHERE studentid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting old qualification data");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($delete->execute() == false)
            {
                failure($response , "Error while deleteing old qualification data");
                $db->rollback();
                goto end;
            }
        }

        //Query the database to delete old student qualification data using student id
        $delete = $db->prepare("DELETE FROM studentqualificationsub WHERE studentid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting old next qualification data");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($delete->execute() == false)
            {
                failure($response , "Error while deleteing old next qualification sub data");
                $db->rollback();
                goto end;
            }
        }

        //Loop through the qualification level and insert the data
        foreach($_POST["chkqualilevel"] as $qualification)
        {
            //Query the database to insert selected qualification data
            $insert = $db->prepare("INSERT INTO studentqualification VALUES(? , ?)");
            if($insert == false)
            {
                failure($response , "Error while inserting qualification");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $insert->bind_param("ii" , $_SESSION["studentid"] , $qualification);

                //Execute the qualification
                if($insert->execute() == false)
                {
                    failure($response , "Error while inserting qualification");
                    $db->rollback();
                    goto end;
                }
            }
        }

        //Loop through the next qualification level and insert the data
        foreach($_POST["chkquali"] as $qualificationsub)
        {
            //Query the database to insert selected qualification data
            $insert = $db->prepare("INSERT INTO studentqualificationsub VALUES(? , ?)");
            if($insert == false)
            {
                failure($response , "Error while inserting next qualification");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $insert->bind_param("ii" , $_SESSION["studentid"] , $qualificationsub);

                //Execute the qualification
                if($insert->execute() == false)
                {
                    failure($response , "Error while inserting next qualification");
                    $db->rollback();
                    goto end;
                }
            }
        }

        //If everything is successful, commit the transaction
        if($response["success"] == true)
        {
            $db->commit();
        }
    

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating qualification data - " . $e->getCode());
    }

    echo json_encode($response);

?>