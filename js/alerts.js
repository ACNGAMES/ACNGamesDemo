function viewAlerts(){
	getNewAlerts();
	$.ajax({
            url: 'serverCall/getAlertListF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje las alertas
					$('#pagina_central').html($.View("views/alertView.ejs",data.alerts));				            		
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

function getNewAlerts(){
	$.ajax({
            url: 'serverCall/getAlertHeaderF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje las alertas
					$('#alertas').html($.View("views/alertHeader.ejs",data.alerts));
					            		
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


function navEvent(nav_key,id){
	if(markCheck(id)){
		chlgPendingView();	
	}
};	
	                		
function navBet(id){
	if(markCheck(id)){
		endBetsView();
	}
};
	                	
function navCred(id){
	if(markCheck(id)){
		creditMoves();
	}
};
	                	
function navRead(id){
	markCheck(id);

};

function markCheck(id){
	var resp;
	$.ajax({
            url: 'serverCall/alertCheckF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, alert_id:id},
            async: false,
            success: function(data) {
            	if(data.status=="ok"){
            		getNewAlerts();
            		resp =true;
            	}else if(data.status=="exp"){
            		expire();
            		resp =false;
            	}else{
            		alert('ocurrio un error');
            		resp =false;;
            	}
            },error: function(error){
            	resp =false;
            	console.log(error);
            } 

	});
	return resp;
};