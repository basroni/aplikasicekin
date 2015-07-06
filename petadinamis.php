<?php
	session_start();
	include "koneksi.php";
?>
<!DOCTYPE>
<html>
<head>
<!-- <script type="text/javascript" src="jquery-1.6.2.min.js"></script> -->
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<style>
	html{
		height:100%;	
	}
	body{
		height:100%;	
	}
	#canvas{
		height:100%;	
	}
</style>
<title>Player Activity Manager</title>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCeCAhmBV1aJRpEyTpQzwZV-NS_zIfGdSE&sensor=false&language=id"></script>
<script type="text/javascript">

	//Mendeklarasikan Array untuk menampung marker dan balloon yang ada sehingga mempermudah saat memanggilnya kembali
	var markers=new Array();
	var infowindows=new Array();
	
	var refreshId2 = setInterval(function(){navigator.geolocation.getCurrentPosition(foundLocation, noLocation);}, 3000);
	
	function noLocation() {
		alert("Sensor GPS tidak ditemukan");
	}
	
	function foundLocation(position) {
		var lat2 = position.coords.latitude;
		var lon2 = position.coords.longitude;
		    
		
		var uri = "simpandata.php";		
		$.ajax({
			type: 'POST',
			async: false,
			dataType: "html",
			url: uri,
			data: "lat="+lat2+"&long="+lon2,
			success: function(data) {
					
			}
		});
	}

	
	//Melakukan refresh setiap beberapa detik sekali
	var refreshId = setInterval(function(){updatedata();}, 3000);
	
		function updatedata(){			
			var lat=0;
			var long=0;
						
			for(var i=0;i<markers.length;i++){
								
				var uri = "ambildata.php";		
				$.ajax({
					type: 'POST',
					async: false,
					dataType: "html",
					url: uri,
					data: "id="+i,
					success: function(data) {
						lat=data;
					}
				});
				
				var uri = "ambildata2.php";		
				$.ajax({
					type: 'POST',
					async: false,
					dataType: "html",
					url: uri,
					data: "id="+i,
					success: function(data) {
						long = data;		
					}
				});
				
				var myLatLng = new google.maps.LatLng(lat, long);				
				markers[i].setPosition(myLatLng);	
				infowindows[i].setPosition(myLatLng);	
				
			}
			
		}
	
	function initialize(){
		var myLatLng = new google.maps.LatLng(-1.48518, 102.43806);
		var myOptions = {
			zoom: 19,
			center:myLatLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		
		map = new google.maps.Map( document.getElementById('canvas'),myOptions);
		
		<?php
	//Mengambil data dari database dan melakukan looping untuk menampilkan marker sesuai kordinat pada database
			$sql="select * from armada order by nama";
			$query=mysql_query($sql) or die(mysql_error());
			while($data=mysql_fetch_array($query)){
		?>
			var marker= new google.maps.Marker({
				position:new google.maps.LatLng(<?php echo $data['lat']; ?>, <?php echo $data['lon']; ?>),
				map:map,
				title:"Saya disini"
			});
			marker.setIcon({ url: "taxi.png", scaledSize: new google.maps.Size(30, 24) , anchor: new google.maps.Point(15, 12)});
			markers.push(marker);
			
			var infowindow= new google.maps.InfoWindow({
				content:"<img src='<?php echo $data['foto'];?>' width='100' align='left' /><?php 
				/*if($lokasi != "")
					echo $lokasi;*/
				echo "$data[status]";

				
				echo "<form method='post' action='lokasi.php'><select name='lokasi'><option value='Lapangan Merah'>Lapangan Merah</option><option value='Kantin'>Kantin</option><option value='Toilet D3 lantai 1'>Toilet D3 lantai 1</option><option value='Toilet D3 lantai 2'>Toilet D3 lantai 2</option><option value='Toilet D3 lantai 3'>Toilet D3 lantai 3</option><option value='Toilet D4 lantai 1'>Toilet D4 lantai 1</option><option value='Toilet D4 lantai 2'>Toilet D4 lantai 2</option><option value='Toilet D4 lantai 3'>Toilet D4 lantai 3</option><option value='Perpus D3'>Perpus D3</option><option value='Perpus D4'>Perpus D4</option><option value='Lapangan Basket'>Lapangan Basket</option><option value='Lapangan Merah'>Lapangan Merah</option><option value='BAAK'>BAAK</option></select><input type='submit' name='Simpan' value='Simpan'></form>";
				?>",
				size: new google.maps.Size(50,50),
				position:new google.maps.LatLng(<?php echo $data['lat']; ?>, <?php echo $data['lon']; ?>)
			});
			infowindow.open(map);
			
			infowindows.push(infowindow);
		<?php
			}
		?>
	
	$('#cari').change(function(){
			var i=$('#cari').val();
			var koodinat=markers[i].getPosition();
			map.panTo(koodinat);
			updatedata();
	});

	}
	
</script>
</head>
<head>
<style type = "text/css">
p.normal {
    font-style: normal;
}
#header {
    background-color: rgb(20,162,212);
    color:white;
    text-align:center;
    padding:10px;
}
#nav {
    line-height:100px;
    background-color:#eeeeee;
    height:300px;
    width:300px;
    float:left;
    padding:5px; 
}
#section {
    width:350px;
    float:left;
    padding:10px; 
}
#footer {
    background-color:rgb(20,162,212);
    color:white;
    clear:both;
    text-align:center;
    padding:5px; 
}
div.post{border:1px solid #ddd; background-color:rgb(20,162,212);}

div.background{
	background-color:rgb(20,162,212);
	}
div.transbox {
    margin: solid;
    border: 1px solid black;
    filter: alpha(opacity=60); /* For IE8 and earlier */
}

div.transbox p {
    margin: 0%;
    font-weight: bold;
    color: #000000;
}
#simple {
    margin: 0;
    padding: 0;
    width: auto;
}

