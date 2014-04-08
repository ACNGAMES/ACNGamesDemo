var bet_id=0;
var safety_id=0;
function makeBet(amount, descr, newID){
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
	//TODO hacer un fetch del evento y deibujar la apuesta tengo que traer
	//TODO: monto apuesta
	//TODO oponentes
	//TODO descripcion  
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
	
};

function editBet(event_id){
	
};

function sendBet(event_id){
	
};

function makeChlg(event_id){
	
};

function processChallenge(event_id, user_opp){
	$('#processChallenge').attr("disabled","disabled");
	$('#processChallenge').html('<i class="fa fa-spinner fa-spin"></i> Aceptando');
	$('#myModal').modal('hide');	
	$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'No posee credito suficiente para axptar el Desafio!'  
        	+'</div>'
        	+'</div>');
    
    $('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Ya posee una apuesta asociada a ese evento. Debe cancelarla para aceptar el desafio!'  
        	+'</div>'
        	+'</div>');
        	
        	$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-success">'
            +'El desafio ha sido aceptado <a class="alert-link" >Exitosamente</a>!'  
        	+'</div>'
        	+'</div>');
};
