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

        //Check if all the fields are set and have some value
        if(!isset($_POST["financialaidname"]) || !isset($_POST["financialaidstatus"]) || $_POST["financialaidname"] == "" || $_POST["financialaidstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting financialaid into the database
        $insert = $db->prepare("INSERT INTO financialaid(financialaidname , financialaidstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the financial aid");
            goto end;
        }
        else
        {
            //Bind the financialaid name and status
            $insert->bind_param("si" , $_POST["financialaidname"] , $_POST["financialaidstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the financial aid");
                goto end;
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