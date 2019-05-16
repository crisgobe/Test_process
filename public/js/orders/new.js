$(document).ready( function()
{
    var form_new_customer = $('#form_new_customer')

    formValidateTracking( form_new_customer , 5 )

	$(".active_orders_button").addClass("active")
	
	var timeout;
    var delay = 500;

	tableProducts()

	$('input.form_filter_product').on( 'keyup' , function()
    {
        var i = $(this).parents('td').attr('data-column');

        if (timeout) {
            clearTimeout( timeout );
        }

        timeout = setTimeout( function()
        {
            filterColumnProductsList( i );
        } , delay);
    });

    $("#col4_filter_product").on( "change" , function()
    {
        filterColumnProductsList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });

    ////////////// MASK ///////////

    $("#form_control_phone_1").inputmask("mask", {
        "mask": "(9) 999-9999"
    });

    $("#form_control_phone_2").inputmask("mask", {
        "mask": "(999) 999-9999"
    });

    //////////// END MASK /////////
    //////////// SELECT ///////////

    $('#cities_id').select2({
        placeholder : 'Seleccione la ciudad' ,
        width       : '100%'
    });

    $('#departments_id').select2({
        placeholder : 'Seleccione el departamento' ,
        width       : '100%'
    });

    //////////// END SELECT ///////
})

var filterColumnProductsList = function( i )
{
    $('#table_products_list').DataTable().column( i ).search(
        $('#col' + i + '_filter_product').val()
    ).draw();
};

$("#departments_id").change( function()
{
	var departments_id = $("#departments_id").val()

	var data = {
		'departments_id' : departments_id
	}

	getCities( data )
})

function getCities( data_form )
{
	var url    = "get_cities"
	var method = "post"

	var result_get_cities = requestAjax( url , method , data_form )

    result_get_cities.then( function( response )
    {
    	drawDropDownCities( response.cities )
    	console.log( response.cities )
    } ,
    function( error )
    {
    	console.log( error.cities )
    })
}

function drawDropDownCities( cities )
{
	$("#cities_id").html("")

	$.each(cities , function (i , city)
	{
		var options = '<option value="' + city.id + '">' + city.city + '</option>'

		$("#cities_id").append( options )
	})
}

var tableProducts = function()
{
	var grid = new Datatable();

    grid.init({
        src 	  : $("#table_products_list") ,
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
                $(this).addClass( 'text-right' );
            });
        } ,
        loadingMessage : 'Loading...' ,
        dataTable 	   : {
        	"language" : {
                "emptyTable":     "",
                "info":           "",
                "infoEmpty":      "Sin resultados",
                "lengthMenu":     "" ,
                "paginate"      : {
                    "page"     : "Página " ,
                    "pageOf"   : " de "
                }
            } ,
        	"bStateSave" : false ,
            "lengthMenu" : [
                [10 , 20 , 50] ,
                [10 , 20 , 50]
            ] ,
            "pageLength" : 10 ,
            "ajax" : {
                "url" 	   : window.Laravel.urlpath + "/orders/table_products_list" ,
                "method"   : "POST" ,
                "datatype" : "JSON" ,
                "headers"  : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                }
            } ,
            "columnDefs" : [{
            	'orderable' : false ,
            	'targets'   : [2]
            }] ,
            // "bPaginate": false ,
            "bInfo" : false ,
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

$("#reset_table_list_products").click( function()
{
	$(".form_filter_product").val("")

	$('#table_products_list').DataTable().search('').columns().search('').draw()
})

