<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>


<?php
// Logs out by completely deleting all session data and setting a cookie to the past.

session_start();
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
redirect_to("login.php");

?>
<?php ob_end_flush() ?>