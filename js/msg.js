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


function loadMsg(id){
	//todo tengo uqe ir a buscar el contenido del mensaje y marcarlo como leido
	$.ajax({
            url: 'serverCall/getMsgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, msg_id:id},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los mensajes
					$('#pagina_central').html($.View("views/viewMsg.ejs",data));
					getUnreadMsg();          		
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

function viewInbox(ok){
	$.ajax({
            url: 'serverCall/getMsgInboxF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los mensajes
					$('#pagina_central').html($.View("views/inboxView.ejs",data.msgs));
					if(ok==true){
						$('#error').html(
                		'<div class="row">'
                		+'<div class="alert alert-success alert-dismissable">'
  						+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
              			+'El mensaje se ha borrado <a class="alert-link" >Exitosamente</a>!' 
        		    	+'</div>'
        		    	+'</div>');						
					}
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

function loadSent(id){
	//todo tengo uqe ir a buscar el contenido del mensaje y marcarlo como leido
	$.ajax({
            url: 'serverCall/getSentF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, msg_id:id},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los mensajes
					$('#pagina_central').html($.View("views/viewMsgSent.ejs",data));
					getUnreadMsg();          		
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


function viewSent(ok){
	$.ajax({
            url: 'serverCall/getMsgSentF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los mensajes
					$('#pagina_central').html($.View("views/sentView.ejs",data.msgs));
					if(ok==true){
						$('#error').html(
                		'<div class="row">'
                		+'<div class="alert alert-success alert-dismissable">'
  						+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
              			+'El mensaje se ha borrado <a class="alert-link" >Exitosamente</a>!' 
        		    	+'</div>'
        		    	+'</div>');						
					}
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

function deleteMessage(id){
	
	$('#delMsgBot').attr("disabled","disabled");
	$('#delMsgBot').html('<i class="fa fa-spinner fa-spin"></i> Borrando');
	$.ajax({
            url: 'serverCall/deleteMsgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, msg_id:id},
            success: function(data) {
            	if(data.status=="ok"){
					viewInbox(true);
            	}else if(data.status=="exp"){
            		expire();
            	}else{
            		$('#delMsgBot').removeAttr("disabled");
					$('#delMsgBot').html('Borrar Mensaje'); 
					$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Ocurrio un <a class="alert-link" >error</a>. Por favor intente nuevamente!'  
        			+'</div>'
        			+'</div>');
            		}
            },error: function(error){
            	console.log(error);
            } 
	});	
	
};

function deleteMessageSent(id){

	$('#delMsgBot').attr("disabled","disabled");
	$('#delMsgBot').html('<i class="fa fa-spinner fa-spin"></i> Borrando');
	$.ajax({
            url: 'serverCall/deleteSentF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, msg_id:id},
            success: function(data) {
            	if(data.status=="ok"){
					viewSent(true);
            	}else if(data.status=="exp"){
            		expire();
            	}else{
            		$('#delMsgBot').removeAttr("disabled");
					$('#delMsgBot').html('Borrar Mensaje'); 
					$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Ocurrio un <a class="alert-link" >error</a>. Por favor intente nuevamente!'  
        			+'</div>'
        			+'</div>');
            		}
            },error: function(error){
            	console.log(error);
            } 
	});
};
