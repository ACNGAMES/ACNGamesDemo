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
		$('#container').html($.View("views/page.ejs",{username:value.name}));	
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



