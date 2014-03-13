





function loadRegister(){
	$('#container').html($.View("views/register.ejs"));
};

function signUp(){
	//action="registerF.php"
	var nm=$('#name').val().toString().trim();
	var sn=$('#surname').val().toString().trim();
	var id=$('#enterprise').val().toString().trim();
	var ps=$('#ps').val().toString().trim();
	var ps2=$('#ps2').val().toString().trim();
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
            url: 'registerF.php',
            dataType: "json",
            data: {enterprise:id},
            
            success: function(data) {
            	$('#signUpForm').attr("class","col-lg-4 has-error");
				$('#errorPs').html("Registro OK<br/>");
            }

	});


};

