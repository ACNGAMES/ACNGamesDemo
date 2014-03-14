//eSTA FUNCION SE ENCARGA DE DIRIGIRSE A LA pagina que corresponda segun exitan o no cookies
function load(){
	
	var value = $.jStorage.get("acnGames.act");
	if(value){
		
		act= value;
		if(!valToken()){
			expire();		
		}else{
			$('#container').html($.View("views/page.ejs",value));	
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
};

//Esta funcion dibuja la seccion de epxirado
function expire(){
	$.jStorage.deleteKey("acnGames.act");
			$('#container').html($.View("views/signIn.ejs"));
			$('#error').html(
                	'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Su sessi&oacute;n  ha  <a class="alert-link" >Expirado</a>! Por favor inicie sesi&oacute;n nuevamente'  
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
