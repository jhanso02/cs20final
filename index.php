<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" language="en">
<head>

    <title>Coffee Break</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Home page for the Coffee Break">
	<meta name="keywords" content="college, organizer, planner, study, break">

    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/6943534088.js" crossorigin="anonymous"></script>

    <!-- JQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- For progress bar. May change -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <link rel="stylesheet" href="style.css"/>
    
    <style type="text/css">
        /* Columns */
        .right {
            float: right;
            width: 46%;
        }
        .left {
            float: left;
            width: 46%
        }
        .row{
            display: flex;
            flex-wrap: wrap;
            position: center;
            padding: 3px;
        }
        #schedule{
            padding-left: 4px;
            text-align: right;
        }
        .column{ 
            flex: 30%;
            padding: 15px;
             
            width: calc(100% - 30px);
            height: 150px;
            display: inline-grid;
            border: 2px solid black; 
            margin-right: 3px;
            margin-left: 3px;
            margin-bottom: 1%;
            font-size: small;
            line-height: 200%;
        }
        .row1{
            position: bottom;
            width: 100%;
            height: 20%;
            float: none;
            clear: both;
            display: flex;
            margin-bottom: 3%;
        }
        
        
         /* Responsive columns */
        @media screen and (max-width: 600px) {
            .left {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
            .right {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
	    .column{ 
                height: 200px;
            }
		
        }
        textarea {
            max-width:95%;
            vertical-align: top;
        }
    </style>
</head>

<body>

<h1 style="font-size:400%"> Coffee Break </h1>

<!-- ****************************WEATHER WIDGET*********************** -->
<div class="widget left weather_box">
    <a class="weatherwidget-io"
    href="https://forecast7.com/en/42d42n71d11/medford/?unit=us"
    data-label_1="TUFTS" data-label_2="UNIVERSITY" data-theme="original">TUFTS
    UNIVERSITY</a>
</div>

<script>
    !function(d,s,id){
        var js,fjs = d.getElementsByTagName(s)[0];
        if(!d.getElementById(id)){
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://weatherwidget.io/js/widget.min.js';
            fjs.parentNode.insertBefore(js,fjs);
        }
    }
    (document,'script','weatherwidget-io-js');
</script>

<!-- ********************Quote WIDGET ********************************* -->
<div class="widget right quote" >
    <h2> Daily Dose of Inspiration </h2>
	<div id="random1">  
    <h6> &nbsp; </div>
	<div id="random"> &nbsp; </div>
</div>

<script>
    var quote;

    function getQuote() {

        request = new XMLHttpRequest();

        request.open("GET", "https://api.quotable.io/random?maxLength=50", true);

        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {

                var result = request.responseText;

                var object = JSON.parse(result, function (key, value) {
                    if (key == "content") {
                    quote = value;
                    }
                })
            }	
        document.getElementById("random1").innerHTML=quote;
        }
        request.send();
    };
</script>

<!-- ****************************** BUDGET WIDGET ************************ -->
<div class="widget right budget" id="budget_outline">
    <h2>Budget</h2>

    <!-- Progress bar section -->
    <div class="progress">

        <div class="w3-light-grey w3-round">
            <div id="pro_bar" class="w3-container w3-round" style="height:30px; width:0%;">
                <div id="pro_label"> </div>
            </div>
        </div>
        <p id="bud_fraction"> $xx / $xxx </p>
        <button onclick="edit_limit()" class="button" name="edit_max" id="edit_max">Edit Limit</button>

    </div>

    <!-- When new entry is added, update progress bar -->
    <form method="post" action="" onsubmit="update_progress()">
        <!-- User input new budget entry -->
        <div class="new_budget_entry">
        <p><strong>New Entry</strong></p>
        <div class='form-item' id="amount_spent">
            <div class='budget_log'>Amount Spent: $
            <input type='number'  step="0.01" name="cost" class="cost">
            </div>
        </div>
        <div class='form-item' style="vertical-align: top;">
            <div class='budget_log'>Description: 
            <textarea name="description" class="description" rows="2" cols="20"></textarea>
            </div>
        </div>
        <input type="submit" name="submit_budget" class='submit'>
        </div>
    </form>
    
    
    
    <div class="viewlog">
        <input type="button" class="button" name="b_log_view" id="showMore" value="View History"/>
    </div>

    

    <!-- Budget history -->
    <table id="b_history" >
        <th>Date</th>
        <th>Amount</th>
        <th>Description</th>
    </table>
    
    <!-- PHP- used for connection to database -->
    <?php
    //establish connection info
    $server = "sql302.epizy.com";
    $userid = "epiz_29724215";
    $pw = "LnmtU5fj5W0rE8g";
    $db= "epiz_29724215_cs20_final";

    // Create and check connection
    $conn = new mysqli($server, $userid, $pw);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //select the database
    $conn->select_db($db);

    // Get information from form. Add date time.
    if(isset($_POST['submit_budget'])){
        $cost = $_POST['cost'];
        $description = $_POST['description'];
        $date = date('Y/m/d H:i:s');

        // The query to use
        $sql_insert = "INSERT INTO budget (amount, descrip, date) VALUES ($cost, '$description', '$date')";
        // Insert and check status
        if ($conn->query($sql_insert) === TRUE) {
            console.log('New budget log created successfully');
        } else {
            echo "Error adding new entry";
            console.log('Error: ". $sql . "<br>" . "$conn->error');
        }
    }

    // Close connection
    $conn->close();
    ?>
    <body onload="click_history()">
</div>

<script language="javascript">

    // Initalize variables
    var budget_percent = 0;
    var budget_max = 0;
    var budget_used = 0;

    // Update progress bar
    function update_progress()
    {
        var elem = document.getElementById("pro_bar");
        budget_used = calculate_total();

        // Update budget % variable
        budget_percent = (budget_used * 100) / budget_max;
        if (budget_percent > 100) {
            elem.style.width = 100 + '%';   
        } else {
            // Update bar drawing
            elem.style.width = budget_percent + '%';
        }
        document.getElementById("pro_label").innerHTML = budget_percent.toFixed(2) + '% Used';

        document.getElementById("bud_fraction").innerHTML = "$" + budget_used.toFixed(2) + " / $" + budget_max.toFixed(2);
        
    }

    function calculate_total()
    {
        let total = 0;
        let table = document.getElementById("b_history");
        console.log(table);
        for (let i = 1; i < table.rows.length; i++) {
            let text = table.rows[i].cells[1].innerHTML;
            text = text.substring(1);
            let row_num = parseFloat(text);
            total += row_num;
        }
        console.log("Total to be retuned is: $" + total);
        return total;
    }

    // When "show more" is clicked
    $(function(){
        $('#showMore').click(function(event) {
            event.preventDefault();
            console.log("Show more was clicked");
            // Process in provessbud.php
            $.ajax({
            type: "POST",
            url: "processbud.php",

            success: function(data){
                // Add information to table
                $('#b_history').html(data);
                // Change button name then toggle table view
                if ($('#b_history').is(':visible')) {
                    document.getElementById("showMore").value = "Show Log"
                } else {
                    document.getElementById("showMore").value = "Hide"
                }
                $("#b_history").toggle();
                // Update progress variables
                update_progress();
            }
            });
        });
    });
    
    // Body onload calls this 
    function click_history()
    {
        // Get quote too
        getQuote();

        var elem = document.getElementById("showMore");
        elem.click();
    }


    function edit_limit()
    {
        var new_limit = prompt("Please enter a new Budget limit","0.00");
        n = parseInt(new_limit);
        if (isNaN(n)){
            alert("Error: Limit must be a number");
        } else {
            budget_max = n;
        }
        update_progress();
    }
</script>

<!-- **********************MAPS WIDGET************************* -->
<div class="widget left map ms" id="googleMap" style="height:200px;">
    <h2>Campus Map</h2>
    
    <script>
        function myMap() {
            var mapProp= {
            center:new google.maps.LatLng(42.4085, -71.1183),
            zoom:15,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBIktyyp-E6l_1Hjn2Io9cR9IPU3mkgCA&callback=myMap"></script>
 
</div>

<!-- **********************Schedule WIDGET************************* -->
<div class = "widget left sched">
    <div id="schedule"> 
        <p>
            <form onsubmit="editData()">
            View:
            3-day <input type="radio" name="view" value="3-day" checked="checked" style="margin-right: 1%;">
            Week <input type="radio" name="view" value="week" style="margin-right: 1%;">
            <input type="submit" name="edit" class="button" value="EDIT" style="margin-right:4px;">
            </form>
        </p>
    </div>

    <script language="javascript">
        // Opens the schedule form 
        function editData(){
           window.open('scheduleForm.php', 'Order', 'width=550,height=500');
        }

        week = ["Sunday", "Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        weekly = new Boolean(false);
        days = [];
        let clicked = 0; 

        $(document).ready(function(){
            condensedView(); 
            $(".visibility").hide(); // hides the additional collumns in the schedule
            $('input[type="radio"]').click(function(){
                if( $('input[type="radio"]:checked').val()== "3-day"){
                    $(".visibility").hide(); 
                }else{
                    weekly = true; 
                    $(".visibility").toggle();
                    clicked++;
                    weeklyView();
                }
            });
        });
        
        function condensedView(){
            const d = new Date();
            let start = d.getDay()%7;
            let nextDay = (start+1)%7;
            let dayAfter = (start+2)%7;
            days = [week[start],week[nextDay],week[dayAfter]];

            for(i=0; i<3; i++){
                document.getElementById('label'+i).innerHTML += days[i] + " " ;
            }
            style();
        };

        function weeklyView(){
            const d = new Date();
            let start = d.getDay()%7; 
        
            if (clicked == 1){
                for(i=3; i<7; i++){
                    if(i<=6){
                        days.push(week[(start+i)%7]);
                        document.getElementById('label'+i).innerHTML += days[i] + " " ;
                    }
                }
            }
        }

        function style(){
            for(i=0;i<7;i++){
                document.getElementById('label'+i).style.textAlign = "center";
                document.getElementById('label'+i).style.fontFamily = "Cambria, Cochin, Georgia, Times, 'Times New Roman', serif";
            }
        }
    </script>

    <?php
        // Establish connection 
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

        // select and connect to the database
        $conn->select_db($database);

        // run a query to get information 
        $sql = "SELECT * FROM Days";
        $result = $conn->query($sql);
        
        $Days = array();
        $Class= array();

        // get results 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_array()){
                // Add the items to the array
                $Days[]= $row[0];
                $Class[]=$row[1];   
            }
        } else {
            echo "no results";
        }

        $x = count($Days);
        $y = count($Class);
        $freq = 0;
        $index = 0;

        // Getting Today
        $m = date("l");

        $week = ["Sunday", "Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        
        $d = array();
        $d1 = array();
        $d2 = array();
        $d3 = array();
        $d4 = array();
        $d5 = array();
        $d6 = array();

        //echo "freq: ", $freq;
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d,$Class[$i]);
            }
        }
        for($i=0;$i<$x;$i++){
            if( $m == $week[$i]){
                $index = $i;
            }
        }
        $m = $week[($index+1)%7];
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d1,$Class[$i]);
            }
        }
        $m = $week[($index+2)%7];
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d2,$Class[$i]);
            }
        }
        $m = $week[($index+3)%7];
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d3,$Class[$i]);
            }
        }
        $m = $week[($index+4)%7];
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d4,$Class[$i]);
            }
        }
        $m = $week[($index+5)%7];
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d5,$Class[$i]);
            }
        }
        $m = $week[($index+6)%7];
        for($i=0;$i<$x;$i++){
            if( $m == $Days[$i]){
                $freq ++; 
                array_push($d6,$Class[$i]);
            }
        }
        //close the connection	
        $conn->close();
    ?>

    <div class="row" style="border: 0px;">
        <div class="column">
            <div id="label0"></div>
            <div class="row">
                <?php
                    for($i=0;$i<count($d);$i++){
                        echo $d[$i],"<br> ";
                    }
                ?>
            </div>
        </div>

        <div class="column"> 
            <div id="label1"></div>
            <div class="row">
                <?php
                    for($i=0;$i<count($d1);$i++){
                        echo $d1[$i],"<br> ";
                    }
                ?>
            </div>
        </div>

        <div class="column"> 
            <div id="label2"></div>
            <div class="row">
                <?php
                    for($i=0;$i<count($d2);$i++){
                        echo $d2[$i],"<br> ";
                    }
                ?>
            </div>
        </div>

        <div class="column visibility">
            <div id="label3"></div>
            <div class="row">
                <?php
                    for($i=0;$i<count($d3);$i++){
                        echo $d3[$i],"<br> ";
                    }
                ?>
            </div>
        </div>

        <div class="column visibility"> 
            <div id="label4"></div>
            <div class="row">
                <?php
                    for($i=0;$i<count($d4);$i++){
                        echo $d4[$i],"<br> ";
                    }
                ?>
            </div>
        </div>

        <div class="column visibility">
            <div id="label5"></div>
            <div class="row">
                <?php
                    for($i=0;$i<count($d5);$i++){
                        echo $d5[$i],"<br> ";
                    }
                ?>
            </div>
        </div>

        <div class="column visibility">
            <div id="label6"></div>
            <div class="row" >
                <?php
                    for($i=0;$i<count($d6);$i++){
                        echo $d6[$i],"<br> ";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- ****************************** Campus Icons  ************************ -->
<div class="row1" >
    <div class='staar_center'>
        StAAR Center <br>
        <i class="fab fa-instagram"><a href="https://www.instagram.com/staarcenter/" target="_blank"> @staarcenter</a></i><br>
        <i class="fab fa-facebook"><a href="https://www.facebook.com/StAAR.Center/" target="_blank"> @staarcenter</a></i><br>
        <br><br>
    </div>

    <div class='first_center'>
        FIRST Resource Center <br>
        <i class="fab fa-instagram"><a href="https://www.instagram.com/tuftsfirst/" target="_blank"> @tuftsfirst</a></i><br>
        <br><br>
    </div>

    <div class='tufts_ocl'>
        Office For Campus Life <br>
        <i class="fab fa-instagram"><a href="https://www.instagram.com/tuftsocl/?hl=en" target="_blank"> @tuftsocl</a></i><br>
        <i class="fab fa-facebook"><a href="https://www.facebook.com/tuftsocl/" target="_blank"> @tuftsocl</a></i><br>
        <br><br>
    </div>
</div>

</body>
</html>