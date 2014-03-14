<<<<<<< HEAD
function signOut(){
	
	//$.jStorage.set("tarjetaP",tarjetaP);
	$.jStorage.deleteKey("acnGames.act");
	act=null;
	document.location.href='index.html';
	window.location="";
};

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
var act = null;
function signIn(){
	//action="loginF.php"
	var em=$('#email').val();
	var ps=$('#ps').val();
	
	
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
                	ct.user_id=data.id;
                	$.jStorage.set("acnGames.act",ct);
					//$('#container').html($.View("views/page.ejs",{username:ct.name}));
					if(location.pathname.indexOf("php")>-1){
                		window.location.href="index.html";
                	}else{
                		window.location.href="";//load();
                	}
                	
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


function checkEnter(event)
{
    if (event.keyCode == 13) 
   {
       signIn();
       
    }
};

function changePass(){
	$('#pagina_central').html($.View("views/changePass.ejs"));	
	
};

function loadRegister(){
	$('#container').html($.View("views/register.ejs"));
};

function signUp(){
	//.toString().trim()
	var nm=$('#name').val();
	var sn=$('#surname').val();
	var id=$('#enterprise').val();
	var ps=$('#ps').val();
	var ps2=$('#ps2').val();
	var flag=true;
	
	$('#errorName').html("");
	$('#errorSurname').html("");
	$('#errorEnterprise').html("");
	$('#errorPs').html("");
	
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
	}
	
	$.ajax({
            url: 'serverCall/registerF.php',
            dataType: "json",
            data: {name:nm, surname:sn, enterprise:id, ps:ps},
            
            success: !function(data) {
            	$('#signUpForm').attr("class","col-lg-4 has-error");
				$('#errorPs').html("Registro OK<br/>");
				console.log(data);
            },
            error: function(error){
				$('#error').html("Ocurio un error por favor intente nuevamente<br/>");
				console.log("Error de conexion");            	
            }

	});


};

=======
>>>>>>> b95391c1735a08c4e4eda15ce252abe0f65646fa
