$(document).ready( function()
{
    var today = new Date()

    $("#date_range").daterangepicker({
        minDate : today
    });

	$(".active_orders_button").addClass("active")
	// $("#table_product_locations_list").DataTable();

	var timeout;
    var delay = 500;

	tableProductLocation()

	$('input.form_filter_location').on( 'keyup' , function()
    {
        var i = $(this).parents('td').attr('data-column');

        if (timeout) {
            clearTimeout( timeout );
        }

        timeout = setTimeout( function()
        {
            filterColumnLocationsList( i );
        } , delay);
    });

    $("#col2_filter_location").on( "change" , function()
    {
        filterColumnLocationsList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });
})

var filterColumnLocationsList = function( i )
{
    $('#table_product_locations_list').DataTable().column( i ).search(
        $('#col' + i + '_filter_location').val()
    ).draw();
};

$("#open_modal_status_product").click( function()
{
	$("#modal_status_product").modal({
		backdrop : 'static' ,
		keyboard : false
	});
})

$("#change_status_product").click( function()
{
	$("#form_status_product").submit()
})

function checkDataForm( data )
{
	var flag_edit_product   = 0
	var text_data_required = 'Este campo es necesario'

	$(".message_error_edit_product").text("")

	if (data.code == '') {
		$("#message_error_code").text( text_data_required )

		flag_edit_product = 1
	}

	if (data.description == '') {
		$("#message_error_description").text( text_data_required )

		flag_edit_product = 1
	}

	if (data.price == '') {
		$("#message_error_price").text( text_data_required )

		flag_edit_product = 1
	}

	if (data.quantity == '') {
		$("#message_error_quantity").text( text_data_required )

		flag_edit_product = 1
	}

	if (flag_edit_product == 1) {
		return false
	}

	return true
}

$("#save_edit_product").click( function()
{
	var data_form = {
		'code' 		  : $("#code").val() ,
		'description' : $("#description").val() ,
		'price' 	  : $("#price").val() ,
		'quantity' 	  : $("#quantity").val()
	}

	if (!checkDataForm( data_form )) {
		return false
	}

	$("#form_edit_product").submit()
})

$("#change_image_product").click( function()
{
	var img = $("#img_product").val()

	if (img != '') {
		$("#form_image_product").submit()
	}
})

var tableProductLocation = function()
{
	var grid = new Datatable();

    grid.init({
        src 	  : $("#table_product_locations_list") ,
        onSuccess : function( grid , response )
        {
            //
        } ,
        onError : function( grid )
        {
        	// execute some code on network or other general error  
        } ,
        onDataLoad : function( grid )
        {
            $('tr td:nth-child(3)').each( function()
            {
                $(this).addClass( 'text-center' );
            });

            $('tr td:nth-child(4)').each( function()
            {
                $(this).addClass( 'text-right' );
            });
        } ,
        loadingMessage : 'Loading...' ,
        dataTable 	   : {
        	"bStateSave" : false ,
            "lengthMenu" : [
                [10 , 20 , 50] ,
                [10 , 20 , 50]
            ] ,
            "pageLength" : 10 ,
            "ajax" : {
                "url" 	   : window.Laravel.urlpath + "/locations_product/table_product_locations_list" ,
                "method"   : "POST" ,
                "datatype" : "JSON" ,
                data 	   : function( data )
                {
                	data.product_id = $("#product_id").val()
                } ,
                "headers"  : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                }
            } ,
            "columnDefs" : [{
            	'orderable' : false ,
            	'targets'   : [2]
            }] ,
            "order" : [
                [1 , "asc"]
            ]
        }
    });

    grid.getTableWrapper().on( 'click' , '.table-group-action-submit' , function( e )
    {
    	e.preventDefault();
        var action = $(".table-group-action-input" , grid.getTableWrapper());
        if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
            grid.setAjaxParam("customActionType" , "group_action");
            grid.setAjaxParam("customActionName" , action.val());
            grid.setAjaxParam("id" , grid.getSelectedRows());
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        }
        else if (action.val() == "") {
            App.alert({
                type 	  : 'danger' ,
                icon 	  : 'warning' ,
                message   : 'Please select an action' ,
                container : grid.getTableWrapper() ,
                place 	  : 'prepend'
            });
        }
        else if (grid.getSelectedRowsCount() === 0) {
            App.alert({
                type 	  : 'danger' ,
                icon 	  : 'warning' ,
                message   : 'No record selected' ,
                container : grid.getTableWrapper() ,
                place 	  : 'prepend'
            });
        }
    });
}

$("#approve_order").click( function()
{
    changePhaseOrder( 2 , 'aprobar' )
})

$("#pause_order").click( function()
{
    changePhaseOrder( 3, 'pausar' )
})

$("#cancel_order").click( function()
{
    changePhaseOrder( 4, 'cancelar' )
})

function changePhaseOrder( status_step , status )
{
    var comment = $("#comments_step")

    if (status_step != 2) {

        if (comment.val() == '') {
            Message.show({
                html      : 'No puede ' + status + ' el proceso sin un comentario' ,
                container : 'general_message_orders' ,
                type      : Message.ERROR
            });

            comment.focus()

            return false
        }
    }

    $("#status_step").val( status_step )

    $("#next_phase_order").submit()
}

$("#date_range").change( function()
{
    $("#date_start_end").val( $("#date_range").val() )
})