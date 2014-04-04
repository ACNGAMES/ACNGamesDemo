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

function rejectChlg(event_id, user_id){
	
};

function acetpChlg(event_id, user_id){
	
};

function cancelChlg(event_id, user_id){
	$.ajax({
            url: 'serverCall/cancelChlgF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:event_id},
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
