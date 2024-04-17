$(function()
{
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
                            <button type="button" class="btn btn-danger delete" data-id="${student.studentid}"><i class="bi-trash"></i></button>
                        </td>`;

                        $("#studentbody").append(tr);
                    }
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