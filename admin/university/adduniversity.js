$(function()
{
    $("#universityinformationform").on("submit" , function(e)
    {
        e.preventDefault();

        let universityname = $("#universityname").val();
        let universitylicensenumber = $("#universitylicensenumber").val();
        let universityimage = $("#universityimage")[0].files[0];
        let courselevelsoffered = [];
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
        $("#othercampusdetails .othercampus").each(function()
        {
            let othercampusdetails = {};
            othercampusdetails.othercampusstreetaddress = $(this).find("input[name=othercampusstreetaddress]").val();
            othercampusdetails.othercampuscity = $(this).find("input[name=othercampuscity]").val();
            othercampusdetails.othercampuspostcode = $(this).find("input[name=othercampuspostcode]").val();
        
            othercampus.push(othercampusdetails);
        });

        let formData = new FormData();
        formData.append('universityinformation', 'universityinformation');
        formData.append('universityname', universityname);
        formData.append('universitylicensenumber', universitylicensenumber);
        formData.append('universityimage', universityimage);
        formData.append('courselevelsoffered', courselevelsoffered);
        formData.append('keycontactname', keycontactname);
        formData.append('keycontactemail', keycontactemail);
        formData.append('keycontactdesignation', keycontactdesignation);
        formData.append('yearestablishment', yearestablishment);
        formData.append('overview', overview);
        formData.append('maincampusstreetaddress', maincampusstreetaddress);
        formData.append('maincampuscity', maincampuscity);
        formData.append('maincampuspostcode', maincampuspostcode);
        formData.append('othercampus', othercampus);

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