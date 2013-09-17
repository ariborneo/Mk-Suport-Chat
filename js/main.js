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


function getMessages(date){
	$.post('actions/get_messages.php',{'last_update':date},function(data){
		var res= $.parseJSON(data);
		
		if(res.status==200){
			for(var i=0; i<res.messages.length;i++){
				var last=$('#last');
				last.after('<div id="last" class="well well-sm"></div>');
				last.removeAttr('id');
				if(res.messages[i].type==1){
					var sender=res.client_name;
					var color ="green";
				}
				else if(res.messages[i].type==2){
					var sender=res.user_name;
					var color ="blue";
				}
				else if(res.messages[i].type==3){
					var sender='SYSTEM';
					var color ="red";
				}
				$('#last').html("<p><span style='color:"+color+"'>"+sender+" says: </span>"+res.messages[i].content+"</p><p style='font-size:0.8em'>"+res.messages[i].date+"</p>");
				
				var height=$('#messages')[0].scrollHeight;
				$('#messages').scrollTop(height);
				
			}
		}
	});
}
function getMessagesUser(date,chat){
	$.post('actions/get_messages.php',{'last_update':date,'chat':chat},function(data){

		var res= $.parseJSON(data);	
		if(res.status==200){
			
			for(var i=0; i<res.messages.length;i++){
				
				var last=$('#last');
				last.after('<div id="last" class="well well-sm"></div>');
				last.removeAttr('id');
				if(res.messages[i].type==1){
					var sender=res.client_name;
					var color ="green";
				}
				else if(res.messages[i].type==2){
					var sender=res.user_name;
					var color ="blue";
				}
				else if(res.messages[i].type==3){
					var sender='SYSTEM';
					var color ="red";
				}
				$('#last').html("<p><span style='color:"+color+"'>"+sender+" says: </span>"+res.messages[i].content+"</p><p style='font-size:0.8em'>"+res.messages[i].date+"</p>");
				
				var height=$('#messages')[0].scrollHeight;
				$('#messages').scrollTop(height);
				
			}
		}
	});
}

function sendMessage(){
	if(validateMessage()){
		$.post('actions/send_client_message.php',
			{'message':$('#message').val()}
		);
	}
	$('#message').val('');
}
function sendUserMessage(id){
	if(validateMessage()){
		$.post('actions/send_user_message.php',
			{'message':$('#message').val(),'id':id},
			function(data){console.log(data)}
		);
	}
	$('#message').val('');
}

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
    		datos.next('.help-block').html('Name required');
    		return true;
    	}else{
    		if(!minSize(data,3)){
	    		datos.parent('.form-group').removeClass('has-success').addClass('has-error');
	    		datos.next('.help-block').html('Name is to short');
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
    		data.next('.help-block').html('Email required');
    		return true;
    	}else{
    		if(!validateEmail(datos)){
	    		data.parent('.form-group').removeClass('has-success').addClass('has-error');
	    		data.next('.help-block').html('Email is not a valid email');
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