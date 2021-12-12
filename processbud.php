<?php
    $server = "sql302.epizy.com";
    $userid = "epiz_29724215";
    $pw = "LnmtU5fj5W0rE8g";
    $db= "epiz_29724215_cs20_final";

    // Create connection
    $conn = new mysqli($server, $userid, $pw, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query
    $sql = "SELECT * FROM 'budget'";
    // $result = $conn->query($sql);
    if($result = mysqli_query($conn, "SELECT * FROM budget")){
       console.log("Query was executed! \n");
    }


    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_array($result))
        {
            echo $row['date'] . "  ";
            echo "$" . $row['amount'] . "  ";
            echo $row['descrip'] . " <br/>";
        }
    } else {
        echo "No results";
    }

mysql_close($con);
?>