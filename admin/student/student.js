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
                                <th scope="row">${followup.followupid}</th>
                                <td>${followup.remarks}</td>
                                <td>${followup.followuptemplatename}</td>
                                <td>${followup.followuptemplatebody}</td>
                                <td>${followup.noteaddedon}</td>
                                <td>${followup.nextfollowupdate}</td>
                            </tr>
                        `);
                    }

                    //Declare variable for storing template bodies
                    let templatebodies = [];

                    $("#followuptemplatelist").html("<option selected disabled value=''>Select Template</option>");
                    //Loop through the followup templates and render the table
                    for(let i=0; i<response.followuptemplates.length; i++)
                    {
                        let followuptemplate = response.followuptemplates[i];
                        $("#followuptemplatelist").append(`
                            <option value="${followuptemplate.followuptemplateid}">${followuptemplate.followuptemplatename}</option>
                        `);

                        templatebodies[followuptemplate.followuptemplateid] = followuptemplate.followuptemplatebody;
                    }

                    //Fill the template body text area on changing the select option
                    $("#followuptemplatelist").on("change" , function()
                    {
                        $("#followuptemplatebody").val(templatebodies[$(this).val()]);
                    });
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
        $("#studentbody").html("");
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
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary telecallerbtn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ${student.telecallername}
                                    </button>
                                    <div class="dropdown-menu telecallerlist" data-studentid=${student.studentid}>
                                    </div>
                                </div>
                            </td>
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
                            <button type="button" class="btn btn-primary followup" data-studentid="${student.studentid}"><i class="bi-telephone-forward-fill"></i></button>
                        </td>`;

                        $("#studentbody").append(tr);
                    }

                    $.get("../controllers/adminuser/getadminusers.php" , {"admintype":"telecaller"} , function(data)
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
                                for(let i=0; i<response.adminusers.length; i++)
                                {
                                    let adminuser = response.adminusers[i];
                                    $(".telecallerlist").append(`
                                        <a class="dropdown-item" href="javascript:void(0)" data-adminid="${adminuser.adminid}">${adminuser.adminname}</a>
                                    `);
                                }

                                $(".telecallerlist .dropdown-item").on("click" , function()
                                {
                                    if(!confirm("Are you sure you want to change the assigned telecaller?"))
                                    {
                                        return;
                                    }
                                    let adminid = $(this).attr("data-adminid");
                                    let studentid = $(this).parent().attr("data-studentid");

                                    let thiselement = $(this);
                                    
                                    $.post("../controllers/student/editstudent.php" , {"action":"changetelecaller" , "adminid":adminid , "studentid":studentid} , function(data) 
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
                                                $(".telecallerlist .dropdown-item").parent().siblings().get(0).textContent = thiselement.text();
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

                    //Initialize data table
                    $("#studenttable").DataTable({
                        dom: '<"top-controls"fl>tp'
                    });

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
                        let remarks = $("#remarks").val();
                        let followuptemplatebody = $("#followuptemplatebody").val();                        
                        let followuptemplateid = $("#followuptemplatelist :selected").val();
                        let nextfollowupdate = $("#nextfollowupdate").val();

                        $.post("../controllers/student/addfollowup.php" , {"studentid":studentid , "remarks":remarks , "nextfollowupdate":nextfollowupdate , "followuptemplatebody":followuptemplatebody , "followuptemplateid":followuptemplateid} , function(data)
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
                                    $("#remarks").val("");
                                    $("#nextfollowupdate").val("");

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