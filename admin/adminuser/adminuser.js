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

        //Fetch the admin name and the status
        let adminname = $("#addadminname").val();
        let adminemail = $("#addadminemail").val();
        let adminpassword = $("#addadminpassword").val();
        let adminstatus = $("#addadminstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new admin
        $.post("../controllers/adminuser/addadminuser.php" , {"adminname":adminname , "adminemail":adminemail, "adminstatus":adminstatus , "adminpassword":adminpassword , "admintype":"admin"} , function(data)
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
                    alert("Admin User inserted successfully");

                    //Repopulate the admin user list
                    getadminuserlist();

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

        //Fetch the adminid , admin name, admin password and the status
        let adminid = $("#editadminid").val();
        let adminname = $("#editadminname").val();
        let adminemail = $("#editadminemail").val();
        let adminpassword = $("#editadminpassword").val();
        let adminstatus = $("#editadminstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the admin user
        $.post("../controllers/adminuser/editadminuser.php" , {"adminid":adminid , "adminname":adminname , "adminemail":adminemail , "adminpassword":adminpassword , "adminstatus":adminstatus , "admintype":"admin"} , function(data)
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
                    alert("Admin User updated successfully");

                    //Repopulate the admin user list
                    getadminuserlist();

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

    //Function for getting the list of admins from the server and populating the table
    function getadminuserlist()
    {
        $.get("../controllers/adminuser/getadminusers.php" , {"admintype":"admin"} , function(data)
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
                    $("#adminuserbody").html("");

                    //Loop through the admin user array and populate the table
                    for(let i=0; i<response.adminusers.length; i++)
                    {
                        let adminuser = response.adminusers[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${i+1}</th>
                            <td>${adminuser.adminname}</td>
                            <td>${adminuser.adminemail}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(adminuser.adminstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(adminuser.adminstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the country details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${adminuser.adminid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${adminuser.adminid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#adminuserbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editadminid").val(response.adminusers[index].adminid);
                        $("#editadminname").val(response.adminusers[index].adminname);
                        $("#editadminemail").val(response.adminusers[index].adminemail);
                        $("#editadminstatus").prop("checked" , response.adminusers[index].adminstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the admin user and return if user denied
                        if(confirm("Are you sure you want to delete this admin user?") == false)
                        {
                            return;
                        }

                        let adminid = $(this).attr("data-id");
                        $.post("../controllers/adminuser/deleteadminuser.php" , {"adminid":adminid} , function(data)
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
                                    alert("Admin User deleted successfully");

                                    //Repopulate the admin user list
                                    getadminuserlist();
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

    //Function for filling countries in the dropdown menu
    function fillcountries()
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
                    for(let i=0; i<response.countries.length; i++)
                    {
                        let country = response.countries[i];
                        $(".countrylist").append(`
                            <li>
                                <label class="dropdown-item">
                                    <input type="checkbox" value="${country.countryid}"> ${country.countryname}
                                </label>
                            </li>
                        `);
                    }
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    getadminuserlist();
    fillcountries();
});