<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>Coffee Break</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Home page for the Coffee Break">
	<meta name="keywords" content="college, organizer, planner, study, break">

    <!-- JQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->

    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body {
            margin-left: 2%;
            background-color: #FEF1E6;
        }

        .budget {
            width: 500px;
            height: 500px;
            padding: 10px 20px;
            box-sizing: border-box;
            border-radius: 10px;
            background-color: #90AACB;
            display: block;
        }
        .new_budget_entry {
            padding: 10px 8px;
            box-sizing: border-box;
            border-radius: 5px;
            background-color: #bcb5eb;
        }

        #showMore {
            margin: 10px 0px;
        }

        .widget h2 {
            text-align: center;
        }

    </style>

</head>

<body>

<h1>Coffee Break</h1>

<div class="widget budget" id="budget_outline">
    <h2>Budget</h2>


    <form method="post" action="#">
        <!-- User input new budget entry -->
        <div class="new_budget_entry">

        <div class='form-item'>
            <div class='budget_log'>Amount Spent: 
            <input type='number' min="0" step="0.01" name="cost" class="cost">
            </div>
        </div>
        <div class='form-item'>
            <div class='budget_log'>Description: 
            <input type="text" name="description" class="description">
            </div> 
        </div>
        <input type="submit" name="submit_budget" class='submit'>
        </div>

        <div class="viewlog">
            <input type="button" name="b_log_view" id="showMore" value="View History"/>
        </div>
    </form>

    <!-- View budget history -->
    <table id="b_history">
        <tr>Example of table row</tr>
    </table>
    
    <?php
    //establish connection info
    $server = "sql302.epizy.com";
    $userid = "epiz_29724215";
    $pw = "LnmtU5fj5W0rE8g";
    $db= "epiz_29724215_cs20_final";

    // Create connection
    $conn = new mysqli($server, $userid, $pw);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //select the database
    $conn->select_db($db);

    // Get information from form
    if(isset($_POST['submit_budget'])){
        $cost = $_POST['cost'];
        $description = $_POST['description'];
        $date = date('Y/m/d H:i:s');

        $result = $conn->query("SHOW COLUMNS FROM 'budget'");
        echo "<br/> Columns from budget: " . $result;
        
        $sql_insert = "INSERT INTO budget (amount, descrip, date) VALUES ($cost, '$description', '$date')";
        echo "<br/> going to insert " . $sql_insert;
        if ($conn->query($sql_insert) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    
    $conn->close();
    ?>


</div>


<script language="javascript">
    window.onload = function()
    {

    }

   
    $(function(){
        $('#showMore').click(function(event) {
            event.preventDefault();

            $.ajax({
            type: "POST",
            url: "processbud.php",
            data: "count=$number",
            success: function(data){
                window.alert(data);
                $('#b_history').append(data);
                // $('#b_history tr:last').after(data);
            }
            });
        });
    });


</script>

</body>
</html>