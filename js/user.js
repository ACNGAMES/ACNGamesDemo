
var act = null;
//Esta funcion se encarga de verificar que el usuario y contraseña sean validos
function signIn(){
	//action="loginF.php"
	var em=$('#email').val();
	var ps=hash($('#ps').val());
	
	
	$('#signInBot').attr("disabled","disabled");
	$('#signInBot').html('<i class="fa fa-spinner fa-spin"></i> Iniciando'); 
	if(ps== "" || em ==""){
		$('#signInBot').removeAttr("disabled");
		$('#signInBot').html('Iniciar Sesi&oacute;n'); 
		$('#singInForm').attr("class","col-lg-4 has-error");
		$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'El usuario y/o contraseña no pueden ser <a class="alert-link" >vac&iacute;os</a>!'  
        	+'</div>'
        	+'</div>');
		
		
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
                	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4");
                	$('#signInBot').removeAttr("disabled");
					$('#signInBot').html('Iniciar Sesi&oacute;n'); 
                	$('#error').html(
                	'<div class="row">'
            				+'<div class="alert alert-danger">'
              					+'La cuenta no est&aacute;  <a class="alert-link" >Activada</a>! haga <a href="#" onclick="sendActMail()">click aqui </a>para solicitar el mail de activaci&oacute;n'  
        		    		+'</div>'
        		    +'</div>');
                	
                }else if(data.status == "error") {
                	$('#signInBot').removeAttr("disabled");
					$('#signInBot').html('Iniciar Sesi&oacute;n'); 
                	$('#error').html(
             			'<div class="row">'
          				  +'<div class="alert alert-danger">'
            			  +'El usuario y/o contraseña son <a class="alert-link" >inv&aacute;lidos</a>!'  
        				  +'</div>'
        				  +'</div>');
                	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4 has-error");
				}else{
                	$('#signInBot').removeAttr("disabled");
					$('#signInBot').html('Iniciar Sesi&oacute;n');
                	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4 has-error");
                	$('#error').html(
             			'<div class="row">'
          				  +'<div class="alert alert-danger">'
            			  +'Ocurri&oacute; un error. Por favor intente nuevamente'  
        				  +'</div>'
        				  +'</div>');
                }
            },
            error: function(error){
				$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
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
	var tc=$('#termsFlg:checked').val();
	$('#errorName').html("");
	$('#errorSurname').html("");
	$('#errorEnterprise').html("");
	$('#errorPs').html("");
	$('#msg').html("");
	
	if(tc!="true"){
		$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Debe aceptar los <a class="alert-link" >T&eacute;rminos y Condiciones de Uso</a>!'  
        			+'</div>'
        			+'</div>');
			return;
	}
	
	
	$('#signUpBot').attr("disabled","disabled");
	$('#signUpBot').html('<i class="fa fa-spinner fa-spin"></i> Registrando'); 
	if(nm==""){
		$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6 has-error");
		$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'El Campo nombre no puede ser <a class="alert-link" >vac&iacute;o</a>!'  
        			+'</div>'
        			+'</div>');
		$('#signUpBot').removeAttr("disabled");
		$('#signUpBot').html('Registrarse');
		return;
	}
	
	if(sn==""){
		$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6 has-error");
		$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'El Campo Apellido no puede ser <a class="alert-link" >vac&iacute;o</a>!'  
        			+'</div>'
        			+'</div>');
		$('#signUpBot').removeAttr("disabled");
		$('#signUpBot').html('Registrarse');
		return;
	}
	
	if(id==""){
		$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6 has-error");
		$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'El Campo Enterprise no puede ser <a class="alert-link" >vac&iacute;o</a>!'  
        			+'</div>'
        			+'</div>');
		$('#signUpBot').removeAttr("disabled");
		$('#signUpBot').html('Registrarse');
		return;
	}
	
	if(ps=="" || ps2==""){
		$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6 has-error");
		$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'El Campo Contraseña no puede ser <a class="alert-link" >vac&iacute;o</a>!'  
        			+'</div>'
        			+'</div>');
		$('#signUpBot').removeAttr("disabled");
		$('#signUpBot').html('Registrarse');
		return;
	}
	
	if(ps!=ps2){
		$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6 has-error");
		$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'El campo Contraseña y su verificaci&oacute;n no <a class="alert-link" >coinciden</a>!'  
        			+'</div>'
        			+'</div>');
		$('#signUpBot').removeAttr("disabled");
		$('#signUpBot').html('Registrarse');
		return;
	
   }else{
	
	$.ajax({
            url: 'serverCall/signUpF.php',
            dataType: "json",
            data: {name:nm, surname:sn, enterprise:id, ps:ps},
            success: function(data) {
            	if (data.status == "ok") {
            		$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6");
            		//$('#signUpForm').attr("class","form-group input-group has-ok");
                	$('#signUpBot').removeAttr("disabled");
					$('#signUpBot').html('Registrarse');
                	$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'Su cuenta de <a class="alert-link" >ACN Games</a> ha sido creada <a class="alert-link" >exitosamente</a>!' 
            		+'En minutos recibir&aacute; un mail con el link de activaci&oacute;n. Por favor verifique que no se encuentre en la secci&oacute;n de spam'  
        			+'</div>'
        			+'</div>');
					
                } 
                //if (data.status == "error");
                else {
                	$('#signUpForm').attr("class","col-sm-6 col-md-6 col-lg-6 has-error");
                	//$('#signUpForm').attr("class","form-group input-group has-error");
					$('#signUpBot').removeAttr("disabled");
					$('#signUpBot').html('Registrarse');
					$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'La cuenta con el Enterprise que intenta crear <a class="alert-link" >ya existe!</a>!'  
        			+'</div>'
        			+'</div>');
        			
            	}
            },
            
            error: function(error){
            	$('#msg').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Ocurrio un error. Por favor intente nuevamente!'  
        			+'</div>'
        			+'</div>');
				$('#signUpBot').removeAttr("disabled");
				$('#signUpBot').html('Registrarse');
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
              		+'La solicitud se ha enviado  <a class="alert-link" >Exitosamente</a>! En minutos recibir&aacute; un mail con el link de activaci&oacute;n. Por favor verifique que no se encuentre en la secci&oacute;n de spam'  
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
		
		
		$('#changePsBot').attr("disabled","disabled");
		$('#changePsBot').html('<i class="fa fa-spinner fa-spin"></i> Cambiando'); 
		//Borro los cuadrads de error
		$('#singInForm').attr("class","container2");
		$('#pass').attr("class","form-group input-group");
		$('#new_pass').attr("class","form-group input-group");
		$('#re_pass').attr("class","form-group input-group");
		
	if(ps== "" || new_ps =="" || re_ps==""){
		$('#changePsBot').removeAttr("disabled");
		$('#changePsBot').html('Cambiar Contreña'); 
		$('#singInForm').attr("class","container2 has-error");
		$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Los campos de contraseña, nueva contraseña y verificar nueva contraseña no pueden ser <a class="alert-link" >vac&iacute;os</a>!'  
        	+'</div>'
        	+'</div>');
	}else if(new_ps!=re_ps){
			$('#changePsBot').removeAttr("disabled");
			$('#changePsBot').html('Cambiar Contreña'); 
			$('#new_pass').attr("class","form-group input-group has-error");
			$('#re_pass').attr("class","form-group input-group has-error");
			$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Los campos nueva contraseña y verificar nueva contraseña <a class="alert-link" >no coinciden</a>!'  
        	+'</div>'
        	+'</div>');
	}else{
			$.ajax({
            url: 'serverCall/changePsF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, ps:hash(ps), new_ps:hash(new_ps), enterprise:act.email},
            success: function(data) {
            	if (data.status == "ok") {
                	$('#changePsBot').removeAttr("disabled");
					$('#changePsBot').html('Cambiar Contreña');
                	$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'La contraseña se ha cambiado <a class="alert-link" >exitosamente</a>!'  
        			+'</div>'
        			+'</div>');
					
                }else if(data.status == "exp"){
                	expire();
                	
                }else if(data.status == "error") {
                	$('#changePsBot').removeAttr("disabled");
					$('#changePsBot').html('Cambiar Contreña');
                	$('#pass').attr("class","form-group input-group has-error");
					$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'La contraseña es <a class="alert-link" >inv&aacute;lida</a>!'  
        			+'</div>'
        			+'</div>');
				}else{
                	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4 has-error");
                	$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
                	$('#changePsBot').removeAttr("disabled");
					$('#changePsBot').html('Cambiar Contreña');
                }
            },error: function(error){
            	$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
				console.log(error);
            } 

	});
		
	}	
};


