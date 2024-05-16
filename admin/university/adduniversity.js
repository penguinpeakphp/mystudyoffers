$(function()
{
    let universityid = "";

    $("#universityinformationform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
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

        let rankings = [];
        $("#otherrankingslist .otherrankings").each(function()
        {
            let rankawardingbody = {};
            $(this).find("input[name=nameofranking]").val();
            $(this).find("select[name=rankawardingbodies]").val();
            $(this).find("input[name=yearofranking]").val();
            $(this).find("input[name=description]").val();

        });
    });
})