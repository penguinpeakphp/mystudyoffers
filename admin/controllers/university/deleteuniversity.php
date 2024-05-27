<?php
require_once "../../database/db.php";
require_once "../globalfunctions.php";

try 
{
    $response["success"] = true;

    function deleteDirectory($dir) 
    {
        // Ensure the directory exists
        if (!is_dir($dir)) 
        {
            return false;
        }
    
        // Get all contents of the directory
        $items = array_diff(scandir($dir), array('.', '..'));
    
        foreach ($items as $item) 
        {
            $path = "$dir/$item";
            
            // Recursively delete directories
            if (is_dir($path)) 
            {
                deleteDirectory($path);
            } 
            else 
            {
                // Delete files
                unlink($path);
            }
        }
    
        // Remove the directory itself
        return rmdir($dir);
    }

    //Check session and go to end if session verification is failed
    if (checksession($response) == false) 
    {
        goto end;
    }

    //Query the database for deleting the university
    $delete = $db->prepare("DELETE FROM university WHERE universityid = ?");
    if($delete == false)
    {
        failure($response , "Error while deleting the university");
        goto end;
    }
    else
    {
        //Bind the parameters
        $delete->bind_param("s" , $_GET["universityid"]);

        //Execute the query
        if($delete->execute() == false)
        {
            failure($response , "Error while deleting the university");
            goto end;
        }
    }

    // Example usage
    $universityId = basename($_GET["universityid"]);
    $directoryPath = "../../universitydata/{$_GET["universityid"]}";
    
    if(deleteDirectory($directoryPath) == false) 
    {
        failure($response , "Error while deleting the university directory");
        goto end;
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