//Esta funcion sirve para enviar la solicitud de blanqueo de contraseña
function restorePass(){
	$('#error').html("");
	enterprise = $('#enterprise').val();
	
	$('#processRestBot').attr("disabled","disabled");
	$('#processRestBot').html('<i class="fa fa-spinner fa-spin"></i> Procesando'); 
	if(enterprise==""){
		$('#processRestBot').removeAttr("disabled");
		$('#processRestBot').html('Continuar');
		$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'El Enterprise Id para <a class="alert-link">blanquear contraseña</a> no puede ser <a class="alert-link" >vac&iacute;o</a>!'  
        	+'</div>'
        	+'</div>');
        $('#myModal').modal('hide');	
	}else{
		$.ajax({
            url: 'serverCall/restoreF.php',
            dataType: "json",
            data: {enterprise:enterprise},
            success: function(data) {
            	if (data.status == "ok") {
                	$('#processRestBot').removeAttr("disabled");
					$('#processRestBot').html('Continuar');
                	$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'Se ha enviado un mail para finalizar el <a class="alert-link">blanqueo de contraseña</a>.<br/>' 
            		+'Verifique que no se encuentre en la secci&oacute;n de Spam. Gracias!'  
        			+'</div>'
        			+'</div>');
					$('#myModal').modal('hide');
                }else if(data.status == "error") {
                	$('#processRestBot').removeAttr("disabled");
					$('#processRestBot').html('Continuar');
                	$('#pass').attr("class","form-group input-group has-error");
					$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'El Enterprise Id ingresado es <a class="alert-link" >inv&aacute;lido</a>!'  
        			+'</div>'
        			+'</div>');
        			$('#myModal').modal('hide');
				}else{
					$('#processRestBot').removeAttr("disabled");
					$('#processRestBot').html('Continuar');
                	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4 has-error");
                	$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
                	$('#myModal').modal('hide');
                }
            },error: function(error){
            	$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
            	$('#processRestBot').removeAttr("disabled");
				$('#processRestBot').html('Continuar');
				$('#myModal').modal('hide');
				console.log(error);
            } 

	});
		
	}
	
};

