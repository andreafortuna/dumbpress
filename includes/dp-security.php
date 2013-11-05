<?php
require_once("dp-config.php");
/*
* DumbPress security functions
*/

function checkUser() {
	if (!isset($_SESSION["loggedin"])) {
		return false;
	} else {
		if ($_SESSION["loggedin"] != "1") {
			return false;
		}
	} 
	return true;
}

function login($username,$password) {
	global $adminusername,$adminpassword;
	if ($username==$adminusername && $password == $adminpassword) {
		$_SESSION['loggedin'] = "1";
		return true;
	}
	return false;
}

function logout() {
	$_SESSION['loggedin'] = "0";
}

?>