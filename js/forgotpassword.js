$(function()
{
    //Extract get parameters using URLSearchParams
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const email = urlParams.get('email');
    const token = urlParams.get('token');

    $("#forgot-password").on("submit" , function(e)
    {
        e.preventDefault();

        let formdata = new FormData(this);
        formdata.append("email" , email);
        formdata.append("token" , token);
        $.ajax({
            url: "controllers/forgotpassword/updatepassword.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function(data)
            {
                try
                {
                    let response = JSON.parse(data);
                    if(response.success == false)
                    {
                        showalert(response.error);
                    }
                    else
                    {
                        showalert("Password updated successfully");
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response " + error);
                }
            }
        })
    })
})