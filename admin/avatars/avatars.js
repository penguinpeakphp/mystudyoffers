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

        let formdata = new FormData();

        formdata.append("avatarimage" , $("#addavatarimage").prop("files")[0]);
        formdata.append("avatarname" , $("#addavatarname").val());
        formdata.append("avatarstatus" , $("#addavatarstatus").prop("checked") ? 1 : 0);

        $.ajax
        ({
            url: "../controllers/avatars/addavatar.php",
            type: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
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
                        alert("Avatar inserted successfully");

                        //Repopulate the country list
                        getavatarlist();

                        //Close the modal
                        $("#addmodal").modal("hide");
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });

    $("#editform").on("submit" , function(e)
    {
        e.preventDefault(); 

        let formdata = new FormData();

        formdata.append("avatarid" , $("#editavatarid").val());
        formdata.append("avatarimage" , $("#editavatarimage").prop("files")[0]);
        formdata.append("avatarname" , $("#editavatarname").val());
        formdata.append("avatarstatus" , $("#editavatarstatus").prop("checked") ? 1 : 0);

        $.ajax
        ({
            url: "../controllers/avatars/editavatar.php",
            type: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                console.log(data);
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
                        alert("Avatar updated successfully");

                        //Repopulate the avatar list
                        getavatarlist();

                        //Close the modal
                        $("#editmodal").modal("hide");
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });

    //Function for getting the list of avatars from the server and populating the table
    function getavatarlist()
    {
        $.get("../controllers/avatars/getavatars.php" , {} , function(data)
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
                    $("#avatarbody").html("");

                    //Loop through the avatars array and populate the table
                    for(let i=0; i<response.avatars.length; i++)
                    {
                        let avatar = response.avatars[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${avatar.avatarid}</th>
                            <td>${avatar.avatarname}</td>
                            <td><img class="avatarimg" src="../avatarimages/${avatar.avatarimage}"></td>
                        `;
    
                        //Render badge based on the status flag
                        if(avatar.avatarstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(avatar.avatarstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the avatar details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${avatar.avatarid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${avatar.avatarid}" data-image="${avatar.avatarimage}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#avatarbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editavatarid").val(response.avatars[index].avatarid);
                        $("#editavatarname").val(response.avatars[index].avatarname);
                        $("#editavatarstatus").prop("checked" , response.avatars[index].avatarstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the avatar and return if user denied
                        if(confirm("Are you sure you want to delete this avatar?") == false)
                        {
                            return;
                        }

                        let avatarid = $(this).attr("data-id");
                        let avatarimage = $(this).attr("data-image");
                        $.post("../controllers/avatars/deleteavatar.php" , {"avatarid":avatarid , "avatarimage":avatarimage} , function(data)
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
                                    alert("Avatar deleted successfully");

                                    //Repopulate the avatar list
                                    getavatarlist();
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
    getavatarlist();
});