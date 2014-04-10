var bet_id=0;
var safety_id=0;
function makeBetBJ(amount, descr, newID){
	$.ajax({
            url: 'serverCall/makeBetBJF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, amount:amount, descr:descr},
            success: function(data) {
            	if(data.status=="ok"){
            		
            		if(newID==true)
            			safety_id=data.id;
            		if(newID==false)
            			bet_id=data.id;
            		reloadCredit();
            		reloadCrBJ();
            		if(credits==minBet || credits < defaultBet){
						defaultBet=minBet;
						changeBet(0);
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
}

function payBet(amount,descr, newID){
	
	var bj_id=newID?safety_id:bet_id;
	
		$.ajax({
            url: 'serverCall/payBetBJF.php',
            dataType: "json",
            asyn :false,
            data: {id:act.user_id, auth_token:act.auth_token, amount:amount, descr:descr, bj_id:bj_id},
            success: function(data) {
            	if(data.status=="ok"){
    				reloadCredit();
    				reloadCrBJ();
    				updateBetDisplay(0);
    				if(credits>= defaultBet){
						defaultBet=100;
						changeBet(0);
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
}

function rejectChlg(event_id, chall_user_id){
	
	$.ajax({
            url: 'serverCall/rejectChlgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, chlg_user_id:chall_user_id},
            success: function(data) {
            	if(data.status=="ok"){
            			reloadStructs();
    					challengeView(true);
    						
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

function aceptChlg(event_id, opp_user){
	  
	$.ajax({
            url: 'serverCall/getChlgInfoF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, opp_user:opp_user},
            success: function(data) {
            	if(data.status=="ok"){
            			//TODO aca tengo que dibujar la view
            			$('#myModalLabel').html(data.event_d);
            			$('#modal-body').html($.View("views/aceptChlg.ejs",data));
            			reloadStructs();
    					//challengeView(true);
    						
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

function cancelChlg(event_id, user_id){
	$.ajax({
            url: 'serverCall/cancelChlgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
            success: function(data) {
            	if(data.status=="ok"){
            			reloadStructs();
    					chlgPendingView(true);
    						
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


function cancelBet(event_id){
	$.ajax({
            url: 'serverCall/cancelBetF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
            success: function(data) {
            	if(data.status=="ok"){
            			reloadStructs();
    					betsView(1);
    						
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

function makeBet(event_id){
	$.ajax({
            url: 'serverCall/getBetInfoF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
            success: function(data) {
            	if(data.status=="ok"){
            			//TODO aca tengo que dibujar la view
            			$('#modal-body').html($.View("views/aceptBet.ejs",data));
            			reloadStructs();
    					//challengeView(true);
    						
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

function editBet(event_id){
	$.ajax({
            url: 'serverCall/getBetEditInfoF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
            success: function(data) {
            	if(data.status=="ok"){
            			$('#modal-body').html($.View("views/editBet.ejs",data));
            			reloadStructs();
    					//challengeView(true);
    						
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

function sendBet(event_id){
	$.ajax({
            url: 'serverCall/getBetInfoF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
            success: function(data) {
            	if(data.status=="ok"){
            			$('#modal-body').html($.View("views/sendBet.ejs",data));
            			reloadStructs();
    					//challengeView(true);
    						
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

function makeChlg(event_id){
		$.ajax({
            url: 'serverCall/getBetInfoF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
            success: function(data) {
            	if(data.status=="ok"){
            			//TODO aca tengo que dibujar la view
            			$('#modal-body').html($.View("views/chlgBet.ejs",data));
            			reloadStructs();
    					//challengeView(true);
    						
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

function processChallenge(event_id, user_opp){
	$('#error').html("");
	$('#processChallenge').attr("disabled","disabled");
	$('#processChallenge').html('<i class="fa fa-spinner fa-spin"></i> Aceptando');
	
	var selection = $('input[name="optionsRadios"]:checked').val();
	
	$.ajax({
            url: 'serverCall/aceptChlgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, user_opp:user_opp, selection:selection},
            success: function(data) {
            	$('#myModal').modal('hide');
            	if(data.status=="ok"){
            			reloadStructs();
						reloadChallengeView();
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-success">'
					            +'El desafio ha sido aceptado <a class="alert-link" >Exitosamente</a>!'  
					        	+'</div>'
					        	+'</div>');
					        	
    			}else if(data.status=="credit"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'No posee credito suficiente para aceptar el Desafio!'  
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="bet"){
					    $('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'Ya posee una apuesta asociada a ese evento. Debe cancelarla para aceptar el desafio!'  
					        	+'</div>'
					        	+'</div>');
					        	
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


function processBetEvent(event_id){
	
	$('#error').html("");
	$('#processChallenge').attr("disabled","disabled");
	$('#processChallenge').html('<i class="fa fa-spinner fa-spin"></i> Apostando');
	
	var selection = $('input[name="optionsRadios"]:checked').val();
	var amount = $('#amount').val();
	if(amount < 0.5 || (amount*100)%50!=0){
		$('#myModal').modal('hide');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El monto de apuesta debe ser multiplo de <a class="alert-link" >0.5 Cr.</a>!'  
	        	+'</div>'
	        	+'</div>');

	}else{
		$.ajax({
            url: 'serverCall/aceptBetF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, selection:selection, amount:amount},
            success: function(data) {
            	$('#myModal').modal('hide');
            	if(data.status=="ok"){
            			reloadStructs();
						$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-success">'
					            +'La apuesta se realizo <a class="alert-link" >Exitosamente</a>!'  
					        	+'</div>'
					        	+'</div>');
					        	
    			}else if(data.status=="credit"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'No posee credito suficiente para aceptar el Desafio!'  
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
		});	
	}
	

	
};

function processEditBet(event_id){
	
	$('#error').html("");
	$('#processChallenge').attr("disabled","disabled");
	$('#processChallenge').html('<i class="fa fa-spinner fa-spin"></i> Apostando');
	
	var selection = $('input[name="optionsRadios"]:checked').val();
	var amount = $('#amount').val();
	if(amount < 0.5 || (amount*100)%50!=0){
		$('#myModal').modal('hide');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El monto de apuesta debe ser mayor que 0 y multiplo de <a class="alert-link" >0.5 Cr.</a>!'  
	        	+'</div>'
	        	+'</div>');

	}else{
		$.ajax({
            url: 'serverCall/editBetF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, selection:selection, amount:amount},
            success: function(data) {
            	$('#myModal').modal('hide');
            	if(data.status=="ok"){
            			reloadStructs();
						$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-success">'
					            +'La apuesta se realizo <a class="alert-link" >Exitosamente</a>!'  
					        	+'</div>'
					        	+'</div>');
					        	
    			}else if(data.status=="credit"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'No posee credito suficiente para editar el Desafio!'  
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="Bet"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'La apuesta ya fue retirada!'  
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
		});	
	}
	

	
};


function processChlgBet(event_id){
	$('#error').html("");
	$('#processChallenge').attr("disabled","disabled");
	$('#processChallenge').html('<i class="fa fa-spinner fa-spin"></i> Apostando');
	
	var selection = $('input[name="optionsRadios"]:checked').val();
	var amount = $('#amount').val();
	var opp_user = $('#enterprise').val();
	if(amount < 0.5 || (amount*100)%50!=0){
		$('#myModal').modal('hide');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El monto de apuesta debe ser mayor que 0 y multiplo de <a class="alert-link" >0.5 Cr.</a>!'  
	        	+'</div>'
	        	+'</div>');

	}else if(opp_user == ""){
		$('#myModal').modal('hide');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El Enterprise no puede ser <a class="alert-link" >Vacio</a>!'  
	        	+'</div>'
	        	+'</div>');
	}else{
		$.ajax({
            url: 'serverCall/chlgBetF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, selection:selection, amount:amount, opp_user:opp_user},
            success: function(data) {
            	$('#myModal').modal('hide');
            	if(data.status=="ok"){
            			reloadStructs();
						$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-success">'
					            +'El Desafio se realizo <a class="alert-link" >Exitosamente</a>!'  
					        	+'</div>'
					        	+'</div>');
					        	
    			}else if(data.status=="credit"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'No posee credito suficiente para aceptar el Desafio!'  
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="bet"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'Ya posee una apuesta o un desafio asociado a este evento!'  
					        	+'</div>'
					        	+'</div>');			
				}else if(data.status=="user"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'El enterpise ingresado es <a class="alert-link" >Incorrecto</a>!'
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
		});	
	}
	
};

function processSendBet(event_id){
	$('#error').html("");
	$('#processChallenge').attr("disabled","disabled");
	$('#processChallenge').html('<i class="fa fa-spinner fa-spin"></i> Apostando');
	
	var opp_user = $('#enterprise').val();
	if(opp_user == ""){
		$('#myModal').modal('hide');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El Enterprise no puede ser <a class="alert-link" >Vacio</a>!'  
	        	+'</div>'
	        	+'</div>');
	}else{
		$.ajax({
            url: 'serverCall/sendBetF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id, opp_user:opp_user},
            success: function(data) {
            	$('#myModal').modal('hide');
            	if(data.status=="ok"){
            			reloadStructs();
						$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-success">'
					            +'Se envio el Evento <a class="alert-link" >Exitosamente</a>!'  
					        	+'</div>'
					        	+'</div>');
					        	
    			}else if(data.status=="user"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'El enterpise ingresado es <a class="alert-link" >Incorrecto</a>!'
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
		});	
	}
	
};


function sendCr(){
	$('#error').html("");
	$('#sendCredBot').attr("disabled","disabled");
	$('#sendCredBot').html('<i class="fa fa-spinner fa-spin"></i> Enviando');
	
	var amount = $('#amount').val();
	var opp_user = $('#enterprise').val();
	
	if(amount < 0.5 || (amount*100)%50!=0){
		$('#sendCredBot').removeAttr("disabled");
		$('#sendCredBot').html('Enviar Credito');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El monto de apuesta debe ser mayor que 0 y multiplo de <a class="alert-link" >0.5 Cr.</a>!'  
	        	+'</div>'
	        	+'</div>');

	}else if(opp_user == ""){
		$('#sendCredBot').removeAttr("disabled");
		$('#sendCredBot').html('Enviar Credito');
		$('#error').html(
	             '<div class="row">'
	            +'<div class="alert alert-danger">'
	            +'El Enterprise no puede ser <a class="alert-link" >Vacio</a>!'  
	        	+'</div>'
	        	+'</div>');
	}else{
		$.ajax({
            url: 'serverCall/sendCrF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, amount:amount, opp_user:opp_user},
            success: function(data) {
            	$('#sendCredBot').removeAttr("disabled");
				$('#sendCredBot').html('Enviar Credito');
        		if(data.status=="ok"){
            			reloadStructs();
						$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-success">'
					            +'Se envio el credito de forma <a class="alert-link" >Exitosamente</a>!'  
					        	+'</div>'
					        	+'</div>');
					        	
    			}else if(data.status=="credit"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'No posee credito suficiente para realizar dicha acci&oacute;n!'  
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="user"){		
    					$('#error').html(
					             '<div class="row">'
					            +'<div class="alert alert-danger">'
					            +'El enterpise ingresado es <a class="alert-link" >Incorrecto</a>!'
					        	+'</div>'
					        	+'</div>');
				}else if(data.status=="exp"){
            		expire();
            	}else{
            		alert('ocurrio un error');
            	}
            },error: function(error){
            	console.log(error);
            } 
		});	
	}
	
};