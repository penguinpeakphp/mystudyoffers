//Global variable for storing the country and state list
let countries;
let states;
let academics;

//Function for populating the options in a select/option menu
function populatecountries(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Country</option>`);
    countries.forEach(function(country)
    {
        $(elementid).append(`
            <option value="${country.countryid}">${country.countryname}</option>
        `);
    });
}

//Function for populating the options in a select/option menu
function populatestates(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select State</option>`);
    states.forEach(function(state)
    {
        $(elementid).append(`
            <option value="${state.stateid}">${state.statename}</option>
        `);
    });
}

//Function for populating the options in a select/option menu
function populateacademics(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Academic Qualification</option>`);
    academics.forEach(function(academic)
    {
        $(elementid).append(`
            <option value="${academic.academicid}">${academic.academicname}</option>
        `)
    });
}