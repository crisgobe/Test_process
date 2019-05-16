$("#open_modal_new_user").click( function()
{
	clearDataNewUser()
	
	$("#modal_new_user").modal({
		backdrop : 'static' ,
		keyboard : false
	});

	setTimeout( function()
	{
		$("#form_control_name_user").focus()
	} , 200)
})

function clearDataNewUser()
{
	$("#form_new_user")[0].reset()

	var validator = $("#form_new_user").validate();
	validator.resetForm();
	
	$('.select2-multiple').val(null).trigger('change');
}

$("#save_new_user").click( function()
{
	$("#form_new_user").submit()
})

function saveNewUser( data_form )
{
	var boton  = $("#save_new_user")
	var url    = "users"
	var method = "post"

	boton.button('loading');

	var result_new_user = requestAjax( url , method , data_form )

    result_new_user.then( function( response )
    {
    	boton.button('reset');

    	$("#modal_new_user").modal('hide')

    	clearListTableUser()

    	notifications( response.msg , 'success' )
    } ,
    function( error )
    {
    	boton.button('reset');

    	notifications( error.responseJSON.msg , 'error' )
    })
}