$(function()
{   
    //Prime the page with data
    getcities();
    getlevelofcourses();
    getotherfees();
    getfinancialaids();
    getaccreditations();
    getrankawardingbodies();


    //Extract get parameters from URL
    let params = new URLSearchParams(window.location.search);
    let isedit = params.get("edit");
    let universityid = params.get("view");

    if(isedit == "edit")
    {
        $("button[type=submit]").text("Edit");   
    }

    let controller;
    let universitydatastatus;

    async function getuniversitydatastatus()
    {
        await $.get("../controllers/university/getuniversitydatastatus.php" , {"universityid":universityid} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);
                }
                else
                {
                    universitydatastatus = response.universitydatastatus;  
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    $("#universityinformationform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
        let universitystatus = $("#universitystatus").prop("checked") ? 1 : 0;
        let universityname = $("#universityname").val();
        let universitylicensenumber = $("#universitylicensenumber").val();
        let universityimage = $("#universityimage")[0].files[0];
        let courselevelsoffered = [];

        //Loop through the course level elements and push the value into the array
        $(".courselevelsoffered input[type=checkbox]:checked").each(function()
        {
            courselevelsoffered.push($(this).val());
        });
        let keycontactname = $("#keycontactname").val();
        let keycontactemail = $("#keycontactemail").val();
        let keycontactdesignation = $("#keycontactdesignation").val();
        let yearestablishment = $("#yearestablishment").val();
        let overview = $("#overview").val();
        let maincampusstreetaddress = $("#maincampusstreetaddress").val();
        let maincampuscity = $("#maincampuscity").val();
        let maincampuspostcode = $("#maincampuspostcode").val();

        let othercampus = [];
        //Create an object for storing other campus details and push the data into the array
        $("#othercampusdetails .othercampus").each(function()
        {
            let othercampusdetails = {};
            othercampusdetails.othercampusstreetaddress = $(this).find("input[name=othercampusstreetaddress]").val();
            othercampusdetails.othercampuscity = $(this).find("select[name=othercampuscity]").val();
            othercampusdetails.othercampuspostcode = $(this).find("input[name=othercampuspostcode]").val();
        
            othercampus.push(othercampusdetails);
        });

        //Append all the data in the form data
        let formData = new FormData();
        formData.append("universitystatus" , universitystatus);
        formData.append("universityid" , universityid);
        formData.append('universityinformation', 'universityinformation');
        formData.append('universityname', universityname);
        formData.append('universitylicensenumber', universitylicensenumber);
        if(universityimage)
        {
            formData.append('universityimage', universityimage);
        }
        formData.append('courselevelsoffered', JSON.stringify(courselevelsoffered));
        formData.append('keycontactname', keycontactname);
        formData.append('keycontactemail', keycontactemail);
        formData.append('keycontactdesignation', keycontactdesignation);
        formData.append('yearestablishment', yearestablishment);
        formData.append('overview', overview);
        formData.append('maincampusstreetaddress', maincampusstreetaddress);
        formData.append('maincampuscity', maincampuscity);
        formData.append('maincampuspostcode', maincampuspostcode);
        formData.append('othercampus', JSON.stringify(othercampus));

        getuniversitydatastatus().then(function()
        {
            if(universitydatastatus != null)
            {
                //Get the filename from href tag
                let imagename = $("#viewuniversityimage").attr("href").split("/").pop();

                formData.append("olduniversityimagename" , imagename);

                controller = "edituniversity.php";
            }
            else
            {
                controller = "adduniversity.php";
                formData.set("universityid" , "");
            }


            //Make an ajax call for adding the university
            $.ajax({
                url: `../controllers/university/${controller}`,
                type: 'POST',
                data: formData,
                success: function(data) 
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
                            universityid = response.universityid;
                            alert("University data added successfully");
                            if(isedit != "edit")
                            {
                                $("#universityinformationform *").prop("disabled" , true);   
                            }
                        }
                    }
                    catch(error)
                    {
                        alert("Error occurred while trying to read server response");
                    }
                },
                processData: false,
                contentType: false
            });
        });
    });

    $("#universityintellectualassets").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
        let logoimage = $("#logoimage")[0].files[0];
        let mascotimage = $("#mascotimage")[0].files[0];

        //Loop through the other teams and clubs elements and push the value into the array
        let otherteamsandclubs = [];
        $("#otherteamsandclubslist .otherteamsandclubs").each(function()
        {
            otherteamsandclubs.push($(this).val());
        });
        
        //Loop through the facility images and push the value into the array
        let facilityimages = [];
        $("#facilityimageslist .facilityimages").each(function()
        {
            facilityimages.push($(this)[0].files[0]);
        });

        let formData = new FormData(this);
        formData.append('universityid' , universityid);
        formData.append("universityintellectualassets", "universityintellectualassets");
        if(logoimage)
        {
            formData.append('logoimage', logoimage);
        }
        if(mascotimage)
        {
            formData.append('mascotimage', mascotimage);   
        }
        formData.append('otherteamsandclubs', JSON.stringify(otherteamsandclubs));
        // Append the array of files
        facilityimages.forEach(function(file) 
        {
            formData.append('facilityimages[]', file);
        });

        getuniversitydatastatus().then(function()
        {
            controller = universitydatastatus.universityassets ? "edituniversity.php" : "adduniversity.php";  

            if(controller == "edituniversity.php")
            {
                let i = 0;
                $("#facilityimageslist .viewfacilityimage").each(function()
                {
                    if(!$(this).hasClass("d-none"))
                    {
                        i++;
                    }
                });
                console.log(i);
                formData.append("oldfacilityimagecount" , i);
                
                //Check if the href attribute is there or not
                if($("#viewlogoimage").attr("href") != "javascript:void(0)")
                {
                    formData.append("oldlogoimagename" , $("#viewlogoimage").attr("href").split("/").pop());
                }
                else
                {
                    formData.append("oldlogoimagename" , "");
                }

                if($("#viewmascotimage").attr("href") != "javascript:void(0)")
                {
                    formData.append("oldmascotimagename" , $("#viewmascotimage").attr("href").split("/").pop());
                }
                else
                {
                    formData.append("oldmascotimagename" , "");
                }
            }

            //Make an ajax call for adding the university
            $.ajax({
                url: `../controllers/university/${controller}`,
                type: 'POST',
                data: formData,
                success: function(data) 
                {
                    console.log(data);
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
                            alert("University data added successfully");
                            if(isedit != "edit")
                            {
                                $("#universityintellectualassets *").prop("disabled" , true);
                            }
                        }
                    }
                    catch(error)
                    {
                        alert("Error occurred while trying to read server response");
                    }
                },
                processData: false,
                contentType: false
            });
        });
    }); 

    $("#universityrankings").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
        let accreditations = [];
        //Loop through the course level elements and push the value into the array
        $(".accreditationstatus input[type=checkbox]:checked").each(function()
        {
            accreditations.push($(this).val());
        });

        //Loop through the ranking list and push the object into the array
        let rankings = [];
        $("#otherrankingslist .otherrankings").each(function()
        {
            let ranking = {};
            ranking.rankingname = $(this).find("input[name=nameofranking]").val();
            ranking.rankawardingbody = $(this).find("select[name=rankawardingbodies]").val();
            ranking.yearofranking = $(this).find("input[name=yearofranking]").val();
            ranking.description = $(this).find("textarea[name=description]").val();

            rankings.push(ranking);
        });

        //Create the formdata and append data to it
        let formData = new FormData();
        formData.append('universityid' , universityid);
        formData.append("universityrankings", "universityrankings");
        formData.append('accreditations', JSON.stringify(accreditations));
        formData.append('rankings', JSON.stringify(rankings));

        getuniversitydatastatus().then(function()
        {
            controller = universitydatastatus.universityrankings ? "edituniversity.php" : "adduniversity.php";

            //Make an ajax call for adding the university data
            $.ajax({
                url: `../controllers/university/${controller}`,
                type: 'POST',
                data: formData,
                success: function(data) 
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
                            alert("University data added successfully");
                            if(isedit != "edit")
                            {
                                $("#universityrankings *").prop("disabled" , true);
                            }
                        }
                    }
                    catch(error)
                    {
                        alert("Error occurred while trying to read server response");
                    }
                },
                processData: false,
                contentType: false
            });
        });
    });

    $("#universitystatistics").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
        let totalstudents = $("#totalstudents").val();
        let totalinternationalstudents = $("#totalinternationalstudents").val();
        let acceptancerate = $("#acceptancerate").val();
        let graduateemploymentrate = $("#graduateemploymentrate").val();

        //Create the formdata and append data to it
        let formData = new FormData(this);
        formData.append('universityid' , universityid);
        formData.append("universitystatistics", "universitystatistics");
        formData.append('totalstudents', totalstudents);
        formData.append('totalinternationalstudents', totalinternationalstudents);
        formData.append('acceptancerate', acceptancerate);
        formData.append('graduateemploymentrate', graduateemploymentrate);

        getuniversitydatastatus().then(function()
        {
            controller = universitydatastatus.universitystatistics ? "edituniversity.php" : "adduniversity.php";
            
            //Make an ajax call for adding the university data
            $.ajax({
                url: `../controllers/university/${controller}`,
                type: 'POST',
                data: formData,
                success: function(data) 
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
                            alert("University data added successfully");
                            if(isedit != "edit")
                            {
                                $("#universitystatistics *").prop("disabled" , true);
                            }
                        }
                    }
                    catch(error)
                    {
                        alert("Error occurred while trying to read server response");
                    }
                },
                processData: false,
                contentType: false
            }); 
        });
    });

    $("#tuitionandfees").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
        let applicationfee = $("#applicationfee").val();
        let tuitionfee = $("#tuitionfee").val();

        let otherfees = [];
        let financialaids = [];

        //Loop through the other fees and push the data into the array
        $(".otherfees input[type=checkbox]:checked").each(function()
        {
            otherfees.push($(this).val());
        });

        //Loop through the financial aid and push the data into the array
        $(".financialaid input[type=checkbox]:checked").each(function()
        {
            financialaids.push($(this).val());
        });

        //Create the formdata and append data to it
        let formData = new FormData(this);
        formData.append('universityid' , universityid);
        formData.append("tuitionandfees", "tuitionandfees");
        formData.append('applicationfee', applicationfee);
        formData.append('tuitionfee', tuitionfee);
        formData.append('otherfees', JSON.stringify(otherfees));
        formData.append('financialaids', JSON.stringify(financialaids));

        getuniversitydatastatus().then(function()
        {
            controller = universitydatastatus.universitytuitionandfees ? "edituniversity.php" : "adduniversity.php";

            //Make an ajax call for adding the university data
            $.ajax({
                url: `../controllers/university/${controller}`,
                type: 'POST',
                data: formData,
                success: function(data) 
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
                            alert("University data added successfully");
                            if(isedit != "edit")
                            {
                                $("#tuitionandfees *").prop("disabled" , true);
                            }
                        }
                    }
                    catch(error)
                    {
                        alert("Error occurred while trying to read server response");
                    }
                },
                processData: false,
                contentType: false
            });
        });        
    });
})