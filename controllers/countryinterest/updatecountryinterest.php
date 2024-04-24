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

        //Check if the user has selected countries or not
        if(!isset($_POST["chkdesti"]))
        {
            failure($response , "Please enter countries");
            goto end;
        }

        //Check if the user has selected atleast 3 countries
        if(count($_POST["chkdesti"]) < 3)
        {
            failure($response , "Select atleast three countries");
            goto end;
        }

        //Begin the transaction because there are multiple queries for one functionality
        $db->begin_transaction();

        //Query the database to delete old selected countries
        $delete = $db->prepare("DELETE FROM studentcountry WHERE studentid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting old countries");
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
                failure($response , "Error while deleting old countries");
                $db->rollback();
                goto end;
            }
        }


        foreach($_POST["chkdesti"] as $country)
        {
            //Query the database to insert new selected countries
            $insert = $db->prepare("INSERT INTO studentcountry VALUES(? , ?)");
            if($insert == false)
            {
                failure($response , "Error while adding new countries of interest");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $insert->bind_param("ii" , $_SESSION["studentid"] , $country);

                //Execute the query
                if($insert->execute() == false)
                {
                    failure($response , "Error while adding new countries of interest");
                    $db->rollback();
                    goto end;
                }
            }
        }

        //Query the database to update the profile status
        $update = $db->prepare("UPDATE student SET profilestatus = 'dashboard' WHERE studentid = ?");
        if($update == false)
        {
            failure($response , "Error updating profile status");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $update->bind_param("i" , $_SESSION["studentid"]);

            //Excecute the query
            if($update->execute() == false)
            {
                failure($response , "Error updating profile status");
                $db->rollback();
                goto end;
            }
        }

        if($response["success"] == true)
        {
            $db->commit();
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating country of interest - " . $e->getCode());
    }

    echo json_encode($response);

?>