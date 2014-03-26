//Esta funcion obtiene los creditos del usuario
function getUnreadMsg(){
	$.ajax({
            url: 'serverCall/getMsgHeaderF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los mensajes
					$('#mensajes').html($.View("views/msgHeader.ejs",data.msgs));
					            		
            	}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 

	});
	
};


function newMsg(){
	$('#pagina_central').html($.View("views/newMsg.ejs"));
};

function newMessage(){
	$('#newMsgBot').attr("disabled","disabled");
	$('#newMsgBot').html('<i class="fa fa-spinner fa-spin"></i> Enviando');
	subject = $('#subject').val();
	body = $('#body').val();
	$.ajax({
            url: 'serverCall/newMsgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, subject: subject, body:body, to:null},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los mensajes
					$('#newMsgBot').removeAttr("disabled");
					$('#newMsgBot').html('Enviar Sugerencia');
					$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'Se ha enviado el mensaje <a class="alert-link" >exitosamente</a>!'  
        			+'</div>'
        			+'</div>');
					            		
            	}else if(data.status=="exp"){
            		expire();
            	}else{
            		$('#newMsgBot').removeAttr("disabled");
					$('#newMsgBot').html('Enviar Sugerencia');
            		alert('ocurrio un error');
            		
            	}
            },error: function(error){
            	$('#newMsgBot').removeAttr("disabled");
				$('#newMsgBot').html('Enviar Sugerencia');
            	console.log(error);
            } 

	});
};


function loadMsg(id){}; 