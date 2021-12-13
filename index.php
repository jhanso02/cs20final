<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>Coffee Break</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Home page for the Coffee Break">
	<meta name="keywords" content="college, organizer, planner, study, break">

    <!-- JQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- For progress bar. May change -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    

    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        
        /* Columnds */
        .right {
            float: right;
            width: 46%;
        }
        .left {
            float: left;
            width: 46%
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
        }

        textarea {
            max-width:95%;
        }

    </style>

</head>


<body>

<h1>Coffee Break</h1>

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
	<div id="random1"> &nbsp; </div>
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

        <div class="w3-light-grey progress_bar">
            <div id="pro_bar" class="w3-container w3-green" style="height:24px; width:0%;"></div>
        </div>

        <p id="percent_used">0%</p>

        <!-- <button class="button" onclick="update_progress()">Update Progress</button>  -->

        <p> $xx / $xxx </p>

    </div>

    <!-- When new entry is added, update progress bar -->
    <form method="post" action="#" onsubmit="update_progress()">
        <!-- User input new budget entry -->
        <div class="new_budget_entry">
        <p><strong>New Entry</strong></p>
        <div class='form-item'>
            <div class='budget_log'>Amount Spent: $
            <input type='number' min="0" step="0.01" name="cost" class="cost">
            </div>
        </div>
        <div class='form-item'>
            <div class='budget_log'>Description: 
            <textarea name="description" class="description" rows="2" cols="40"></textarea>
            </div>
        </div>
        <input type="submit" name="submit_budget" class='submit'>
        </div>

        <!-- View log. TODO: Make toggle -->
        <div class="viewlog">
            <input type="button" name="b_log_view" id="showMore" value="View History"/>
        </div>
    </form>

    <!-- Budget history -->
    <table id="b_history">
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

    // Update progress bar
    function update_progress()
    {
        var elem = document.getElementById("pro_bar");
        budget_used = calculate_total();

        // Update budget % variable
        budget_percent = (budget_used * 100) / budget_max;
        if (budget_percent > 100) {
            alert("<p> in greater than 100 case</p>");
            elem.style.width = 100 + '%'; 
        } else {
            // Update bar drawing
            alert(" in less than 100 case for:" + budget_percent + '%');
            elem.style.width = budget_percent + '%';
            alert("elem style width is: " + elem.style.width);
            
        }
        document.getElementById("percent_used").innerHTML = budget_percent * 1 + '% Used';
        
    }

    function calculate_total()
    {
        var total = 0;
        var table = document.getElementById("b_history");
        for (var i = 1; i < table.rows.length; i++) {
            alert("Cell value: " + table.rows[i].cells[1].innerHTML);
            total += parseFloat(table.rows[i].cells[1].innerHTML);
            // alert("sub Total is:" + total);
        }
        return total;
    }

    // When "show more" is clicked
    $(function(){
        $('#showMore').click(function(event) {
            event.preventDefault();

            // Process in provessbud.php
            $.ajax({
            type: "POST",
            url: "processbud.php",
            data: "count=$number",
            success: function(data){
                // Add information to table
                $('#b_history').html(data);
            }
            });
        });
    });
    
    // Body onload calls this 
    function click_history()
    {
        // Get quote too
        getQuote()
        // Initalize variables
        var budget_percent = 0;
        var budget_max = 1000;
        var budget_used = 0;

        var elem = document.getElementById("showMore");
        elem.click();
        update_progress()
    }


</script>

<!-- **********************MAPS WIDGET************************* -->
<div class="widget left map" id="googleMap" style="height:300px;">
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

</body>
</html>