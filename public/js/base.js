$(document).ready( function()
{
	setTimeout( function()
	{
		$(".alert").fadeOut('slow');
	} , 4000);

    $(":input").on('paste' , function( e )
    {
        e.preventDefault()
        notifications( "esta acción no está permitida" , 'error' )
        
    })

    $(":input").on('copy' , function( e )
    {
        e.preventDefault()
        notifications( "esta acción no está permitida" , 'error' )
    })
})

function valida(e)
{
	var taman = this.value
	tecla 	  = (document.all) ? e.keyCode : e.which

	if (tecla == 8) {
        return true
    }

    patron 		= /[0-9.]/
    tecla_final = String.fromCharCode( tecla )
    
    return patron.test( tecla_final )
}

function number_format(number, decimals, dec_point, thousands_point)
{

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}

///////////// Messages Alerts /////////////////////

function Message(){}

Message.INFO    = 1;
Message.ERROR   = 2;
Message.SUCCESS = 3;
Message.WARNING = 4;
Message.show    = function (options)
{
    var idsOption       = ['html','container','autoClose','type','timeout','classes'];
    var functionsOption = ['onClosed'];

    if(options == undefined){
        options = {};
    }

    var defaultOptions = {
            html : '' ,
            container: '',
            autoClose: true,
            timeout : 4000,
            classes : '',
            type : Message.SUCCESS,
            onClosed : function(){}
    };

    var validateOptions = function ()
    {
        for (var i=0; i < idsOption.length; i++ ) {

            if (options[idsOption[i]] != undefined) {
                defaultOptions[idsOption[i]] = options[idsOption[i]];
            }
        }

        for (var i=0; i < functionsOption.length; i++ ) {

            if (options[functionsOption[i]] != undefined && jQuery.isFunction(options[functionsOption[i]] )) {
                defaultOptions[functionsOption[i]] = options[functionsOption[i]];
            }
        }
    };

    validateOptions();

    var ids = {
        id : generateID(10),
        html: defaultOptions.html,
        container: defaultOptions.container,
        autoClose: defaultOptions.autoClose,
        timeout : defaultOptions.timeout,
        classes : defaultOptions.classes,
        type : defaultOptions.type,
        onClosed : defaultOptions.onClosed
    };

    var alertClass = 'alert-success';

    if (ids.type == Message.ERROR) {
        alertClass = 'alert-danger';
    }
    else if (ids.type == Message.INFO) {
        alertClass = 'alert-info';
    }
    else if (ids.type == Message.WARNING) {
        alertClass = 'alert-warning';
    }

    var textCloseButton = '';

    if (!ids.autoClose) {
        textCloseButton =  '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>';
    }

    var text ='<div class="alert '+ alertClass +' '+ids.classes+'" id="'+ids.id+'" style="display:none; margin-top: 5px !important;; margin-bottom: 0 !important;" > ' +
        textCloseButton +
        ids.html +
    '</div>';

    goToId(ids.container);

    $('#' + ids.container).append(text);
    $('#' + ids.container).css('margin-bottom','20px');
    $('#' + ids.id).fadeIn();

    if (ids.autoClose) {
        setTimeout( function()
        {
            $('#' + ids.id).fadeOut(400,function()
            {
                $('#' + ids.id).remove();
            });
        } , ids.timeout)
    }
};

var generateID =  function(length)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
};

function goToId(idName)
{
    if($("#"+idName).length)
    {
        var target_offset = $("#"+idName).offset();
        var target_top = target_offset.top;
        $('html,body').animate({scrollTop:(target_top-75)},{duration:"slow"});
    }
}

///////////// End Messages Alerts /////////////////////

function validEmail( email )
{
    var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

    if (caract.test(email) == false) {
        return false;
    }

    return true;
}

function requestAjax( url , method , data )
{
    return $.ajax({
        method  : method ,
        url     : url ,
        data    : data ,
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr( 'content' )
        }
    })
}

function notifications( message , type )
{
    toastr.options = {
      "closeButton"   : true ,
      "debug"           : false ,
      "positionClass" : "toast-top-center" ,
      "onclick"       : null ,
      "timeOut"       : "5000" ,
    }

    toastr[type]( message );
}