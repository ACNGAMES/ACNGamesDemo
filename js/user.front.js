//eSTA FUNCION SE ENCARGA DE DIRIGIRSE A LA pagina que corresponda segun exitan o no cookies
function load(){
	
	var value = $.jStorage.get("acnGames.act");
	if(value){
		
		act= value;
		if(!valToken()){
			expire();		
		}else{
			loadPageEstruct();
				
		};
	}else{
		$('#container').html($.View("views/signIn.ejs"));
	}
	
};

//Esta funcion verifica el enter en un formulario de login
function checkEnter(event)
{
    if (event.keyCode == 13) 
   {
       signIn();
       
    }
};

//Esta funcion dibuja el formulario para cambiar de contrasña
function changePass(){
	$('#pagina_central').html($.View("views/changePass.ejs"));	
	
};

//Esta funcion dibuja el formulario para crear cuenta
function loadRegister(){
	$('#container').html($.View("views/signUp.ejs"));
	$(function() {
    	$('#ps').tooltip({placement: 'right'});
	});
};

//Esta funcion dibuja la seccion de epxirado
function expire(){
	$.jStorage.deleteKey("acnGames.act");
			$('#container').html($.View("views/signIn.ejs"));
			$('#error').html(
                	'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Su sesi&oacute;n  ha  <a class="alert-link" >Expirado</a>! Por favor inicie sesi&oacute;n nuevamente'  
        	   		+'</div>'
        		    +'</div>');
};


//Esta funcion verifica el enter en un formulario de changepassword
function checkEnter2(event)
{
    if (event.keyCode == 13) 
   {
      changePs();
       
    }
};

//Esta funcion redibuja los creditos
function reloadCredit(){

   if(getCoins()) {
       $('#credit').html(Number(act.silver)+Number(act.gold)+" Cr.");
   }

};


function creditMoves(){
	getNewAlerts();
	$.ajax({
            url: 'serverCall/getCrMovesF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/crMovesView.ejs",data.moves));				            		
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


function pricesView(msg){
	$.ajax({
            url: 'serverCall/getPricesF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/pricesView.ejs",{products:data.products, silver:act.silver}));
					if(msg==true){
						$('#error').html(
             			'<div class="row">'
            			+'<div class="alert alert-success">'
            			+'Su pedido se ha realizado <a class="alert-link" >exitosamente</a>! En cuesti&oacute;n de d&iacute;as le estaremos entregando su premio. Muchas Gracia.'  
        				+'</div>'
        				+'</div>');
					}else if(msg==false){
						$('#error').html(
             			'<div class="row">'
            			+'<div class="alert alert-danger">'
            			+'Su pedido <a class="alert-link" >no</a> se ha realizado! Puede que no posee credito suficiente o se encuentre agotado. Disculpe las molestias, muchas Gracias.'  
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


function betsView(action){
	$.ajax({
            url: 'serverCall/getActiveBetsF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/betsView.ejs",data.bets));
					chlgBadges();
					if(action==1){
						$('#error').html(
	                	'<div class="row">'
	                	+'<div class="alert alert-success">'
	              		+'La apuesta se ha cancelado <a class="alert-link" >Exitosamente</a>!'  
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


function endBetsView(){
	$.ajax({
            url: 'serverCall/getEndBetsF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/endBetsView.ejs",data.bets));
					chlgBadges();	            		
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


function challengeView(msg){
	$.ajax({
            url: 'serverCall/getChallengesF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/challengeView.ejs",data.challenges));
					chlgBadges();
					if(msg==true){
						$('#error').html(
	                	'<div class="row">'
	                	+'<div class="alert alert-success">'
	              		+'El desafio se ha cancelado <a class="alert-link" >Exitosamente</a>!'  
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

function chlgPendingView(msg){
	$.ajax({
            url: 'serverCall/getChlgPendingF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/chlgPendingView.ejs",data.challenges));
					chlgBadges();
					
					if(msg==true){
						$('#error').html(
	                	'<div class="row">'
	                	+'<div class="alert alert-success">'
	              		+'El desafio se ha rechazado <a class="alert-link" >Exitosamente</a>!'  
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


function chlgBadges(){
	$.ajax({
            url: 'serverCall/getChlgQtyF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					
					$('#pending').html(data.pending);
					$('#requests').html(data.request);
									            		
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

function openEvent(id){
	$.ajax({
            url: 'serverCall/getEventF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, event_id:id},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/eventView.ejs", data.evt[0]));
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


function reloadChallengeView(){
	$.ajax({
            url: 'serverCall/getChlgPendingF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#container2').html($.View("views/pendingChlgList.ejs",data.challenges));
					chlgBadges();
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