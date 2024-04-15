<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        if(checksession($response) == false)
        {
            goto end;
        }

        if(isset($_GET["academic1"]) && $_GET["academic1"] == "academic1")
        {
            $response["academic1"] = [];
            $select = $db->prepare("SELECT sa.academicid FROM studentacademics sa INNER JOIN academic a WHERE studentid = ? AND a.academicstatus = 1");
            if($select == false)
            {
                failure($response , "Error while fetching your existing academic data");
                goto end;
            }
            else
            {
                $select->bind_param("i" , $_SESSION["studentid"]);
                if($select->execute() == false)
                {
                    failure($response , "Error while fetching your existing academic data");
                    goto end;
                }
                $result = $select->get_result();
                while($row = $result->fetch_assoc())
                {
                    array_push($response["academic1"] , $row["academicid"]);
                }
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while getting existing academic data - " . $e->getCode());
    }

    echo json_encode($response);

?>