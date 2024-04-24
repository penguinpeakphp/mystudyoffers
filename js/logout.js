$(function()
{
    //Make request to logout controller
    $(".logout").on("click" , function()
    {
        $.get("controllers/logout/logout.php" , {} , function(data)
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
                        window.location.href = "login.php";
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
        });
    });
})