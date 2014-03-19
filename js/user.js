
var act = null;
//Esta funcion se encarga de verificar que el usuario y contraseña sean validos
function signIn(){
	//action="loginF.php"
	var em=$('#email').val();
	var ps=hash($('#ps').val());
	
	
	if(ps== "" || em ==""){
		$('#singInForm').attr("class","col-lg-4 has-error");
		$('#error').html("El usuario y/o contraseña no pueden ser vacios<br/>");
		
	}else{
		
		$.ajax({
            url: 'serverCall/loginF.php',
            dataType: "json",
            data: {email:em, ps:ps},
            
            success: function(data) {
				if (data.status == "ok") {
                	var ct ={};
                	ct.email=em;
                	ct.name=data.name;
                	ct.surname=data.surname;
                	ct.auth_token=data.auth_token;
                	ct.user_id=data.user_id;
                	ct.silver=data.silver;
                	ct.gold=data.gold;
                	$.jStorage.set("acnGames.act",ct);
                	act=ct;
                	
                	if(getCoins()){
                		//$('#container').html($.View("views/page.ejs",{username:ct.name}));
						if(location.pathname.indexOf("php")>-1){
                			window.location.href="index.html";
                		}else{
	                		window.location.href="";//load();
    	            	}	
                	}
					
                }else if(data.status == "activate"){
                	aux={};
                	aux.auth_token=data.auth_token;
                	aux.user_id=data.user_id;
                	$('#singInForm').attr("class","col-lg-4");
                	$('#error').html(
                	'<div class="row">'
            				+'<div class="alert alert-danger">'
              					+'La cuenta no esta  <a class="alert-link" >Activada</a>! haga <a href="#" onclick="sendActMail()">click aqui </a>para solicitar el mail de acitcaci&oacute;n'  
        		    		+'</div>'
        		    +'</div>');
                	
                }else if(data.status == "error") {
                	$('#error').html("El usuario y/o contraseña son invalidos<br/>");
                	$('#singInForm').attr("class","col-lg-4 has-error");
				}else{
                	$('#singInForm').attr("class","col-lg-4 has-error");
                	$('#error').html("Ocurio un error por favor intente nuevamente<br/>");
                }
            },
            error: function(error){
				$('#error').html("Ocurio un error por favor intente nuevamente<br/>");
				console.log(error);            	
            }
        });
	}
};

//Esta funcion se encarga de borrar la sesion de las cookies
function signOut(){
	
	//$.jStorage.set("tarjetaP",tarjetaP);
	$.jStorage.deleteKey("acnGames.act");
	act=null;
	document.location.href='index.html';
	window.location="";
};


//Esta funcion se encarga de hacer el singUP
function signUp(){
	//action="registerF.php"
	var nm=$('#name').val();
	var sn=$('#surname').val();
	var id=$('#enterprise').val();
	var ps=hash($('#ps').val());
	var ps2=hash($('#ps2').val());
	
	$('#errorName').html("");
	$('#errorSurname').html("");
	$('#errorEnterprise').html("");
	$('#errorPs').html("");
	$('#msgError').html("");
	$('#msgOk').html("");
	
	if(nm==""){
		$('#signUpForm').attr("class","col-lg-4 has-error");
		$('#errorName').html("Campo nombre está vacio<br/>");
		return;
	}
	
	if(sn==""){
		$('#signUpForm').attr("class","col-lg-4 has-error");
		$('#errorSurname').html("Campo apellido está vacio<br/>");
		return;
	}
	
	if(id==""){
		$('#signUpForm').attr("class","col-lg-4 has-error");
		$('#errorEnterprise').html("Campo enterprise está vacio<br/>");
		return;
	}
	
	if(ps=="" || ps2==""){
		$('#signUpForm').attr("class","col-lg-4 has-error");
		$('#errorPs').html("Campo contraseña está vacio<br/>");
		return;
	}
	
	if(ps!=ps2){
		$('#signUpForm').attr("class","col-lg-4 has-error");
		$('#errorPs').html("Las contraseñas no coincidieron<br/>");
		return;
	
   }else{
	
	$.ajax({
            url: 'serverCall/signUpF.php',
            dataType: "json",
            data: {name:nm, surname:sn, enterprise:id, ps:ps},
            success: function(data) {
            	if (data.status == "ok") {
            		$('#signUpForm').attr("class","form-group input-group has-ok");
                	$('#msgOk').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'Su cuenta ha sido creada <a class="alert-link" >exitosamente</a>!. Vaya a su correo para activar la cuenta'  
        			+'</div>'
        			+'</div>');
					console.log("Entro en el Ok");
                } 
                //if (data.status == "error");
                else {
                	$('#signUpForm').attr("class","form-group input-group has-error");
					$('#msgError').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'La cuenta con el Enterprise que intenta crear <a class="alert-link" >ya existe!</a>!'  
        			+'</div>'
        			+'</div>');
        			console.log("Entro en el Error");
            	}
            },
            
            error: function(error){
            	$('#error').html("Ocurio un error por favor intente nuevamente<br/>");
				console.log(error);
            }   

	});
	
  }

};

