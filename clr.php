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
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/actions.js"></script>
    <script src="js/jstorage.js"></script>
    <script src="js/jquerymx.min.js"></script>
    
    
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
   //TODO aca tengo que llamar a una pantalla de error      
  echo '<div class="row">
            <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="alert alert-danger">
              El link al que desea ingresar es <a class="alert-link" >incorrecto</a>! para empezar a jugar por favor inicie sesi&oacute;n o registrese 
            </div>
          </div>
        </div><!-- /.row -->
     <div class="col-lg-4"> </div>
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
}else{
  $id = $_GET[1];
  $at = $_GET[2];
  //echo $id.' '.$at;
  echo '        <div class="row">
            <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="alert alert-info">
              }por favor ingrese su <a class="alert-link" >Nueva</a> contraseña 
            </div>
          </div>
        </div><!-- /.row -->
        <div class="col-lg-3"></div>
      <div class="col-lg-5">
        <div class="jumbotron">
        <div id="singInForm" class="container2">
            <h2 class="form-signin-heading">Ingrese su nueva contraseña</h2>
            <font color="red" id="error"></font>
            <div class="form-group input-group">
            <span class="input-group-addon">New Password</span>
        	<input type="password" name="new_ps" class="form-control" id="ps" onkeypress="checkEnter2(event)" placeholder="New Password" required="">
        	</div>
            <div class="form-group input-group">
            <span class="input-group-addon">Re- Password</span>
        	<input type="password" name="re_ps" class="form-control" id="ps" onkeypress="checkEnter2(event)" placeholder="Re-New Password" required="">
        	</div>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" onclick="restorePs()">Cambiar Contreña</button>
        </div>
        </div>
              
      </div>
      </div>';
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