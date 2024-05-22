<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check in the session if the user has logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if all the necessary data is provided
        if(
            !isset($_POST["editname"]) || !isset($_POST["editemail"]) || !isset($_POST["editphone"]) || !isset($_POST["editpincode"]) || !isset($_POST["editsurname"]) ||
            empty($_POST["editname"]) || empty($_POST["editemail"]) || empty($_POST["editphone"]) || empty($_POST["editpincode"] || empty($_POST["editsurname"]))
        )
        {
            failure($response , "Please fill all the required fields");
            goto end;
        }

        $name = $_POST["editname"];
        $email = $_POST["editemail"];
        $phone = $_POST["editphone"];
        $pincode = $_POST["editpincode"];
        $surname = $_POST["editsurname"];

        $update = $db->prepare("UPDATE student SET name = ?, email = ?, phone = ?, surname = ?, pincode = ? WHERE studentid = ?");
        $update->bind_param("sssssi", $name, $email, $phone, $surname, $pincode, $_SESSION["studentid"]);

        if($update->execute() == false)
        {
            failure($response , "Error Occurred while updating student data");
            goto end;
        }

        $response["message"] = "Student data updated successfully";
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching student data - " . $e->getCode());
    }

    echo json_encode($response);
?>