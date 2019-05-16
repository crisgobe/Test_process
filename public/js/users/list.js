$(document).ready( function()
{
    var form_new_user = $('#form_new_user')

    formValidateTracking( form_new_user , 9 )
    
    $(".active_users_button").addClass("active")

	var timeout;
    var delay = 500;

	tableUsers()

	$('input.form_filter_user').on( 'keyup' , function()
    {
        var i = $(this).parents('td').attr('data-column');

        if (timeout) {
            clearTimeout( timeout );
        }

        timeout = setTimeout( function()
        {
            filterColumnUsersList( i );
        } , delay);
    });

    $("#col2_filter_user").on( "change" , function()
    {
        filterColumnUsersList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });

    $("#col3_filter_user").on( "change" , function()
    {
        filterColumnUsersList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });

    $("#col4_filter_user").on( "change" , function()
    {
        filterColumnUsersList( $(this).parents( 'td' ).attr( 'data-column' ) );
    });

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

var filterColumnUsersList = function( i )
{
    $('#table_users_list').DataTable().column( i ).search(
        $('#col' + i + '_filter_user').val()
    ).draw();
};

var tableUsers = function()
{
	var grid = new Datatable();

    grid.init({
        src 	  : $("#table_users_list") ,
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
                "url" 	   : window.Laravel.urlpath + "/users/table_users_list" ,
                "method"   : "POST" ,
                "datatype" : "JSON" ,
                "headers"  : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                }
            } ,
            "columnDefs" : [{
            	'orderable' : false ,
            	'targets'   : [2 , 3 , 4]
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

$("#reset_table_list_users").click( function()
{
    clearListTableUser()
})

function clearListTableUser()
{
    $(".form_filter_user").val("")

    $('#table_users_list').DataTable().search('').columns().search('').draw()
}