$(function()
{
    //Open Add Modal on clicking the Add Button
    $(".add").on("click" , function()
    {
        $("#addmodal").modal("show");
    });

    $("#addform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the country name and the status
        let countryname = $("#addcountryname").val();
        let status = $("#addstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new country
        $.post("../controllers/country/addcountry.php" , {"countryname":countryname , "status":status} , function(data)
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
                    //Alert the success message
                    alert("Country inserted successfully");

                    //Repopulate the country list
                    getcountrylist();

                    //Close the modal
                    $("#addmodal").modal("hide");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    });

    $("#editform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the countryid , country name and the status
        let countryid = $("#editcountryid").val();
        let countryname = $("#editcountryname").val();
        let status = $("#editstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the country
        $.post("../controllers/country/editcountry.php" , {"countryid":countryid , "countryname":countryname , "status":status} , function(data)
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
                    //Alert the success message
                    alert("Country updated successfully");

                    //Repopulate the country list
                    getcountrylist();

                    //Close the modal
                    $("#editmodal").modal("hide");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    });

    //Function for getting the list of countries from the server and populating the table
    function getcountrylist()
    {
        $.get("../controllers/country/getcountries.php" , {} , function(data)
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
                    //Reset the table body for repopulating the table
                    $("#countrybody").html("");

                    //Loop through the country array and populate the table
                    for(let i=0; i<response.countries.length; i++)
                    {
                        let country = response.countries[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${country.countryid}</th>
                            <td>${country.countryname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(country.status == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(country.status == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the country details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${country.countryid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${country.countryid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#countrybody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editcountryid").val(response.countries[index].countryid);
                        $("#editcountryname").val(response.countries[index].countryname);
                        $("#editstatus").prop("checked" , response.countries[index].status == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the country and return if user denied
                        if(confirm("Are you sure you want to delete this country?") == false)
                        {
                            return;
                        }

                        let countryid = $(this).attr("data-id");
                        $.post("../controllers/country/deletecountry.php" , {"countryid":countryid} , function(data)
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
                                    //Alert the success message
                                    alert("Country deleted successfully");

                                    //Repopulate the country list
                                    getcountrylist();
                                }
                            }
                            catch(error)
                            {
                                alert("Error occurred while trying to read server response");
                            }
                        });
                    });
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    //Populate the table for the first time
    getcountrylist();
});