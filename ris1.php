<html>
<body>
<h1>Mimmo</h1>
Benvenuto  
<?php 
	$frase=" mia frase ";
	$x=10;
	$y=20;
	$tot=$x*$y;
	
	$nome= $_POST["name"]; 
	$ris= $frase . $tot . " " . $nome;
	echo $ris;
?>
<br>
Your email address is: <?php echo $_POST["email"]; ?>

</body>
</html>