function selectProductId( name )
{
	// var name 	   = $(this).attr("name")
	var array_name = name.split("|")
	var flag 	   = 0

	$(".list_products_selected").each( function()
	{
		var id  = parseInt( $(this).attr("name") )

		if (array_name[0] == id) {
			flag = 1
		}
	})

	if (flag == 1) {
		return false
	}

	var products_td = '<tr id="row_' + array_name[0] + '">\
		<td>' + array_name[1] + '</td>\
		<td>\
			<input type="text" class="form-control list_products_selected text-right input-sm" id="qty_product_' + array_name[0] + '" name="' + array_name[0] + '" value="1" onkeypress="return valida(event)" onkeyup="calcPrice(' + array_name[0] + ' , ' + array_name[2] + ')" maxlength="6">\
		</td>\
		<td>\
			<input type="text" class="form-control text-right input-sm" id="draw_price_product_' + array_name[0] + '" value="$ ' + array_name[2] + '" readonly>\
			<input type="hidden" class="list_price_products" id="val_price_product_' + array_name[0] + '" value="$ ' + array_name[2] + '" readonly>\
		</td>\
		<td>\
			<a onclick="removeTemp(' + array_name[0] + ')">\
				<span class="fa fa-minus text-danger"></span>\
			</a>\
		</td>\
	</tr>'

	$("#table_products_invoice").append( products_td )

	calcPrice( array_name[0] , array_name[2] )
}

function removeTemp( id )
{
	$("#row_" + id).remove()
	$("#row_br_" + id).remove()

	resultTotalInvoice()
}

function calcPrice( id , price )
{
	var qty   = $("#qty_product_" + id).val()
	var w_iva = (price / 1.19)
	var total = w_iva * qty

	$("#draw_price_product_" + id).val( "$ " + number_format(Math.round( total ) , 0 , '.' , ',') )
	$("#val_price_product_" + id).val(Math.round( total ))

	resultTotalInvoice()
}

function resultTotalInvoice()
{
	var sub_total = 0
	var iva	  = 0
	var total = 0

	$(".list_price_products").each( function()
	{
		var val = $(this).val()

		var val_int = val.replace("$ " , "")

		sub_total = sub_total + parseInt( val_int )
	})

	iva = (sub_total * 0.19)
	total = sub_total + iva

	$("#subtotal_price_invoice").val( "$ " + number_format(Math.round( sub_total ) , 0 , '.' , ',') )
	$("#iva_invoice").val( "$ " + number_format(Math.round( iva ) , 0 , '.' , ',') )
	$("#total_price_invoice").val( "$ " + number_format(Math.round( total ) , 0 , '.' , ',') )
}

$("#next_1").click( function()
{
	if ($("#customer_selected").val() == '') {
	    notifications( 'No ha seleccionado ningún cliente' , 'error' )

		return false
	}

	$("#btn_tab_1").trigger('click')
})

$("#back_0").click( function()
{
	$("#btn_tab_0").trigger('click')
})

$("#next_2").click( function()
{
	var products = getProductsSelected()

	if (products == '') {
	    notifications( 'No ha seleccionado ningún producto' , 'error' )

		return false
	}

	orderPreview( products )
	
	$("#btn_tab_2").trigger('click')
})

$("#btn_tab_2").click( function()
{
	var products = getProductsSelected()

	if (products == '') {
	    notifications( 'No ha seleccionado ningún producto' , 'error' )

		return false
	}

	orderPreview( products )
})

$("#back_1").click( function()
{
	$("#btn_tab_1").trigger('click')
})

function checkDataClient( data )
{
	var flag_new_invoice   = 0
	var text_data_required = 'Este campo es necesario'

	$(".message_error_new_invoice").text("")

	if (data.name == '') {
		$("#message_error_name").text( text_data_required )

		flag_new_invoice = 1
	}

	if (data.nit == '') {
		$("#message_error_nit").text( text_data_required )

		flag_new_invoice = 1
	}

	if (data.cellphone == '') {
		$("#message_error_phone").text( text_data_required )

		flag_new_invoice = 1
	}

	if (data.address == '') {
		$("#message_error_address").text( text_data_required )

		flag_new_invoice = 1
	}

	if (flag_new_invoice == 1) {
		return false
	}

	return true
}

