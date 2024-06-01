$(function()
{
    $(".currentpage").text("Change Password");

    $("#changepassword").on("submit", function(e)
    {
        e.preventDefault();

        let formdata = new FormData(this);
        $.ajax({
            type: "POST",
            url: "controllers/student/changepassword.php",
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
                        showalert(response.message);
                        $("npassword").val("");
                        $("cpassword").val("");

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
    });
});