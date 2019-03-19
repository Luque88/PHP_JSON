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
$stmt = $conn->prepare('SELECT country FROM v_country');
// eseguo la query
$stmt->execute();
// prendo il risultato
$result = $stmt->get_result();
//dobbiamo ottenere:
//<option value="USA">USA</option>
//<option value="UK">UK</option>
//....
$ht = "";
if ($result->num_rows > 0) {
    // output data of each row
    // fetch_assoc è il metodo che recupera un record per volta, e si posiziona sul record successivo
    while ($row = $result->fetch_assoc()) {
        // &agrave; è un HTML special caracters
        //echo "code: " . $row["officeCode"]. " - Citt&agrave;: " . $row["city"]. " " . $row["country"]. "<br>";
        $ht = $ht . '<option value="' . $row["country"] . '">' . $row["country"] . '</option>';
    }
}
$conn->close();
?>

<script>
    function showEmp() {
        let str = document.getElementById("scountry").value;
        if (str.length == 0) {
            document.getElementById("myemp").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // metto il risultato JSON
                    let newJSON = this.responseText;
                    // manipolo il JSON per poterlo inserire in HTML
                    let okHTML = prepareHTML(newJSON);
                    document.getElementById("myemp").innerHTML = okHTML;
                }
            };
            xmlhttp.open("GET", "getEmps_json.php?country=" + str, true);
            xmlhttp.send();
        }
    }
    function showEmpPost() {
        let fd = new FormData(fcountry);
        let str = document.getElementById("scountry").value;
        if (str.length == 0) {
            document.getElementById("myemp").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // metto il risultato JSON
                    let newJSON = this.responseText;
                    // manipolo il JSON per poterlo inserire in HTML
                    let okHTML = prepareHTML(newJSON);
                    document.getElementById("myemp").innerHTML = okHTML;
                }
            };
            xmlhttp.open("POST", "getEmps_jsonPost.php");
            xmlhttp.send(fd);
        }
    }
    function insnewoff() {
        let fd = new FormData(finsert);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // metto il risultato JSON
                let id = this.responseText;
                alert(id);
                document.location="index1.php";
            }
        };
        xmlhttp.open("POST", "insnewoffice.php");
        xmlhttp.send(fd);
    }
    function prepareHTML(dbJSON) {
        let ar_rows = JSON.parse(dbJSON);
        //"<tr>
        let ht = "";
        for (i = 0; i < ar_rows.length; i++) {
            ht += "<tr><td>" + ar_rows[i].firstname + "</td><td>" + ar_rows[i].lastname + "</td><td>" + ar_rows[i].city + "</td><td>" + ar_rows[i].jobtitle + "</td>";
        }
        htok = "<table>" + ht + "</table>";
        return htok;
    }
    function creaTabellaDaJson(oggJson, listaCampi, idTabella, classeTabella, contenitore = "body") {
        let tabella = document.createElement("table");
        tabella.id = idTabella;
        tabella.className = classeTabella;
        let vCampi = listaCampi.split(",");
        //    riga intestazione
        let thead = document.createElement("thead");
        let riga = document.createElement("tr");
        vCampi.forEach(function (campo, i) {
            let th = document.createElement("th");
            th.innerHTML = campo;
            riga.append(th);
        });
        tabella.append(thead);
        thead.append(riga);
        let tBody = document.createElement("tbody");
        oggJson.forEach(function (record, i) {
            let rigaRecord = document.createElement("tr");
            vCampi.forEach(function (campo, j) {
                let cella = document.createElement("td");
                cella.innerHTML = oggJson[i][campo];
                rigaRecord.appendChild(cella);
            });
            tBody.append(rigaRecord);
        })
        tabella.append(tBody);
        //    append della tabella al conteni
        //    tore
        document.querySelector(contenitore).append(tabella);
    }
</script>



<html>
    <body>

        <form action="ris1.php" method="post">
            Name: <input type="text" name="name"><br/>
            E-mail: <input type="text" name="email"><br/>
            <input type="submit"><br/>
            <input type="text" name="testo" id="intest">

            <input type="hidden" name="paramhid" value="nascosto hidden">
        </form>

        <form action="risdb.php" method="post" id="fcountry">
            country: <select name="country" id="scountry">
                <?php
                echo $ht;
                ?>
            </select>

            <input type="text" name="country2"><br/>
            <input type="submit"><br/>
            <input type="button" onclick="showEmp()" value="ajax load"><br/>
            <input type="button" onclick="showEmpPost()" value="ajax load post"><br/>

        </form>


        <!--con ajax-->
        <form  method="post" id="finsert">


            country <input type="text" name="country" ><br/>
            officeCode <input type="text" name="officeCode"><br/>
            city <input type="text" name="city"><br/>
            phone <input type="text" name="phone"><br/>
            addressLine1 <input type="text" name="addressLine1"><br/>
            postalCode <input type="text" name="postalCode"><br/>
            territory <input type="text" name="territory"><br/>

            <input type="button" onclick="insnewoff()" value="inserisci post"><br/>

        </form>

        <div id="myemp">nessuno</div>
    </body>
</html>