<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        // if(checksession($response) == false)
        // {
        //     goto end;
        // }

        //Declare cities array for storing the data of different cities
        $response["cities"] = [];

        //Query the database for selecting all the city data from the city table
        $query = "SELECT ac.* FROM allcities ac ";

        // if id of state are passed
        if (isset($_GET["stateid"])) {
            $query = $query . " WHERE state_id = " . $_GET["stateid"];
        }
        // if ids of countries are passed
        else if (isset($_GET["countries"]) && $_GET["countries"] != "" && trim($_GET["search"]) != "" ) {
            $query = $query . " INNER JOIN allstates ast ON ac.state_id = ast.id WHERE ast.country_id IN  (" . $_GET["countries"] . ") AND ac.name LIKE '%" . $_GET["search"] . "%'";
        }

        $select = $db->query($query);
        if ($select == false) {
            failure($response, "Error while fetching city list");
            goto end;
        }

        //Loop through all the rows and push the city data into the array one by one
        while ($row = $select->fetch_assoc()) {
            array_push($response["cities"], $row);
        }

        end:;
    }
    catch (Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>