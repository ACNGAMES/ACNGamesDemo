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


function pricesView(){
	$.ajax({
            url: 'serverCall/getPricesF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llaamr al view q	uw dibuje los movimientos
					$('#pagina_central').html($.View("views/pricesView.ejs",{products:data.products, silver:act.silver}));				            		
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
