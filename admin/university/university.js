async function getcities()
{
    await $.get("../controllers/city/getcities.php" , {} , function(data)
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
                //Assign the data to global variable
                cities = response.cities;

                //Populate the select options
                populatecities(".citylist");
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
}

async function getlevelofcourses()
{
    await $.get("../controllers/levelofcourse/getlevelofcourses.php" , {} , function(data)
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
                //Assign the data to global variable
                levelofcourses = response.levelofcourses;

                //Populate the select options
                populatelevelofcourses(".courselevelsoffered");
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
}

async function getotherfees()
{
    await $.get("../controllers/otherfee/getotherfees.php" , {} , function(data)
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
                //Assign the data to global variable
                otherfees = response.otherfees;

                //Populate the checkbox dropdown
                populateuniversityotherfees(".otherfees");
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
}

async function getfinancialaids()
{
    await $.get("../controllers/financialaid/getfinancialaids.php" , {} , function(data)
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
                //Assign the data to global variable
                financialaids = response.financialaids;

                //Populate the checkbox dropdown
                populateuniversityfinancialaid(".financialaid");
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
}

async function getaccreditations()
{
    await $.get("../controllers/accreditation/getaccreditations.php" , {} , function(data)
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
                //Assign the data to global variable
                accreditations = response.accreditations;

                //Populate the checkbox dropdown
                populateaccreditations(".accreditationstatus");
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
}

async function getrankawardingbodies()
{
    await $.get("../controllers/rankawardingbody/getrankawardingbodies.php" , {} , function(data)
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
                //Assign the data to global variable
                rankawardingbodies = response.rankawardingbodies;

                //Populate the checkbox dropdown
                populaterankawardingbodies(".rankawardingbodylist");
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
}

$(function()
{
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

    function checkrankings() 
    {
        let allFilled = true;

        $("#otherrankingslist .otherrankings").each(function()
        {
            // Check all input fields and the select element in this campus
            $(this).find("input, select, textarea").each(function() 
            {
                if ($(this).val() === "" || $(this).val() === null) 
                {
                    allFilled = false; // If any field is empty, mark this campus as invalid
                }
            });

            // If any campus section is invalid, mark the whole validation as false
            if (!allFilled) 
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

    $("#addotherrankings").on("click" , function()
    {
        if(!checkrankings())
        {
            alert("Please enter all other rankings before adding more");
            return;
        }
        //Clone the template
        let newRanking = $("#otherrankingstemplate").clone();

        // Remove attribute for preventing multiple ID copy issue
        newRanking.removeAttr("id");
        
        // Remove 'd-none' class to make it visible
        newRanking.removeClass("d-none");
        
        // Append the new ranking to the container
        $("#otherrankingslist").append(newRanking);

        //Populate rank awarding bodies
        populaterankawardingbodies("#rankawardingbodylist");

        // Attach event handler to the "Remove" button
        newRanking.find(".removeotherranking").on("click", function() {
            newRanking.remove();
        });
    });

    //Function for checking if other teams and clubs have been added or not
    function checkteamsandclubs()
    {
        let allFilled = true;

        $("#otherteamsandclubslist .otherteamsandclubs").each(function()
        {
            if($(this).val() == "")
            {
                allFilled = false;
            }
        });

        return allFilled;
    }

    $("#addteamsandclubs").on("click" , function()
    {
        //Check if other teams and clubs have been added
        if(!checkteamsandclubs())
        {
            alert("Please enter all other teams and clubs before adding more");
            return;
        }

        //Clone the template
        let newteamsandclubs = $("#otherteamsandclubstemplate").clone();

        // Remove attribute for preventing multiple ID copy issue
        newteamsandclubs.removeAttr("id");
        
        // Remove 'd-none' class to make it visible
        newteamsandclubs.removeClass("d-none");
        
        // Append the new teamsandclubs to the container
        $("#otherteamsandclubslist").append(newteamsandclubs);
        
        // Attach event handler to the "Remove" button
        newteamsandclubs.find(".removeteamsandclubs").on("click", function() {
            newteamsandclubs.remove();
        });
    });

    //Function for checking if all the images have been attached
    function validateFacilityImages() 
    {
        let allFilled = true;
    
        $("#facilityimageslist .facilityimages").each(function() 
        {
            // Check if there's a file selected
            if ($(this).val() === "") 
            {
                allFilled = false;
            }
        });
    
        return allFilled;
    }
    
    $("#addfacilityimages").on("click", function() 
    {
        // Validate if all existing file inputs are filled
        if (!validateFacilityImages()) {
            alert("Please select a file for all existing facility images before adding more.");
            return; // Exit if validation fails
        }

        // Clone the template to create a new file input
        let newFacilityImage = $("#facilityimagestemplate").clone();

        // Remove ID to avoid duplication
        newFacilityImage.removeAttr("id");

        // Reset the file input and make it visible
        newFacilityImage.find("input[type='file']").val(""); // Reset file input
        newFacilityImage.removeClass("d-none");

        // Append the new file input field to the list
        $("#facilityimageslist").append(newFacilityImage);

        // Attach event handler to the "Remove" button
        newFacilityImage.find(".removefacilityimages").on("click", function() {
            newFacilityImage.remove();
        });
    });
});