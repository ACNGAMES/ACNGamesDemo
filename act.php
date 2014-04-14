<?php  
echo '<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/signin/ -->

<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ACN Games </title>
    
    <!-- Core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/signin/signin.css" rel="stylesheet">
    <!-- Core JS -->
    <script src="js/head.min.js"></script>
    
    
    
   </head>
   
  <body id="container">
    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">ACN Games</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="loadRegister()"><i class="fa fa-pencil"></i> Registrarse</a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i> Contactenos</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <br /><br /><br /><br />
 <div class="container">
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Terminos y Condiciones</h4>
      </div>
      <div class="modal-body" id="terms-body">
        
    </div>
  </div>
</div>
</div>	
 
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Restaurar Contraseña</h4>
      </div>
      <div class="modal-body">
        <div id="error-modal"></div>
        <div class="row">
            <div class="col-lg-1"></div>
        Para blanquear la contraseña ingrese su enterprise Id.
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="form-group input-group col-lg-6">
                <span class="input-group-addon">Enterprise</span>
                <input type="email" name="email" class="form-control" id="enterprise" placeholder="Enterprise ID" required="" autofocus="true">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="processRestBot" type="button" data-dismiss="modal" onclick="restorePass()" class="btn btn-primary">Continuar</button>
      </div>
    </div>
  </div>
</div>  
 ';
if(count($_GET)!=2 || !isset($_GET[1]) || !isset($_GET[2])){
   //Pantalla de error      
  echo '<div class="row">
            <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="alert alert-danger">
              El link al que desea ingresar es <a class="alert-link" >incorrecto</a>! para empezar a jugar por favor inicie sesi&oacute;n o registrese  
            </div>
          </div>
        </div><!-- /.row -->';
    
}else{
  $id = $_GET[1];
  $at = $_GET[2];
  include 'serverCall/valF.php';
	if(validateAct($id, $at)){
		
	
  	if (!($iden = db_connection())){
        die("Error: No se pudo conectar".mysql_error()); 
  	}
    
    $db="u157368432_acn"; 
  	$sentencia = "DELETE from $db.CM_ACTIVATE_ACCT where user_id='$id'"; 
   	mysql_query($sentencia, $iden);
	$SILVER_INIT=0;
	$GOLD_INIT=5;
	$sentencia = "INSERT INTO $db.CM_COIN VALUES ('$id',$SILVER_INIT,$GOLD_INIT)";
	mysql_query($sentencia, $iden);
	$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, SILVER, GOLD, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'C','ACN GAMES le envia credito',$SILVER_INIT,$GOLD_INIT,$SILVER_INIT,$GOLD_INIT)";
	mysql_query($sentencia, $iden);
	//$sentencia = "INSERT INTO $db.CM_ALERT(USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ('$id','AG','Gracias por activar su cuenta.',NOW())"; 
   	//mysql_query($sentencia, $iden); 
	mysql_close($iden);	
	echo '        <div class="row">
            <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="alert alert-success">
              Gracias por activar su cuenta de <a class="alert-link" >ACN  Games</a>! para empezar a jugar por favor inicie sesi&oacute;n 
            </div>
          </div>
        </div><!-- /.row -->';	
	
	}else{
		echo '<div class="row">
            <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="alert alert-danger">
              El link al que desea ingresar es <a class="alert-link" >incorrecto</a>! para empezar a jugar por favor inicie sesi&oacute;n o registrese  
            </div>
          </div>
        </div><!-- /.row -->';
	}
  
  } 

   echo '<div class="col-lg-4"> </div>
      <div class="col-lg-4" id="singInForm">
        <h2 class="form-signin-heading">Por favor Inicie Sesi&oacute;n</h2>
        <div id="error"></div>
        <div class="form-group input-group">
            <span class="input-group-addon">Enterprise ID</span>
        	<input type="email" name="email" onkeypress="checkEnter(event)" class="form-control" id="email" placeholder="Enterprise ID" required="" autofocus="true">
        </div>
        <div class="form-group input-group">
            <span class="input-group-addon">     Password</span>
        	<input type="password" name="ps" onkeypress="checkEnter(event)" class="form-control" id="ps" placeholder="Password" required="">
        </div>

        <br/>
        <a data-toggle="modal" href="#" data-target="#myModal">¿Olvidó su contraseña?</a>
        <br/><br/>
        <button id="signInBot" class="btn btn-lg btn-primary btn-block" onclick="signIn()">Iniciar Sesi&oacute;n</button>      
      </div>
        </div> <!-- /container -->
  		<div class="container">

        <hr>

        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <p>Copyright &copy; Company 2014 - <a data-toggle="modal" href="#" data-target="#termsModal" onclick="terms()">Reglas, Terminos y Condiciones</a></p>
                </div>
            </div>
        </footer>

    </div>
        </body>
    </html>';
  
?>