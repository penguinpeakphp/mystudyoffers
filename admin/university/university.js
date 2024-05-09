$(function()
{
    $.get("../controllers/university/getformdata.php" , {} , function(data)
    {
        try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);

                    //Redirect to login page if the user is required to be login again
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    //Assign the data to global variables
                    cities = response.cities;
                    levelofcourses = response.levelofcourses;

                    //Populate the select options
                    populatecities(".citylist");
                    populatelevelofcourses(".courselevelsoffered");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
    });

    function validateAllCampuses() 
    {
        var allFilled = true;
        
        // Check all the campus sections in #othercampusdetails
        $("#othercampusdetails .othercampus").each(function() 
        {
            var campusFilled = true;
            
            // Check all input fields and the select element in this campus
            $(this).find("input, select").each(function() 
            {
                if ($(this).val() === "" || $(this).val() === null) 
                {
                    campusFilled = false; // If any field is empty, mark this campus as invalid
                }
            });
            
            // If any campus section is invalid, mark the whole validation as false
            if (!campusFilled) 
            {
                allFilled = false;
                // Optionally add a highlight or some indication on the invalid campus
                $(this).css("border", "1px solid red");
            } 
            else 
            {
                // Reset border if the section is valid
                $(this).css("border", "none");
            }
        });
        
        return allFilled;
    }
    

    $("#addothercampus").on("click", function() 
    {
        // Validate all campus sections before adding a new one
        if (!validateAllCampuses()) 
        {
            alert("Please ensure all fields in every campus section are filled before adding another.");
            return; // Exit the function to prevent adding a new campus
        }

        // Clone the template
        let newCampus = $("#othercampustemplate").clone();

        // Remove attribute for preventing multiple ID copy issue
        newCampus.removeAttr("id");
        
        // Remove 'd-none' class to make it visible
        newCampus.removeClass("d-none");
        
        // Append the new campus to the container
        $("#othercampusdetails").append(newCampus);

        //Populate the select option with cities
        populatecities(newCampus.find(".othercampuscity"));
        
        // Attach event handler to the "Remove" button
        newCampus.find(".removeothercampus").on("click", function() {
            newCampus.remove();
        });
    });
});