#simple li {
    background: rgb(175,94,156);
    border: 1px solid #FFF;
    list-style: none;
    padding: 0.5em;
    text-align: center;
    width: auto;
}

#simple li:hover {
    background: linear-gradient(-45deg, #006cff, #5ca1ff);
}

#simple li a {
    color: white;
    display: block;
    text-decoration: none;
}
</style>
</head>
<div id ="header">
<img src="images/logo-pens.png" style="float:left;" width="100" height="100"/>
<h1>Aplication Check-In Lokasi Dosen Area Kampus PENS</h1>
	<p>Politeknik Elektronika Negeri Surabaya - Teknologi Multimedia Broadcasting</p>
</div>
  <body onLoad="initialize()">
  <div id ="nav">
  <?php
	//Mengambil data dari database dan melakukan looping untuk menampilkan marker sesuai kordinat pada database
			$sql="select * from armada WHERE id='$_SESSION[id]'";
			$query=mysql_query($sql) or die(mysql_error());
			while($data=mysql_fetch_array($query)){
		?>
  <div class="post">
  <ul id="simple">
	<li><a href="#"><img src=<?php echo $data['foto'];?> width="150" height="150"></a></li>
    <li><font size="5"><center><a href="#">Username:<?php echo $_SESSION['username']?></a></center></font></li>
    <li><font size="5"><center><a href="#">No.User :<?php echo $_SESSION['id']?></a></center></font></li>
    <font size="5"><li><a href="#"><a href="logout.php">Keluar Aplikasi</a></a></li></font>
  </ul>
  </div>
  <?php
		}
		?>
  </div>
	<div id="canvas"></div>
    <div id ="footer">
	<select id="cari" name="cari">
       <?php
			$sql="select * from armada order by nama";
			$query=mysql_query($sql) or die(mysql_error());
			$n=0;
			while($data=mysql_fetch_array($query)){
	  ?>
      		   <option value="<?php echo $n; ?>"><?php echo $data['nama']; ?></option>
       <?php
	   		$n++;
			}
	   ?>
	</div>
	</select>
</body>
</html>
