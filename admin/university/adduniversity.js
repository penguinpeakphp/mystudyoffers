$(function()
{
    let universityid = "";

    $("#universityinformationform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the data from the fields
        let universityname = $("#universityname").val();
        let universitylicensenumber = $("#universitylicensenumber").val();
        let universityimage = $("#universityimage")[0].files[0];
        let courselevelsoffered = [];

        //Loop through the course level elements and push the value into the array
        $(".courselevelsoffered input[type=checkbox]:checked").each(function()
        {
            courselevelsoffered.push($(this).val());
        });
        let keycontactname = $("#keycontactname").val();
        let keycontactemail = $("#keycontactemail").val();
        let keycontactdesignation = $("#keycontactdesignation").val();
        let yearestablishment = $("#yearestablishment").val();
        let overview = $("#overview").val();
        let maincampusstreetaddress = $("#maincampusstreetaddress").val();
        let maincampuscity = $("#maincampuscity").val();
        let maincampuspostcode = $("#maincampuspostcode").val();

        let othercampus = [];
        //Create an object for storing other campus details and push the data into the array
        $("#othercampusdetails .othercampus").each(function()
        {
            let othercampusdetails = {};
            othercampusdetails.othercampusstreetaddress = $(this).find("input[name=othercampusstreetaddress]").val();
            othercampusdetails.othercampuscity = $(this).find("select[name=othercampuscity]").val();
            othercampusdetails.othercampuspostcode = $(this).find("input[name=othercampuspostcode]").val();
        
            othercampus.push(othercampusdetails);
        });

        //Append all the data in the form data
        let formData = new FormData();
        formData.append("universityid" , universityid);
        formData.append('universityinformation', 'universityinformation');
        formData.append('universityname', universityname);
        formData.append('universitylicensenumber', universitylicensenumber);
        formData.append('universityimage', universityimage);
        formData.append('courselevelsoffered', JSON.stringify(courselevelsoffered));
        formData.append('keycontactname', keycontactname);
        formData.append('keycontactemail', keycontactemail);
        formData.append('keycontactdesignation', keycontactdesignation);
        formData.append('yearestablishment', yearestablishment);
        formData.append('overview', overview);
        formData.append('maincampusstreetaddress', maincampusstreetaddress);
        formData.append('maincampuscity', maincampuscity);
        formData.append('maincampuspostcode', maincampuspostcode);
        formData.append('othercampus', JSON.stringify(othercampus));

        //Make an ajax call for adding the university
        $.ajax({
            url: "../controllers/university/adduniversity.php",
            type: 'POST',
            data: formData,
            success: function (data) 
            {
                console.log(data);
            },
            processData: false,
            contentType: false
        });
    });
})