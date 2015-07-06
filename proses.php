<?php
//memanggil file koneksi php
include "koneksi.php";
//membuat variable dengan nilai dari form
$username = $_POST['username'];
$password = ($_POST['password']);

$perintah = "select * from armada WHERE username='$username' AND password='$password'";
$hasil = mysql_query($perintah);
$row =  mysql_fetch_array($hasil);

if ($row['username']==$username AND $row['password']==$password)
{
	session_start();
	
	$_SESSION['id']=$row['id'];
	
	$_SESSION['username']=$username;
	
	$_SESSION['foto']=$foto;
	header("location:petadinamis.php");	
}
else{
	echo "Gagal Masuk";
}	
?>