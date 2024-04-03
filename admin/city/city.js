$(function()
{
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

                    //Event for opening the edit modal on clicking the edit button
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
                        //Get the confirmation from the user for deleting the state and return if user denied
                        if(confirm("Are you sure you want to delete this state?") == false)
                        {
                            return;
                        }

                        let stateid = $(this).attr("data-id");
                        $.post("../controllers/state/deletestate.php" , {"stateid":stateid} , function(data)
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
                                    alert("State deleted successfully");

                                    //Repopulate the state list
                                    getstatelist();
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