$("#print_order_preview").click( function()
{
	var products = getProductsSelected()

	var data = {
		'products' : products ,
		'customer' : $("#customer_selected").val()
	}

	window.open( window.Laravel.urlpath + '/orders/print_order_preview/' + JSON.stringify( data ) , '_blank' )
})

function orderPreview( array_send )
{
	var data = {
		'products' : array_send ,
		'customer' : $("#customer_selected").val()
	}

	$.ajax({
		url   : window.Laravel.urlpath + "/orders/order_preview" ,
		data  : data ,
		error : function( e )
		{
			console.log( e )
		} ,
		success : function( data )
		{
			console.log( data )

			drawResult( data )

			/*var url = '/print_pdf_invoice/' + data.invoice_id
			window.open( url , '_blank' )
			window.location.href = 'invoices'*/
		} ,
		method   : 'POST' ,
		dataType : 'JSON' ,
		headers  : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr( 'content' )
        }
	})
}

function drawResult( data )
{
	$("#tbody_products_selected").html("")

	var lines = ''

	$.each(data.confirmation_products , function (i , product)
    {
        lines = '<tr>\
        	<td>' + product.code + '</td>\
        	<td>' + product.description + '</td>\
        	<td class="text-right">' + number_format(Math.round( product.quantity ) , 0 , '.' , ',') + '</td>\
        	<td class="text-right">$ ' + number_format(Math.round( product.price ) , 0 , '.' , ',') + '</td>\
        	<td class="text-right">$ ' + number_format(Math.round( product.price_total ) , 0 , '.' , ',') + '</td>\
        </tr>'

        $("#tbody_products_selected").append(lines)
    });

    var total_order = '<tr class="success">\
        	<td colspan="4"><b>Total</b></td>\
        	<td class="text-right"><b>$ ' + number_format(Math.round( data.total_order ) , 0 , '.' , ',') + '</b></td>\
        </tr>'

    $("#tbody_products_selected").append(total_order)

    $("#resume_customer_selected").text( data.confirmation_customer.nit + ' ' + data.confirmation_customer.name )
}

$("#create_order").click( function()
{
	var comment = $("#order_comment").val()
	var city 	= $("#cities_id").val()

	if (comment == '') {
	    notifications( 'No ha escrito la descripción del proceso' , 'error' )

	    return false
	}

	if (city == '') {
	    notifications( 'No ha seleccionado ninguna ciudad' , 'error' )

	    return false
	}

	var data_order = {
		'comment' : comment ,
		'city'    : city
	}

	createOrder( data_order )
})

function getProductsSelected()
{
	array_send = []

	$(".list_products_selected").each( function()
	{
		var id  = parseInt( $(this).attr("name") )
		var val = $(this).val()

		array_send.push([id , val])
	})

	return array_send

	console.log( array_send )
}

function createOrder( data )
{
	var boton  = $("#create_order")

	boton.button('loading');

	$.ajax({
		url   : window.Laravel.urlpath + "/orders/create_order" ,
		data  : data ,
		error : function( e )
		{
			console.log( e )

			boton.button('reset');
		} ,
		success : function( data )
		{
			window.location.href = window.Laravel.urlpath + '/orders/order_create_success'
		} ,
		method   : 'POST' ,
		dataType : 'JSON' ,
		headers  : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr( 'content' )
        }
	})
}

$("#open_modal_new_comment").click( function()
{
	opentModalNewComment()
})

function opentModalNewComment()
{
	$('#modal_comments_order').modal({
        backdrop : 'static' ,
        keyboard : false
    })

    setTimeout( function()
    {
    	$("#order_comment").focus()
    } , 500)
}

$("#cancel_comment").click( function()
{
	$("#order_comment").val("")
})

function assignNewCustomerOrder( data )
{
	console.log( data )
	var add_option = '<option value="' + data.id + '" selected>' + data.nit + ' - ' + data.name + '</option>'

	$("#customer_selected").append( add_option )
}