<?php
    $server = "sql302.epizy.com";
    $userid = "epiz_29724215";
    $pw = "LnmtU5fj5W0rE8g";
    $db= "epiz_29724215_cs20_final";

    // Create and check connection
    $conn = new mysqli($server, $userid, $pw, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query
    $sql = "SELECT * FROM 'budget'";
    // If query worked, log it
    if($result = mysqli_query($conn, "SELECT * FROM budget")){
       echo 'console.log("Select * query was executed!");';
    }


    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>"   . $row['date']    . "</td>";
            echo "<td> $" . $row['amount']  . "</td>";
            echo "<td> "  . $row['descrip'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "No results";
    }

    mysql_close($con);
?>