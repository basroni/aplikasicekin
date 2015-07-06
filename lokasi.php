<?php
	session_start();
	include "koneksi.php";
	$lokasi=$_POST['lokasi'];
	//$sql="update armada set lat='$lat', long='$lon' where id='$_SESSION[id]'";
	$sql="update armada set status='$lokasi' where id='$_SESSION[id]'";
	$query=mysql_query($sql) or die($sql);
	//$data=mysql_fetch_array($query);
	header('Location:petadinamis.php'); 
?>