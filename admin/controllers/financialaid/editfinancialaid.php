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
        if(!isset($_POST["financialaidid"]) || !isset($_POST["financialaidname"]) || !isset($_POST["financialaidstatus"]) || $_POST["financialaidname"] == "" || $_POST["financialaidstatus"] == "" || $_POST["financialaidid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing financialaid based on the financialaid id
        $update = $db->prepare("UPDATE financialaid SET financialaidname = ? , financialaidstatus = ? WHERE financialaidid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the financial aid");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["financialaidname"] , $_POST["financialaidstatus"] , $_POST["financialaidid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the financial aid");
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