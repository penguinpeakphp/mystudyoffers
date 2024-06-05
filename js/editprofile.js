$(function()
{
    $(".currentpage").text("Edit Profile");
    
    function getstudentdata()
    {
        $.ajax({
            type: "POST",
            url: "controllers/student/getstudentdata.php",
            processData: false,
            contentType: false,
            success: function(data)
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        showalert(response.error);
                        if(response.login == true)
                        {
                            window.location.href = "login.php";
                        }
                    }
                    else
                    {
                        //Set the data received from the server
                        $("#editname").val(response.studentdata.name);
                        $("#editemail").val(response.studentdata.email);
                        $("#editphone").val(response.studentdata.phone);
                        $("#editpincode").val(response.studentdata.pincode);
                        $("#editsurname").val(response.studentdata.surname);
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    }

    getstudentdata();

    $('#editprofilepic').change(function(event) 
    {
        let input = event.target;
        let reader = new FileReader();
        reader.onload = function() 
        {
            let dataURL = reader.result;
            $('#viewprofilepic').attr('src', dataURL);
        };
        if (input.files && input.files[0]) 
        {
            reader.readAsDataURL(input.files[0]);
        }
    });
    
    $("#editprofile").on("submit", function(e)
    {
        e.preventDefault();

        let formdata = new FormData(this);
        formdata.append("oldprofilepic" , $(".profilepic").get(0).src.split("/").pop());
        $.ajax({
            type: "POST",
            url: "controllers/student/updateprofile.php",
            data: formdata,
            processData: false,
            contentType: false,
            success: function(data)
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        showalert(response.error);
                        if(response.login == true)
                        {
                            window.location.href = "login.php";
                        }
                    }
                    else
                    {
                        showalert("Your Profile updated successfully");

                        $("#alertModal").on("hidden.bs.modal" , function()
                        {
                            window.location.href = "dashboard.php";
                        });
                    }                       
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
        getstudentdata();
    });
})