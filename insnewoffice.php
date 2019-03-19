<?php
$servername = "localhost";
$username = "root";
$password = "ghiglieno";
$dbname = "classicmodels";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//recupero informazione da form pagina chiamante "index1.php"
$country = $_POST["country"];
$officeCode = $_POST["officeCode"];
$city = $_POST["city"];
$phone = $_POST["phone"];
$addressLine1 = $_POST["addressLine1"];
$postalCode = $_POST["postalCode"];
$territory = $_POST["territory"];
// preparo la query in modo sicuro
// creo una variabile (convenzione chiamarla $stmt, che sta per statement)
// al posto dei parametri metto "?", un ? per ogni para
// con il metodo prepare (->prepare)
$stmt = $conn->prepare('INSERT INTO offices (officeCode, city, phone, addressLine1, country, postalCode, territory) VALUES (?, ?, ?,?, ?, ?,?)');
// con lo statement successiva immetto nella sql quello che mi è arrivato
// preparo i parametri
$stmt->bind_param('sssssss',  $officeCode, $city, $phone, $addressLine1, $country, $postalCode, $territory); // 's' specifies the variable type => 'string'
// eseguo la query
$stmt->execute();
echo $officeCode;
$conn->close();
?>

