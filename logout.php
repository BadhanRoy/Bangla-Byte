<?php
session_start();

// unset session variables
$_SESSION = array();

session_destroy();

// return login page
header("Location: login.php");
exit();
?>