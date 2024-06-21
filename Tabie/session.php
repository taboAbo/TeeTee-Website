<?php
// start the session
session_start();
// user already logged in, then redirect user to welcome page
if(isset($_SESSION['user_name']) && ($_SESSION['user_name']) === true)
{
	header('location: welcome.php');
    exit;
}
?>
