$(document).ready( function()
{
	$(".active_orders_button").addClass("active")

	var timeout;
    var delay = 500;

	tableOrders()

	$('input.form_filter_order').on( 'keyup' , function()
    {
        var i = $(this).parents('td').attr('data-column');

        if (timeout) {
            clearTimeout( timeout );
        }

        timeout = setTimeout( function()
        {
            filterColumnOrdersList( i );
        } , delay);
    });

    $("#col1_filter_order").on( "change" , function()
    {
        filterColumnOrdersList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });

    $("#col2_filter_order").on( "change" , function()
    {
        filterColumnOrdersList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });
})

var filterColumnOrdersList = function( i )
{
    $('#table_orders_list').DataTable().column( i ).search(
        $('#col' + i + '_filter_order').val()
    ).draw();
};

var tableOrders = function()
{
	var grid = new Datatable();

    grid.init({
        src 	  : $("#table_orders_list") ,
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
                $(this).addClass( 'text-center' );
            });

            $('tr td:nth-child(5)').each( function()
            {
                $(this).addClass( 'text-center' );
            });

            $('tr td:nth-child(6)').each( function()
            {
                $(this).addClass( 'text-center' );
            });

            $('tr td:nth-child(7)').each( function()
            {
                $(this).addClass( 'text-center' );
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
                "url" 	   : window.Laravel.urlpath + "/orders/table_orders_list" ,
                "method"   : "POST" ,
                "datatype" : "JSON" ,
                "headers"  : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                }
            } ,
            "columnDefs" : [{
            	'orderable' : false ,
            	'targets'   : [1 , 2 , 4 , 5]
            }] ,
            "order" : [
                [0 , "asc"]
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

$("#reset_table_list_orders").click( function()
{
	$(".form_filter_order").val("")

	$('#table_orders_list').DataTable().search('').columns().search('').draw()
})