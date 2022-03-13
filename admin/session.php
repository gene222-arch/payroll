<?php
	session_start();
	include 'conn.php';

	$timezone = 'Asia/Manila';
	date_default_timezone_set($timezone);

	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: login.php');
	}

	$sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>