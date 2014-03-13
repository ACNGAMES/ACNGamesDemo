//eSTA FUNCION SE ENCARGA DE DIRIGIRSE A LA pagina que corresponda segun exitan o no cookies
function load(){
	
	var value = $.jStorage.get("acnGames.act");
	//console.log(value);
	if(value){
		//TODO Compruebo que las cookies no hayan expirado
		//document.location.href='template.html';
		$('#container').html($.View("views/page.ejs",value));	
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
	$('#container').html($.View("views/register.ejs"));
};
