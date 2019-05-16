$(document).ready( function()
{
    var form_edit_user = $('#form_edit_user')

    formValidateTracking( form_edit_user , 10 )

	$(".active_users_button").addClass("active")

    ////////////// MASK ///////////

    $("#form_control_cellphone").inputmask("mask", {
        "mask": "(999) 999-9999"
    });

    //////////// END MASK /////////
    //////////// SELECT ///////////

    $('#user_types_id').select2({
        placeholder : 'Seleccione el tipo de usuario' ,
        width       : '100%'
    });

    //////////// END SELECT ///////
})

$("#open_modal_status_user").click( function()
{
	$("#modal_status_user").modal({
		backdrop : 'static' ,
		keyboard : false
	});
})

$("#change_status_user").click( function()
{
	$("#form_status_user").submit()
})

$("#save_edit_user").click( function()
{
	$("#form_edit_user").submit()
})

$("#change_image_user").click( function()
{
	var img = $("#img_user").val()

	if (img != '') {
		$("#form_image_user").submit()
	}
})

function saveEditUser( data_form )
{
    var boton  = $("#save_edit_user")
    var url    = "/users/" + $("#user_id").val()
    var method = "put"

    boton.button('loading');

    var result_edit_user = requestAjax( url , method , data_form )

    result_edit_user.then( function( response )
    {
        boton.button('reset');

        refreshLabels()

        notifications( response.msg , 'success' )
    } ,
    function( error )
    {
        boton.button('reset');

        var type_msg = 'error'

        if (error.responseJSON.type == 2) {
            type_msg = 'info'
        }

        notifications( error.responseJSON.msg , type_msg )
    })
}

function refreshLabels()
{
    $(".user_name_label").text( $("#form_control_name").val() )
    $(".user_position_label").text( $("#positions_id option:selected").text() )
    $("#form_control_password").val("")
}