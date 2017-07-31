<?php
/**
 * Enabling all PHP errors and warnings. Development purposes only.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  

/**
 * Start the session and check if user is logged in.
 */
session_start();
if(empty($_SESSION['uid'])){
	header('Location:login.php');
	die();
}

/**
 * Require the global configuration file 
 */
require('config.php');

/**
 * Register autoloader function, so the environment is able to automatically call any classes stored in the /classes/ 
 */
function class_autoloader($class) {
  	include('./classes/class-'.$class.'.php');
}
spl_autoload_register('class_autoloader');

/**
 * If there's action parameter defined with the url, just include controller.php which handles all the actions towards the database
 */
if(!empty($_GET['action']))
	$doaction = new Controller($_GET['action'], $_POST);

/**
 * The actual page starts, firstly we include templates for header and navigation
 */
require_once('templates/header.php');
require_once('templates/mainnavi.php');

/**
 * If there's a 'p' (page) parameter defined with the url, we check if it really is a valid template file to include. Otherwise including 404.php.
 * If there's not parameter defined, just include template for homepage
 */
if(!empty($_GET['p'])){
	if(file_exists('pages/'.$_GET['p'].'.php'))
		require_once('pages/'.$_GET['p'].'.php');
	else
		require_once('pages/404.php');
}
else{
	require_once('pages/home.php');
}

/**
 * Include template for footer, which includes also all the javascript code
 */
require_once('templates/footer.php');