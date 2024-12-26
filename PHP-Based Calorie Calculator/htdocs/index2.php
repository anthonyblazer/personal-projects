<?php
    session_start();

    if (!isset($_SESSION['tdeeResultHB']) || !isset($_SESSION['tdeeResultMSJ'])) {
        echo "<p style='color: red;'>TDEE results are not set. Please check the calculations on index.php.</p>";
    }
?>


<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMR and Total Daily Expenditure Calculator</title>
    <style>
        h2 {
    font-family: Helvetica, Arial, sans-serif;
    font-style: italic;
    text-align: center; 
    color: blueviolet;
}

body {
    background-color: lightblue;
}

.BMRresults, .TDEEresults {
    margin-top: 30px;
    min-height: 10%;
    background-color: whitesmoke;
    display: inline-block;
    border: 1px solid red;
    text-align: center;
    width: 400px;
}

.BMRresults {
    margin-left: 100px;
    padding: 26px;
}

.TDEEresults {
    margin-left: 150px;
    padding: 20px;
}

.BMRrinfo, .TDEEinfo {
    margin-left: 2%;
    margin-right: 2%;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
@media (max-width: 600px) {
    .BMRresults, .TDEEresults {
        width: 90%;  /* Make the results containers take up most of the screen */
        margin-left: 5%;  /* Center the containers with some margin */
        margin-right: 5%;
    }

    h2{
        font-size: 1.75rem;
    }

    .BMRinfo, .TDEEinfo{
        font-size: 1.25rem;
    }
}
    </style>
</head>
<body>

    <!--Basal Metabolic Rate-->
    <h2><strong>Your Results !!</strong></h2>
    <br>
    
    <div class="BMRresults child">
        <h1 >Basal (Resting) Metabolic Rate</h1>
        <br>
        <img src="https://th.bing.com/th/id/OIP.edOMmas9yLLZUmY5580ZkAHaHa?rs=1&pid=ImgDetMain" style = "height: 300px;width: 90%;">
        <p class="BMRinfo" style = "line-height:25px;">At the time of this calculator's creation, the most commonly used equations for BMR calculation are the Harris-Benedict and Mifflin St. Jeor equations. Harris-Benedict is older, being established in 1919 and more recently in 1989. In 1990, Mifflin St-Jeor was published in the American Journal of Clinical Nutrition, thus making it on level with Harris-Benedict. Results for both are provided below.</p>
        <br>
        <br>
        <!--BMR display-->
        <?php 
        if (isset($_SESSION['hbResult']) and isset($_SESSION['msjResult'])){
            echo "<h2>Harris Benedict: " . number_format($_SESSION['hbResult'], 0) . " Cal</h2>";
            echo "<h2>Mifflin St. Jeor: ". number_format($_SESSION['msjResult'], 0) ." Cal</h2>";
            // Optionally, clear the session result after displaying
            unset($_SESSION['result']);
        }else{
            echo "<h2 style='color: red;'> Double Check Inputs!</h2>";
        }
        ?>
        <br>
        
    </div>

    <!--Total Daily Energy Expenditure-->
    <div class="TDEEresults child">
        <h1>Total Daily Energy Expenditure</h1>     
        <img src="https://th.bing.com/th/id/R.0f594c7c2537b18e523a982d8c7a0894?rik=UmDVsluP9gBVoA&pid=ImgRaw&r=0" style = "height: 300px;width: 90%;">
        <br>
        <p class="TDEEinfo" style="line-height: 25px;">As you might expect, the more active you are, the more calories that you not only burn intra-workout but as well as the remainder of the day! Just like with BMR, TDEE can be calculated either using your Mifflin St. Jeor or Harris Benedict BMR results! Providing both can give you a better look at how similar/different these equations are, but also a range to work in when considering weight control programs.</p>
        <br>
        <br>
        
        <?php 
            if (isset($_SESSION['tdeeResultHB']) and isset($_SESSION['tdeeResultMSJ'])){

                echo "<h2 style = line-height: 15px;'>Using Harris Benedict: ". number_format($_SESSION['tdeeResultHB'], 0) ." Cal</h2>";
                echo"<h2 style = line-height: 15px;>Using Mifflin St Jeor: ". number_format($_SESSION['tdeeResultMSJ'], 0) ." Cal</h2>";

            }else{
                echo "<h2 style='color: red;'> Double Check Inputs!</h2>";
            }
        ?>
        <br>
        
    </div>
    
</body>

</html>