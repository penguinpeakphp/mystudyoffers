$(function()
{
    //Function for getting follow up of a student
    function getfollowups(studentid)
    {
        $("#followupbody").html("");
        //Make a get request for fetching student's follow ups
        $.get("../controllers/student/getfollowups.php" , {"studentid":studentid} , function(data)
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
                    //Loop through the followups and render the table
                    for(let i=0; i<response.followups.length; i++)
                    {
                        let followup = response.followups[i];
                        $("#followupbody").append(`
                            <tr>
                                <th scope="row">${followup.followup}</th>
                                <td>${followup.followupdate}</td>
                            </tr>
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

    //Function for getting student list
    function getstudentlist()
    {
        $.get("../controllers/student/getstudents.php" , {} , function(data)
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
                    //Loop through the student list and render the table
                    for(let i=0; i<response.students.length; i++)
                    {
                        let student = response.students[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${student.studentid}</th>
                            <td>${student.name}</td>
                            <td>${student.surname}</td>
                            <td>${student.phone}</td>
                            <td>${student.email}</td>
                            <td>${student.pincode}</td>
                        `;

                        if(student.status == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(student.status == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }

                        //Render buttons and have index in the data-index attribute to fetch the country details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-danger delete" data-studentid="${student.studentid}"><i class="bi-trash"></i></button>
                            <button type="button" class="btn btn-primary followup" data-studentid="${student.studentid}"><i class="bi-telephone-forward-fill"></i></button>
                        </td>`;

                        $("#studentbody").append(tr);
                    }

                    //Open Follow up modal on clicking the button
                    $(".followup").on("click" , function()
                    {
                        $("#followupmodal").modal("show");

                        //Extract student id from the attribute
                        let studentid = $(this).attr("data-studentid");

                        //Add studentid as attribute to the add follow up button
                        $("#addfollowup").attr("data-studentid" , studentid);

                        //Get the list of followups
                        getfollowups(studentid);
                    });

                    $("#addfollowupbtn").on("click" , function()
                    {
                        //Hide the follow up list modal
                        $("#followupmodal").modal("hide");

                        //Display the add follow up modal
                        $("#addfollowupmodal").modal("show");
                    });

                    $("#addfollowup").on("click" , function()
                    {
                        //Extract the student id from the attribute
                        let studentid = $(this).attr("data-studentid");
                        let followup = $("#followuptext").val();
                        $.post("../controllers/student/addfollowup.php" , {"studentid":studentid , "followup":followup} , function(data)
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
                                    //Get the list of followups
                                    getfollowups(studentid);

                                    //Refresh the followup text
                                    $("#followuptext").val("");

                                    //Hide the current modal
                                    $("#addfollowupmodal").modal("hide");

                                    //Show the follow up list modal after adding
                                    $("#followupmodal").modal("show");
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

    getstudentlist();
});