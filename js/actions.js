function signOut(){
	
	//$.jStorage.set("tarjetaP",tarjetaP);
	$.jStorage.deleteKey("act");
	act=null;
	document.location.href='index.html';
	window.location="";
};

function load(){
	
	var value = $.jStorage.get("act");
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
	//TODO en esta funcion debo hacer un request a php y storear la informacio nen la cache
	var em=$('#email').val();
	var ps=$('#ps').val();
	
	
	if(ps== "" || em ==""){
		alert('datos invalidos');
	}else{
		$.ajax({
            url: 'loginF.php',
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
                	$.jStorage.set("act",ct);
					$('#container').html($.View("views/page.ejs",{username:ct.name}));      
                
                }else if(data.status == "error") {
                
                	alert('Usuario y contraseña invalidos');
					$('#container').html($.View("views/signIn.ejs"));      
                
                }else{
                	alert('Ocurrio un Error, Por favor intenteloas tarde');
					$('#container').html($.View("views/signIn.ejs"));
                }
				
					
							
				
				
            },
            error: function(error){
				console.log('Ocurrio un error');
				console.log(error);            	
            }

        });
	}
	
	
};

