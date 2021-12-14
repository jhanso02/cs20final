<!DOCTYPE html>
<head>
    <title> Schedule Form</title>
    <!-- TODO: General Style Sheet Goes Here -->
    <link rel="stylesheet" href="style.css"/>

    <style>
        h3{
           text-align: center;
           font-family: "Cambria", "Hoefler Text", "Liberation Serif", "Times", "Times New Roman", "serif";
        }
        form{
            padding: 10px; 
            margin: 5px;
        }
        input[type=text] {
            width: 80%;
            padding: 10px 20px;
            margin: 3px;  
        }
        .button {
            background-color: #FEF1E6;
            text-align: center;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size:large;
            padding: 2px 15px;
        }
    </style>
</head>
<body>
    <h1> Please input your class schedule below.</h1>
    <h3> (Ex: 10:00 Biology, 5:30 Ceramics) </h3>

<!-- onsubmit="processInput()"  onsubmit="window.close()""  -->
<!-- method:'get' action='scheduleView.php'-->
    <form method="post">
        Monday <input type ="text" name="Monday" id="Monday"> <br>
        Tueday <input type ="text" name="Tuesday" id="Tuesday"> <br>
        Wednesday <input type ="text" name="Wednesday" id="Wednesday"> <br>
        Thursday <input type ="text" name="Thursday" id="Thursday"> <br>
        Friday <input type ="text" name="Friday" id="Friday"> <br>
        Saturday <input type ="text" name="Saturday" id="Saturday"> <br>
        Sunday <input type ="text" name="Sunday" id="Sunday"> <br>

        <input type="submit" class="button" name="submitSchedule" id="submit" style="position:center" >
    </form>

    <?php
        //establish connection info
        $servername = "sql103.epizy.com";
        $userid = "epiz_29681768";
        $password = "tbF411sjrbvGjC";
        $database = "epiz_29681768_schedule";

        // Create connection
        $conn = new mysqli($servername, $userid, $password );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //select the database
        $conn->select_db($database);

        // collect value of input field
        if(isset($_POST['submitSchedule'])){
            $mon = $_REQUEST['Monday'];
            $tue = $_POST['Tuesday'];
            $wed = $_POST['Wednesday'];
            $thurs = $_POST['Thursday'];
            $fri = $_POST['Friday'];
            $sat = $_POST['Saturday'];
            $sun = $_POST['Sunday'];
            //processInput($mon);
        }
        
        if (empty($mon)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $mon); 
            $day = "Monday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        if (empty($tue)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $tue); 
            $day = "Tuesday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

         if (empty($wed)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $wed); 
            $day = "Wednesday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
         if (empty($thurs)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $thurs); 
            $day = "Thursday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
         if (empty($fri)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $fri); 
            $day = "Friday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
         if (empty($sat)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $sat); 
            $day = "Saturday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
         if (empty($sun)) {
            // echo ("empty <br>");
        } else {
            $x = explode (",", $sun); 
            $day = "Sunday";

            for($i=0;$i<count($x);$i++){
                $sql = "INSERT INTO Days (Day,Class) VALUES('$day','$x[$i]')";
                //echo $sql;

                if ($conn->query($sql) === TRUE) {
                    echo "record inserted successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
            
            
        //close the connection	
        $conn->close();

        //header('location: scheduleView.php');
        // if (!isset($_SESSION)) {
        //     session_start();
        // }

        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     $_SESSION['postdata'] = $_POST;
        //     unset($_POST);
        //     header("Location: ".$_SERVER['PHP_SELF']);
        //     exit;
        // }
        
    ?>

</body>
</html>