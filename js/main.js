$(function(){
	$('#name').keydown(function(){return charsOnly(event)});	
    $('#name').blur(function(){
    	
    	validateName($(this));
    	
    });
    
    $('#email').blur(function(){
    	validateMail($(this));	
    });
    
	
}		
);

function validateMessage(){
	if(required($('#message').val())){
		return true;
	}else
	{
		return false;
	}
}

function validateEnter(){
	validName=validateName($('#name'));
	validMail=validateMail($('#email')) ;
	if( validName || validMail )
		return false;
	else
		return true;
}


function validateName(datos){
		data=datos.val();
    	if(!required(data)){
    		datos.parent('.form-group').removeClass('has-success').addClass('has-error');
    		datos.next('.help-block').html('Nombre es obligatorio');
    		return true;
    	}else{
    		if(!minSize(data,3)){
	    		datos.parent('.form-group').removeClass('has-success').addClass('has-error');
	    		datos.next('.help-block').html('Tu nombre debe tener minimo 3 caracteres');
	    		return true;
	    	}else{
	    		datos.parent('.form-group').removeClass('has-error').addClass('has-success');
	    		datos.next('.help-block').html('');
	    		return false;
	    	}
    	}
}

function validateMail(data){
	datos=data.val();
    	if(!required(datos)){
    		data.parent('.form-group').removeClass('has-success').addClass('has-error');
    		data.next('.help-block').html('Email es obligatorio');
    		return true;
    	}else{
    		if(!validateEmail(datos)){
	    		data.parent('.form-group').removeClass('has-success').addClass('has-error');
	    		data.next('.help-block').html('Email no es un mail valido');
	    		return true;
	    	}else{
	    		data.parent('.form-group').removeClass('has-error').addClass('has-success');
	    		data.next('.help-block').html('');
	    		return false;
	    	}
    	}
}


function required(data){
	if(data.length>=1){
		return true;
	}
	return false;
}

function minSize(data,size){
	if(data.length>=size){
		return true;
	}
	return false;
}
function maxSize(data,size){
	if(data.length<size){
		return true;
	}
	return false;
}

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( $email ) ) {
    return false;
  } else {
    return true;
  }
}


function charsOnly(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (!(event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ))) {
                event.preventDefault(); 
            }   
        }
    }