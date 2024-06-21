
<?php
define('USER', 'root');
define('PASSWORD', '');
define('HOST', 'localhost:3307');
define('DATABASE', 'tabs');
try
{
	// connect to MySQL database
	$connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
}
catch (PDOException $e)
{
	exit("Error: " . $e->getMessage());
}
?>
