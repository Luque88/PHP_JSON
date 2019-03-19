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
$country = $_GET["country"];
// preparo la query in modo sicuro
// creo una variabile (convenzione chiamarla $stmt, che sta per statement)
// al posto dei parametri metto "?", un ? per ogni para
// con il metodo prepare (->prepare)
$stmt = $conn->prepare('SELECT country, city,lastname,firstname,jobtitle FROM v_emps WHERE country = ?');
// con lo statement successiva immetto nella sql quello che mi è arrivato
// preparo i parametri
$stmt->bind_param('s', $country); // 's' specifies the variable type => 'string'
// eseguo la query
$stmt->execute();
// prendo il risultato
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $data = "";
    // output data of each row
    // fetch_assoc è il metodo che recupera un record per volta, e si posiziona sul record successivo
    while ($row = $result->fetch_assoc()) {
        //echo "code: " . $row["officeCode"]. " - Citt&agrave;: " . $row["city"]. " " . $row["country"]. "<br>";
        $data = $data . $row["city"] . "," . $row["lastname"] . "," . $row["firstname"] . "," . $row["jobtitle"] . "<br/>";
    }
    echo $data;
} else {
    echo "0 results";
}
$conn->close();
?>