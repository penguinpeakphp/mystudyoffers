<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        var_dump($_POST);

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating academic data - " . $e->getMessage());
    }

    echo json_encode($response);

?>