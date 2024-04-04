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

        //Fetch the city name , countryid , stateid and the status
        let cityname = $("#addcityname").val();
        let citystatus = $("#addcitystatus").prop("checked") ? 1 : 0;
        let stateid = $("#addstate").find(":selected").val();
        let countryid = $("#addcountry").find(":selected").val();

        //Send the post request for adding the new state
        $.post("../controllers/city/addcity.php" , {"cityname":cityname , "citystatus":citystatus , "stateid":stateid , "countryid":countryid} , function(data)
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
                    alert("City inserted successfully");

                    //Repopulate the state list
                    getcitylist();

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

        //Fetch the cityid , city name, city status, countryid and stateid
        let cityid = $("#editcityid").val();
        let cityname = $("#editcityname").val();
        let citystatus = $("#editcitystatus").prop("checked") ? 1 : 0;
        let countryid = $("#editcountry").find(":selected").val();
        let stateid = $("#editstate").find(":selected").val();

        //Send the post request for updating the country
        $.post("../controllers/city/editcity.php" , {"cityid":cityid , "cityname":cityname , "citystatus":citystatus , "countryid":countryid , "stateid":stateid} , function(data)
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
                    alert("City updated successfully");

                    //Repopulate the city list
                    getcitylist();

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

    function getcitylist()
    {
        $.get("../controllers/city/getcities.php" , {} , function(data)
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
                    //Assign country and state list to global variable for further use on this page
                    countries = response.countries;
                    states = response.states;

                    //Populate the select options in add and edit select
                    populatecountries("#addcountry");
                    populatecountries("#editcountry");
                    populatestates("#addstate");
                    populatestates("#editstate");

                    //Reset the table body for repopulating the table
                    $("#citybody").html("");

                    //Loop through the city array and populate the table
                    for(let i=0; i<response.cities.length; i++)
                    {
                        let city = response.cities[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${city.cityid}</th>
                            <td>${city.cityname}</td>
                            <td>${city.statename}</td>
                            <td>${city.countryname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(city.citystatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(city.citystatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the city details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${city.cityid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${city.cityid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#citybody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit buttonht
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editcityid").val(response.cities[index].stateid);
                        $("#editcityname").val(response.cities[index].cityname);
                        $("#editcitystatus").prop("checked" , response.cities[index].citystatus == "1" ? true : false);
                        $(`#editcountry option[value='${response.cities[index].countryid}']`).prop("selected" , true);
                        $(`#editstate option[value='${response.cities[index].stateid}']`).prop("selected" , true);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the city and return if user denied
                        if(confirm("Are you sure you want to delete this city?") == false)
                        {
                            return;
                        }

                        let cityid = $(this).attr("data-id");
                        $.post("../controllers/city/deletecity.php" , {"cityid":cityid} , function(data)
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
                                    alert("City deleted successfully");

                                    //Repopulate the city list
                                    getcitylist();
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

    getcitylist();
});