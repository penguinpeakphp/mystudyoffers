$(function()
{
    //Remove all the submit buttons from the page
    $("button[type=submit]").remove();

    //Fetch the get parameters from the url
    let params = new URLSearchParams(window.location.search);
    let universityid = params.get("view");

    $.get("../controllers/university/getuniversitydata.php" , {"universityid" : universityid} , function(data)
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
                //Assign the data to local variables for further use
                let university = response.university;
                let universitylevelofcourses = response.universitylevelofcourses;
                let othercampusaddresses = response.othercampusaddresses;
                let universityassets = response.universityassets;
                let clubsandteams = response.clubsandteams;
                let facilityimages = response.facilityimages;

                //Set the data according to the data received from the server
                $("#universitystatus").prop("checked" , university.universitystatus);
                $("#universityname").val(university.universityname);
                $("#universitylicensenumber").val(university.universitylicensenumber);

                //If the file was uploaded, then display the view image link
                if(university.universityimage != "")
                {
                    $("#viewuniversityimage").removeClass("d-none");
                    $("#viewuniversityimage").attr("href" , "../universitydata/" + university.universityid + "/" + university.universityimage);
                    $("#viewuniversityimage").attr("target" , "_blank");
                }

                //Get the level of courses and check the selected courses
                getlevelofcourses().then(function()
                {
                    universitylevelofcourses.forEach(function(data)
                    {
                        $(`.courselevelsoffered input[type=checkbox][value=${data}]`).prop("checked" , true);
                    }); 
                });

                $("#keycontactname").val(university.keycontactname);
                $("#keycontactemail").val(university.keycontactemail);
                $("#keycontactdesignation").val(university.keycontactdesignation);
                $("#yearestablishment").val(university.yearestablishment);
                $("#overview").val(university.overview);
                $("#maincampusstreetaddress").val(university.maincampusstreetaddress);
                $("#maincampuspostcode").val(university.maincampuspostcode);

                //Get the list of cities and then set the selected city
                getcities().then(function()
                {
                    //Set the main campus city
                    $(`#maincampuscity [value=${university.maincampuscityid}]`).prop("selected" , true);

                    //Hide the add other campus
                    $("#addothercampus").addClass("d-none");

                    //Populate the other campus details and fill in the data
                    othercampusaddresses.forEach(function(othercampusaddress)
                    {                        
                        $("#addothercampus").click();

                        let lastOtherCampus = $("#othercampusdetails .othercampus").last();

                        lastOtherCampus.find("input[name=othercampusstreetaddress]").val(othercampusaddress.othercampusstreetaddress);
                        lastOtherCampus.find("input[name=othercampuspostcode]").val(othercampusaddress.othercampuspostcode);
                        lastOtherCampus.find(`select[name=othercampuscity] [value=${othercampusaddress.othercampuscityid}]`).prop("selected" , true);

                        lastOtherCampus.find(".removeothercampus").addClass("d-none");
                    });
                });

                //If the file was uploaded, then display the view image link
                if(universityassets.logoimage != "")
                {
                    $("#viewlogoimage").removeClass("d-none");
                    $("#viewlogoimage").attr("href" , "../universitydata/" + university.universityid + "/" + universityassets.logoimage);
                    $("#viewlogoimage").attr("target" , "_blank");
                }

                //If the file was uploaded, then display the view image link
                if(universityassets.mascotimage != "")
                {
                    $("#viewmascotimage").removeClass("d-none");
                    $("#viewmascotimage").attr("href" , "../universitydata/" + university.universityid + "/" + universityassets.mascotimage);
                    $("#viewmascotimage").attr("target" , "_blank");
                }

                //Hide the add button for add other clubs and teams
                $("#addteamsandclubs").addClass("d-none");

                //Loop through all the clubs and teams and display them
                clubsandteams.forEach(function(clubandteam)
                {
                    $("#addteamsandclubs").click();

                    let lastClubAndTeam = $("#otherteamsandclubslist .otherteamsandclubs").last();
                    lastClubAndTeam.val(clubandteam);

                    //Hide the remove button for remove other clubs and teams
                    $(".removeteamsandclubs").remove();
                });

                //Hide the add button for add facility images
                $("#addfacilityimages").addClass("d-none");

                //Loop through all the facility images and display them
                facilityimages.forEach(function(facilityimage , index)
                {
                    $("#addfacilityimages").click();
                    $(".facilityimages").remove();

                    let lastFacilityImage = $("#facilityimageslist .viewfacilityimage").last();

                    lastFacilityImage.removeClass("d-none");
                    lastFacilityImage.text("Image " + (index + 1));
                    lastFacilityImage.attr("href" , "../universitydata/" + university.universityid + "/" + facilityimage);
                    lastFacilityImage.attr("target" , "_blank");

                    //Hide the remove facility images
                    $(".removefacilityimages").addClass("d-none");
                });

                //Disable the forms and checkboxes
                $("#universityinformationform *:not(#courselevelsdropdown)").prop("disabled" , true);
                $("input[type=checkbox]").prop("disabled" , true);
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response" + error.stack);
        }
    });
});