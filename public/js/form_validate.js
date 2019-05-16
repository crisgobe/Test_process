var formValidateTracking = function( form1 , type )
{
    var error1   = $('.alert-danger' , form1);
    var success1 = $('.alert-success' , form1);

    form1.validate({
        errorElement : 'span' , //default input error message container
        errorClass   : 'help-block' , // default input error message class
        focusInvalid : true , // do not focus the last invalid input
        ignore          : "" , // validate all fields including form hidden input
        messages : {
            code : {
                required  : "El código es necesario" ,
                minlength : jQuery.validator.format("El código debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("El código puede tener máximo {0} caracteres")
            } ,
            description : {
                required  : "La descripción es necesaria" ,
                minlength : jQuery.validator.format("La descripción debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("La descripción puede tener máximo {0} caracteres")
            } ,
            price : {
                required  : "El precio es necesario"
            } ,
            quantity : {
                required  : "La cantidad es necesaria"
            } ,
            locations_id : {
                required  : "La ubicación es necesaria"
            } ,
            name : {
                required  : "El nombre o razón social es necesario" ,
                minlength : jQuery.validator.format("La razón social debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("La razón social puede tener máximo {0} caracteres")
            } ,
            name_user : {
                required  : "El nombre del usuario es necesario" ,
                minlength : jQuery.validator.format("El nombre debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("El nombre puede tener máximo {0} caracteres")
            } ,
            nit : {
                required  : "La identificación es necesaria" ,
                minlength : jQuery.validator.format("La identificación debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("La identificación puede tener máximo {0} caracteres")
            } ,
            email : {
                required : "El correo electrónico es necesario" ,
                email    : "Ingrese un correo electrónico válido"
            } ,
            phone_1 : {
                required : "El teléfono fijo es necesario" ,
                number   : "Ingrese un teléfono fijo válido"
            } ,
            phone_2 : {
                required : "El celular es necesario" ,
                number   : "Ingrese un celular válido"
            } ,
            address : {
                required  : "La dirección es necesaria" ,
                minlength : jQuery.validator.format("La dirección debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("La dirección puede tener máximo {0} caracteres")
            } ,
            cities_id : {
                required  : "La ciudad es necesaria"
            } ,
            types_id : {
                required  : "El tipo de cliente es necesario"
            } ,
            warehouses_id : {
                required  : "La bodega es necesaria"
            } ,
            cellphone : {
                required : "El celular es necesario" ,
                number   : "Ingrese un celular válido"
            } ,
            password : {
                required  : "La contraseña es necesaria" ,
                minlength : jQuery.validator.format("La contraseña debe tener mínimo {0} caracteres") ,
                maxlength : jQuery.validator.format("La contraseña puede tener máximo {0} caracteres")
            } ,
            areas_id : {
                required  : "El área es necesaria"
            } ,
            positions_id : {
                required  : "El cargo es necesario"
            }
        } ,
        rules : {
            code : {
                required  : true ,
                minlength : 2 ,
                maxlength : 15
            } ,
            description : {
                required  : true ,
                minlength : 3 ,
                maxlength : 40
            } ,
            price : {
                required  : true
            } ,
            quantity : {
                required  : true
            } ,
            locations_id : {
                required: true
            } ,
            name : {
                required  : true ,
                minlength : 2 ,
                maxlength : 40
            } ,
            name_user : {
                required  : true ,
                minlength : 2 ,
                maxlength : 40
            } ,
            nit : {
                required  : true ,
                minlength : 7 ,
                maxlength : 15
            } ,
            email : {
                required : true ,
                email    : true
            } ,
            phone_1 : {
                required : true ,
                number   : {
                    depends : function( element )
                    {
                        var val_phone_1 = $("#form_control_phone_1").val()

                        if (val_phone_1.slice(11) == "_") {
                            return true
                        }
                    }
                } 
            } ,
            phone_2 : {
                required : true ,
                number   : {
                    depends : function( element )
                    {
                        var val_phone_2 = $("#form_control_phone_2").val()

                        if (val_phone_2.slice(13) == "_") {
                            return true
                        }
                    }
                }
            } ,
            address : {
                required  : true ,
                minlength : 5 ,
                maxlength : 40
            } ,
            cities_id : {
                required  : true
            } ,
            types_id : {
                required  : true
            } ,
            warehouses_id : {
                required: true
            } ,
            cellphone : {
                required : true ,
                number   : {
                    depends : function( element )
                    {
                        var val_cellphone = $("#form_control_cellphone").val()

                        if (val_cellphone.slice(13) == "_") {
                            return true
                        }
                    }
                }
            } ,
            password : {
                required: true ,
                minlength : 6 ,
                maxlength : 10
            } ,
            user_types_id : {
                required: true
            } ,
            positions_id : {
                required: true
            } ,
        } ,
        invalidHandler : function( event , validator )
        { //display error alert on form submit              
            success1.hide();
            error1.show();
            App.scrollTo(error1 , -200);
        } ,
        errorPlacement : function( error , element )
        {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            }
            else if (element.is(':radio')) {
                error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
            }
            else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        } ,
        highlight : function( element )
        { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        } ,
        unhighlight : function( element )
        { // revert the change done by hightlight
            $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
        } ,
        success : function( label )
        {
            label.closest('.form-group').removeClass('has-error'); // set success class to the control group
        } ,
        submitHandler : function( form )
        {
            var data_form = form1.serialize()

            continueProcessFormValidate( data_form , type )
        }
    });
}

function continueProcessFormValidate( data_form , type )
{
    switch (type) {
        case 1:
            saveNewProduct( data_form )
            break
        case 2:
            saveEditProduct( data_form )
            break
        case 3:
            saveNewCategory( data_form )
            break
        case 4:
            saveEditCategory( data_form )
            break
        case 5:
            saveNewCustomer( data_form )
            break
        case 6:
            saveEditCustomer( data_form )
            break
        case 7:
            saveNewLocation( data_form )
            break
        case 8:
            saveEditLocation( data_form )
            break
        case 9:
            saveNewUser( data_form )
            break
        case 10:
            saveEditUser( data_form )
            break
        case 11:
            saveNewWarehouse( data_form )
            break
        case 12:
            saveEditWarehouse( data_form )
            break
        case 13:
            saveNewArea( data_form )
            break
        case 14:
            saveEditArea( data_form )
            break

        default:
            console.log('Nothing')
    }
}

///////////////////
/*
    1  = New Product
    2  = Edit Product
    3  = New Category
    4  = Edit Category
    5  = New Customer
    6  = Edit Customer
    7  = New Location
    8  = Edit Location
    9  = New User
    10 = Edit User
    11 = New Warehouse
    12 = Edit Warehouse
    13 = New Area
    14 = Edit Area
*/
///////////////////