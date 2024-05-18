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
                let university = response.university;
                $("#universitystatus").prop("checked" , university.universitystatus);
                $("#universityname").val(university.universityname);
                $("#universitylicensenumber").val(university.universitylicensenumber);
                
                let courselevelsoffered = response.universitylevelofcourses;
                
                courselevelsoffered.forEach(function(data)
                {
                    $(`.courselevelsoffered input[type=checkbox][value=data]`).prop("checked" , true);
                });

                $("#keycontactname").val(university.keycontactname);
                $("#keycontactemail").val(university.keycontactemail);
                $("#keycontactdesignation").val(university.keycontactdesignation);
                $("#yearestablishment").val(university.yearestablishment);
                $("#overview").val(university.overview);
                $("#maincampusstreetaddress").val(university.maincampusstreetaddress);
                $("#maincampuspostcode").val(university.maincampuspostcode);
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
});