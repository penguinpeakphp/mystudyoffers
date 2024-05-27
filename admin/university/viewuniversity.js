$(function()
{
    //Fetch the get parameters from the url
    let params = new URLSearchParams(window.location.search);
    let universityid = params.get("view");
    let isedit = params.get("edit");

    if(isedit != "edit")
    {
        //Remove all the submit buttons from the page
        $("button[type=submit]").remove();   
    }

    $.get("../controllers/university/getuniversitydata.php" , {"universityid" : universityid} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            console.log(response);

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
                let universityaccreditations = response.universityaccreditations;
                let universityrankings = response.universityrankings;
                let universitystatistics = response.universitystatistics;
                let universityfees = response.universityfees;
                let universityotherfees = response.universityotherfees;
                let universityfinancialaids = response.universityfinancialaids;

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

                $("#totalstudents").val(university.totalstudents);

                //Hide the add buttons
                if(isedit != "edit")
                {
                    $("#addothercampus").addClass("d-none");
                    $("#addteamsandclubs").addClass("d-none");
                    $("#addotherrankings").addClass("d-none");
                    $("#addfacilityimages").addClass("d-none");   
                }

                //Hide the remove buttons
                if(isedit != "edit")
                {
                    $(".removeotherranking").addClass("d-none");
                    $(".removefacilityimages").addClass("d-none");
                    $(".removeteamsandclubs").addClass("d-none");
                    $(".removeothercampus").addClass("d-none");
                }


                //Get the list of cities and then set the selected city
                getcities().then(function()
                {
                    //Set the main campus city
                    $(`#maincampuscity [value=${university.maincampuscityid}]`).prop("selected" , true);

                    //Populate the other campus details and fill in the data
                    othercampusaddresses.forEach(function(othercampusaddress)
                    {                        
                        $("#addothercampus").click();

                        let lastOtherCampus = $("#othercampusdetails .othercampus").last();

                        lastOtherCampus.find("input[name=othercampusstreetaddress]").val(othercampusaddress.othercampusstreetaddress);
                        lastOtherCampus.find("input[name=othercampuspostcode]").val(othercampusaddress.othercampuspostcode);
                        lastOtherCampus.find(`select[name=othercampuscity] [value=${othercampusaddress.othercampuscityid}]`).prop("selected" , true);
                    });
                });

                if(universityassets != null)
                {
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
                }
                

                //Loop through all the clubs and teams and display them
                clubsandteams.forEach(function(clubandteam)
                {
                    $("#addteamsandclubs").click();

                    let lastClubAndTeam = $("#otherteamsandclubslist .otherteamsandclubs").last();
                    lastClubAndTeam.val(clubandteam);
                });

                //Loop through all the facility images and display them
                facilityimages.forEach(function(facilityimage , index)
                {
                    $("#addfacilityimages").click();
                    $("#facilityimageslist .facilityimages").remove();

                    let lastFacilityImage = $("#facilityimageslist .viewfacilityimage").last();

                    lastFacilityImage.removeClass("d-none");
                    lastFacilityImage.text("Image " + (index + 1));
                    lastFacilityImage.attr("href" , "../universitydata/" + university.universityid + "/" + facilityimage);
                    lastFacilityImage.attr("target" , "_blank");
                });

                //Get the list of accreditations and then set the selected accreditations
                getaccreditations().then(function()
                {
                    universityaccreditations.forEach(function(accreditation)
                    {
                        $(`.accreditationstatus input[type=checkbox][value=${accreditation.accreditationid}]`).prop("checked" , true);
                    });
                });

                getrankawardingbodies().then(function()
                {
                    //Loop through all the rankings and display them
                    universityrankings.forEach(function(ranking)
                    {
                        $("#addotherrankings").click();

                        let lastRanking = $("#otherrankingslist .otherrankings").last();

                        lastRanking.find("input[name=nameofranking]").val(ranking.rankingname);
                        lastRanking.find("input[name=yearofranking]").val(ranking.yearofranking);
                        lastRanking.find(`select[name=rankawardingbodies] [value=${ranking.rankawardingbodyid}]`).prop("selected" , true);
                        lastRanking.find("textarea[name=description]").val(ranking.description);
                    });
                });

                //Set the statistics data of the university
                if(universitystatistics != null)
                {
                    $("#totalstudents").val(universitystatistics.totalstudents);
                    $("#totalinternationalstudents").val(universitystatistics.totalinternationalstudents);
                    $("#acceptancerate").val(universitystatistics.acceptancerate);
                    $("#graduateemploymentrate").val(universitystatistics.graduateemploymentrate);
                }

                //Set the university fees for the university
                if(universityfees != null)
                {
                    $("#applicationfee").val(universityfees.applicationfee);
                    $("#tuitionfee").val(universityfees.tuitionfee);
                }

                //Get the other fees and then set the selected other fees
                getotherfees().then(function()
                {
                    universityotherfees.forEach(function(otherfee)
                    {
                        $(`.otherfees input[type=checkbox][value=${otherfee.otherfeeid}]`).prop("checked" , true);
                    });
                });

                //Get the financial aid and then set the selected financial aid
                getfinancialaids().then(function()
                {
                    universityfinancialaids.forEach(function(financialaid)
                    {
                        $(`.financialaid input[type=checkbox][value=${financialaid.financialaidid}]`).prop("checked" , true);
                    });
                });

                if(isedit != "edit")
                {
                    //Disable the forms and checkboxes
                    $("#universityinformationform *:not(#courselevelsdropdown)").prop("disabled" , true);
                    $("#universityintellectualassets *").prop("disabled" , true);
                    $("#universityrankings *:not(#accreditationstatus)").prop("disabled" , true);
                    $("#universitystatistics *").prop("disabled" , true);
                    $("#tuitionandfees *:not(#otherfeesdropdown, #financialaiddropdown)").prop("disabled" , true);
                    $("input[type=checkbox]").prop("disabled" , true);   
                }
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
});