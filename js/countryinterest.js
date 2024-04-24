$(function()
{
    //Function for getting country of interest
    function getcountryinterest()
    {
        $.ajax({
            url: "controllers/countryinterest/getcountryinterestmaster.php",
            type: "GET",
            data: {},
            async:false,
            success: function(data)
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        $(".error-msg").text(response.error);
                        if(response.login == true)
                        {
                            window.location.href = "login.php";
                        }
                    }
                    else
                    {
                        //Loop through the country list
                        for(let i=0; i<response.countries.length; i++)
                        {
                            let country = response.countries[i];

                            //Render the countries
                            $("#countries").append(`
                                <div class="formrow col-lg-3">
                                    <input class="checkbox" type="checkbox" id="country${country.countryid}" name="chkdesti[]" value="${country.countryid}">
                                    <label class="checklabel" for="country${country.countryid}" data-content="${country.countryname}">${country.countryname}</label>
                                </div>
                            `);
                        }

                        //Loop through the selected countries
                        for(let i=0; i<response.selectedcountries.length; i++)
                        {
                            let selectedcountry = response.selectedcountries[i];
                            
                            //Check the selected countries
                            $("#country"+selectedcountry).prop("checked" , true);
                        }
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    }

    getcountryinterest();

    $("#countryinterestform").on("submit" , function(e)
    {
        e.preventDefault();

        let formdata = new FormData(this);

        $.ajax({
            url: "controllers/countryinterest/updatecountryinterest.php",
            type: "POST",
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
                        $(".error-msg").text(response.error);
                        if(response.login == true)
                        {
                            window.location.href = "login.php";
                        }
                    }
                    else
                    {
                        //Redirect to the success page for edit profile
                        window.location.href = "editprofilesuccess.php";
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