//Esta funcion se llama desde el link enviado
function restorePs(){
	
	//console.log(window.location.search);
	str=window.location.search;
	var res = str.split("&");
	id = res[0].split("=")[1];
	at = res[1].split("=")[1];
	$('#error').html("");
	var new_ps=$('#new_ps').val();
	var re_ps=$('#re_ps').val();
		
	$('#restoreBot').attr("disabled","disabled");
	$('#restoreBot').html('<i class="fa fa-spinner fa-spin"></i> Cambiando'); 
	//Borro los cuadrads de error
	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4");
	$('#pass').attr("class","form-group input-group");
	$('#new_pass').attr("class","form-group input-group");
	$('#re_pass').attr("class","form-group input-group");
		
	if(new_ps =="" || re_ps==""){
		$('#restoreBot').removeAttr("disabled");
		$('#restoreBot').html('Cambiar Contreña'); 
		$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4 has-error");
		$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Los campos de nueva contraseña y verificar nueva contraseña no pueden ser <a class="alert-link" >vac&iacute;os</a>!'  
        	+'</div>'
        	+'</div>');
	}else if(new_ps!=re_ps){
		$('#restoreBot').removeAttr("disabled");
		$('#restoreBot').html('Cambiar Contreña');
		$('#new_pass').attr("class","form-group input-group has-error");
		$('#re_pass').attr("class","form-group input-group has-error");
		$('#error').html(
             '<div class="row">'
            +'<div class="alert alert-danger">'
            +'Los campos nueva contraseña y verificar nueva contraseña <a class="alert-link" >no coinciden</a>!'  
        	+'</div>'
        	+'</div>');
	}else{
			$.ajax({
            url: 'serverCall/restorePsF.php',
            dataType: "json",
            data: {id:id,auth_token:at, new_ps:hash(new_ps)},
            success: function(data) {
            	if (data.status == "ok") {
					$('#restoreBot').removeAttr("disabled");
					$('#restoreBot').html('Cambiar Contreña');
					$('#container').html($.View("views/signIn.ejs"));                	
                	$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-success">'
            		+'La contraseña se ha cambiado <a class="alert-link" >exitosamente</a>!'  
        			+'</div>'
        			+'</div>');
					
                }else if(data.status == "error") {
                	$('#restoreBot').removeAttr("disabled");
					$('#restoreBot').html('Cambiar Contreña');
                	$('#error').html(
             		'<div class="row">'
            		+'<div class="alert alert-danger">'
            		+'Ha ocurrido un error o el link ha <a class="alert-link" >expirado</a>!'  
        			+'</div>'
        			+'</div>');
				}else{
                	$('#restoreBot').removeAttr("disabled");
					$('#restoreBot').html('Cambiar Contreña');
                	$('#singInForm').attr("class","col-sm-6 col-md-4 col-lg-4 has-error");
                	$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
                }
            },error: function(error){
            	$('#error').html("Ocurri&oacute; un error. Por favor intente nuevamente<br/>");
				console.log(error);
            } 

	});
		
	}	
	
};


function requestPrd(prod_id){
	$.ajax({
            url: 'serverCall/reqPricesF.php',
            dataType: "json",
            data: {id:act.user_id, auth_token:act.auth_token, prod_id:prod_id},
            success: function(data) {
            	if(data.status=="ok"){
					// aca tengo que llamar al view q	uw dibuje los movimientos
					pricesView(true);
					reloadCredit();      		
            	}else if(data.status=="exp"){
            		expire();
            	}else if(data.status=="disp"){
            		pricesView(false);
            	}else{
            		alert('ocurrio un error');
            	}
            	
            },error: function(error){
            	console.log(error);
            } 

	});	
	
};
