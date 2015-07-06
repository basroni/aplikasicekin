<?php 
session_start();

if (empty($_SESSION['username'])){
	header("location:form.php");
}
else{
?>

selamat <b><?php echo $_SESSION['username']?> <br>
<?php echo $_SESSION['id']?></b> Berhasil Masuk <br>
<a href="logout.php">Klik di sini</a> untuk keluar
<?php } ?>	
