<?php 

	$conn = new mysqli("localhost", "root", "", "csonka_mark");

	if($conn->connect_error){
		die("Sikertelen kapcsolódás! ".$conn->connect_error);
	}

?>