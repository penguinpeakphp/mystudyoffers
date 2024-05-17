$(function()
{
    let universityid = "";

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

        //Make an ajax call for adding the university
        $.ajax({
            url: "../controllers/university/adduniversity.php",
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
                        universityid = response.universityid;
                        alert("University added successfully");
                        $("#universityinformationform *").prop("disabled" , true);
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

        //Make an ajax call for adding the university
        $.ajax({
            url: "../controllers/university/adduniversity.php",
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
                        $("#universityintellectualassets *").prop("disabled" , true);
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

        //Make an ajax call for adding the university data
        $.ajax({
            url: "../controllers/university/adduniversity.php",
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
                        $("#universityrankings *").prop("disabled" , true);
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

        //Make an ajax call for adding the university data
        $.ajax({
            url: "../controllers/university/adduniversity.php",
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
                        $("#universitystatistics *").prop("disabled" , true);
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

        //Make an ajax call for adding the university data
        $.ajax({
            url: "../controllers/university/adduniversity.php",
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
                        $("#tuitionandfees *").prop("disabled" , true);
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
})