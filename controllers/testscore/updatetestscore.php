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

        //Check if the work experience has been given or not
        if(!isset($_POST["workexperience"]))
        {
            failure($response , "Please enter work experience");
            goto end;
        }

        //Check if the test scores has been given or not
        if(!isset($_POST["testscores"]))
        {
            failure($response , "Please enter test scores");
            goto end;
        }

        //Begin transaction as there are few queries needed to be run for one functionality
        $db->begin_transaction();

        //Query the database to delete old work experience
        $delete = $db->prepare("DELETE FROM studentworkexperience WHERE studentid = ?");
        if($delete == false)
        {
            failure($response , "Error while removing old work experience");
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
                failure($response , "Error while removing old work experience");
                $db->rollback();
                goto end;
            }
        }

        //Query the database for replacing the work experience value
        $replace = $db->prepare("INSERT INTO studentworkexperience VALUES(? , ?)");
        if($replace == false)
        {
            failure($response , "Error while updating the work experience");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $replace->bind_param("ii" , $_SESSION["studentid"] , $_POST["workexperience"]);

            //Execute the query
            if($replace->execute() == false)
            {
                failure($response , "Error while updating the work experience");
                $db->rollback();
                goto end;
            }
        }

        //Query the database to delete old test scores
        $delete = $db->prepare("DELETE FROM testtypetestscore WHERE studentid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting old test scores of tests");
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
                failure($response , "Error while deleting old test scores of tests");
                $db->rollback();
                goto end;
            }
        }

        //Loop through each test score
        foreach($_POST["testscores"] as $testscore)
        {
            //Break test score into key value pair like testid => testscoreid
            foreach($testscore as $key => $value)
            {
                //Query the database to insert the test score of the test
                $insert = $db->prepare("INSERT INTO testtypetestscore VALUES(? , ? , ?)");
                if($insert == false)
                {
                    failure($response , "Error while inserting test scores");
                    $db->rollback();
                    goto end;
                }
                else
                {
                    //Bind the parameters
                    $insert->bind_param("iii" , $_SESSION["studentid"] , $key , $value);

                    //Execute the query
                    if($insert->execute() == false)
                    {
                        failure($response , "Error while inserting test scores");
                        $db->rollback();
                        goto end;
                    }
                }
            }
        }

        //Query the database to update the profile status
        $update = $db->prepare("UPDATE student SET profilestatus = 'countryinterest' WHERE studentid = ? AND (SELECT NOT countryinterest FROM studentprofiletrack WHERE studentid = ?)");
        if($update == false)
        {
            failure($response , "Error updating profile status");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $update->bind_param("ii" , $_SESSION["studentid"] , $_SESSION["studentid"]);

            //Excecute the query
            if($update->execute() == false)
            {
                failure($response , "Error updating profile status");
                $db->rollback();
                goto end;
            }
        }

        $update = $db->query("UPDATE studentprofiletrack SET testscore = 1 WHERE studentid = '{$_SESSION['studentid']}'");
        if($update == false)
        {
            failure($response , "Error updating profile track status");
            goto end;
        }

        if($response["success"] == true)
        {
            $db->commit();
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating test score data - " . $e->getCode());
    }

    echo json_encode($response);

?>