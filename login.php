<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  
require_once('config.php');
session_start();

//If user is already logged in, he will be redirected to front page  
if(!empty($_SESSION['username'])){
  	header('Location:'.PATH);
  	die('Olet jo kirjautunut sisään!');
}

if(!empty($_POST)):
  	require_once('classes/class-User.php');
  	$reglog = new User();
	
	if(isset($_POST['login'])){
		$data = $_POST['login'];
		$status = $reglog->checkLogin($data['uacc'], $data['upwd']);
		
		if($status == true){
			$_SESSION['uid'] = $reglog->uid;
			$_SESSION['username'] = $reglog->ureal;
			header('Location:'.PATH);	
		}
	}
	elseif(isset($_POST['reg'])){
		$data = $_POST['reg'];
		$register = $reglog->RegisterNewUser($data);
	}
endif;
require_once('templates/header.php');
?>

<div class="row">
	<div class="col-sm-2"></div>
		<div class="col-sm-3">
			<div>
				<h2>Login</h2>
				<form name="login" method="post" action="">
					
					<fieldset> 
					  <p><input type="text" name="login[uacc]" placeholder="Username" required></p>
					  <p><input type="password" name="login[upwd]" placeholder="Password" required></p>
					</fieldset>

					<p><button type="submit" class="btn btn-default">Login</button></p>    
				</form>
			</div>
		</div>
		<div class="col-sm-2 divider"><span class="big_divider">OR</span></div>
		<div class="col-sm-3">
			<div>
				<h2>Register</h2>
				<form name="register" method="post" action="">

					<fieldset>
					  	<p><input type="text" name="reg[uacc]" placeholder="Username" required/></p>
						<p><input type="text" name="reg[ureal]" placeholder="Real name" required/></p>
					  	<p><input type="text" name="reg[upwd]" placeholder="Password" required/></p>
					  	<p><input type="text" name="reg[conf_upwd]" placeholder="Confirm password" required/></p>
					</fieldset> 

					<p><button type="submit" class="btn btn-default">Register</button></p>            
				</form>
			</div>
		</div>     
</div>    
<?php require_once('templates/footer.php');?>