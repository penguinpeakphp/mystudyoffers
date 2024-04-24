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

        //Fetch the state name , countryid and the status
        let statename = $("#addstatename").val();
        let statestatus = $("#addstatestatus").prop("checked") ? 1 : 0;
        let countryid = $("#addcountry").find(":selected").val();

        //Send the post request for adding the new state
        $.post("../controllers/state/addstate.php" , {"statename":statename , "statestatus":statestatus , "countryid":countryid} , function(data)
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
                    alert("State inserted successfully");

                    //Repopulate the state list
                    getstatelist();

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

        //Fetch the stateid , state name, state status and countryid
        let stateid = $("#editstateid").val();
        let statename = $("#editstatename").val();
        let statestatus = $("#editstatestatus").prop("checked") ? 1 : 0;
        let countryid = $("#editcountry").find(":selected").val();

        //Send the post request for updating the country
        $.post("../controllers/state/editstate.php" , {"stateid":stateid , "statename":statename , "statestatus":statestatus , "countryid":countryid} , function(data)
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
                    alert("State updated successfully");

                    //Repopulate the state list
                    getstatelist();

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

    //Function for getting the list of states from the server and populating the table
    function getstatelist()
    {
        $.get("../controllers/state/getstates.php" , {} , function(data)
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
                    //Assign country list to global variable for further use on this page
                    countries = response.countries;

                    //Populate the select options in add and edit select
                    populatecountries("#addcountry");
                    populatecountries("#editcountry");

                    //Reset the table body for repopulating the table
                    $("#statebody").html("");

                    //Loop through the state array and populate the table
                    for(let i=0; i<response.states.length; i++)
                    {
                        let state = response.states[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${state.stateid}</th>
                            <td>${state.statename}</td>
                            <td>${state.countryname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(state.statestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(state.statestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the state details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${state.stateid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${state.stateid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#statebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editstateid").val(response.states[index].stateid);
                        $("#editstatename").val(response.states[index].statename);
                        $("#editstatestatus").prop("checked" , response.states[index].statestatus == "1" ? true : false);
                        $(`#editcountry option[value='${response.states[index].countryid}']`).prop("selected" , true);
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

    getstatelist();
});