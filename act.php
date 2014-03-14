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
   
  <body>
    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ACN Games</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a><i class="fa fa-pencil"></i> Registrarse</a></li>
                    <li><a><i class="fa fa-envelope"></i> Contactenos</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <br /><br /><br /><br />
 <div class="container">';
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
	if(validate($id, $at)){
		
	if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
     
  	$sentencia = "DELETE from u970955255_acn.CM_ACTIVATE_ACCT where user_id='$id'"; 
   	mysql_query($sentencia, $iden);
	$SILVER_INIT=5;
	$GOLD_INIT=0;
	$sentencia = "INSERT INTO u970955255_acn.CM_COIN VALUES ('$id',$SILVER_INIT,$GOLD_INIT)"; 
   	mysql_query($sentencia, $iden); 
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
        <h2 class="form-signin-heading">Please sign in</h2>
        <font color="red" id="error"></font>
        <div class="form-group input-group">
            <span class="input-group-addon">Enterprise ID</span>
        	<input type="email" name="email" onkeypress="checkEnter(event)" class="form-control" id="email" placeholder="Email address" required="" autofocus="">
        </div>
        <div class="form-group input-group">
            <span class="input-group-addon">     Password</span>
        	<input type="password" name="ps" onkeypress="checkEnter(event)" class="form-control" id="ps" placeholder="Password" required="">
        </div>

        <br/>
        <a>Olvido su contraseña?</a>
        <br/><br/>
        <button class="btn btn-lg btn-primary btn-block" onclick="signIn()">Sign in</button>      
      </div>
        </div> <!-- /container -->
        </body>
    </html>';
  
?>