//------------------------------------------------------------------------------------------
function validate_form(table_name, table_settings, values) {
//------------------------------------------------------------------------------------------
    // Example validation to check whether the location name is at least 5 characters long
    if(table_name == 'locations' && (!values.title || !values.title.length || values.title.length < 5))
        return { title: 'The title is too short! It must be at least 5 characters long.' };

    return null;
}
