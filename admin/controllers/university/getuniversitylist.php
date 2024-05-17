<?php
require_once "../../database/db.php";
require_once "../globalfunctions.php";

try 
{
    $response["success"] = true;

    //Check session and go to end if session verification is failed
    if (checksession($response) == false) 
    {
        goto end;
    }

    $response["universitylist"] = [];
    $select = $db->prepare("SELECT universityid, universityname, universitylicensenumber, keycontactemail, keycontactname , universitystatus FROM university");
    if($select == false)
    {
        failure($response , "Error while fetching university list");
        goto end;
    }
    else
    {
        if($select->execute() == false)
        {
            failure($response , "Error while fetching university list");
            goto end;
        }
        $result = $select->get_result();
        while($row = $result->fetch_assoc())
        {
            array_push($response["universitylist"] , $row);
        }
    }
    end:;
} 
catch (Exception  $e) 
{
    $response["success"] = false;
    $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
}

echo json_encode($response);
?>