//Esta funcion se encarga de generar el hsash para enviar la contraseña encriptada al servidor
function hash(value){

	return passHash = Sha1.hash(value);
	
};


//Esta funcion vlaida que el otken no haya expirado por que secerro la sesion
function valToken(){
	var resp;
	$.ajax({
            url: 'serverCall/valTokenF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            async: false,
            success: function(data) {
            	if(data.status=="ok"){
            		resp= true;
            	}else{
            		resp= false;
            	}
            },error: function(error){
            	resp= false;
            } 

	});
	return resp;
};


//Esta funcion obtiene los creditos del usuario
function getCoins(){
	var resp;
	$.ajax({
            url: 'serverCall/getCrF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token},
            async: false,
            success: function(data) {
            	if(data.status=="ok"){
            		act.silver=data.silver;
            		act.gold=data.gold;
            		$.jStorage.set("acnGames.act",act);
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

var au;
//Esta funcion sirve para solicitar el envio del mial nuevamente
function sendActMail(){
	$.ajax({
            url: 'serverCall/resendF.php',
            dataType: "json",
            data: {id:aux.user_id, auth_token:aux.auth_token},
            success: function(data) {
            	if(data.status=="ok"){
					$('#error').html(
                	'<div class="row">'
                	+'<div class="alert alert-success">'
              		+'La solicitud se ha enviado  <a class="alert-link" >Exitosamente</a>! En minutos recibira un mail con el link de activaci&oacute;n. Por favor verifique que no este en la secci&oacute;n de spam'  
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

//Esta funcion sirve para cambiar contraseña
function changePs(){
		$('#error').html("");
		var ps=$('#ps').val();
		var new_ps=$('#new_ps').val();
		var re_ps=$('#re_ps').val();
		
		//Borro los cuadrads de error
		$('#singInForm').attr("class","container2");
		$('#pass').attr("class","form-group input-group");
		$('#new_pass').attr("class","form-group input-group");
		$('#re_pass').attr("class","form-group input-group");
		
	if(ps== "" || new_ps =="" || re_ps==""){
		$('#singInForm').attr("class","container2 has-error");
		$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Los campos de contraseña, nueva contraseña y verificar nueva contraseña no pueden ser <a class="alert-link" >vacios</a>!'  
        	+'</div>'
        	+'</div>');
	}else if(new_ps!=re_ps){
			$('#new_pass').attr("class","form-group input-group has-error");
			$('#re_pass').attr("class","form-group input-group has-error");
			$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Los campos nueva contraseña y verificar <a class="alert-link" >no coinciden</a>!'  
        	+'</div>'
        	+'</div>');
	}else{
			$.ajax({
            url: 'serverCall/changePsF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, ps:hash(ps), new_ps:hash(new_ps), enterprise:act.email},
            success: function(data) {
            	if (data.status == "ok") {
                	$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'La contraseña se ha cambiado <a class="alert-link" >exitosamente</a>!'  
        			+'</div>'
        			+'</div>');
					
                }else if(data.status == "exp"){
                	expire();
                	
                }else if(data.status == "error") {
                	$('#pass').attr("class","form-group input-group has-error");
					$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'La contraseña es <a class="alert-link" >invalida</a>!'  
        			+'</div>'
        			+'</div>');
				}else{
                	$('#singInForm').attr("class","col-lg-4 has-error");
                	$('#error').html("Ocurio un error por favor intente nuevamente<br/>");
                }
            },error: function(error){
            	$('#error').html("Ocurio un error por favor intente nuevamente<br/>");
				console.log(error);
            } 

	});
		
	}	
};
