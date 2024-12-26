<?php 
    session_start();

    
    if(isset($_POST['submit']) and isset($_POST['activityLevel'])){
    
        //BMR variables
        $bmrAge = $_POST['BMRage'];
        $bmrWeight = $_POST['BMRweight'];
        $unit = $_POST['weightSt'];
        $bmrFt = $_POST['ft'];
        $bmrInch = $_POST['inches'];
        $gender = $_POST['gender'];
        $activityLevel = $_POST['activityLevel'];

        //Empirical Units
        $ftToInch = $bmrFt * 12;
        $overallInch = $ftToInch + $bmrInch;

        //St-Jeor requires Metric units
        $centimeters = $overallInch * 2.54;
        
        $hbEquation = 0;
        $msjEquation = 0;
        $tdeeCalculationHB = 0;
        $tdeeCalculationMSJ = 0;

        //Results of this session stored
        $_SESSION['hbResult'] = 0;
        $_SESSION['msjResult'] = 0;

        
        //Pounds chosen
        if ($unit == "lb"){
            //Lbs in Kg for MSJ Equation
            $lbToKg = $bmrWeight * 0.453592;

            //Male 
            if($gender == "M"){
                //Harris Benedict Equation (Uses Empirical Units)
                $hbEquation = 66.5 + (6.2 * $bmrWeight) + (12.7 * $overallInch) - (6.755 * $bmrAge);
                //Mifflin St. Jeor Equation (Uses Metric Units)
                $msjEquation = (9.99 * $lbToKg) + (6.25 * $centimeters) - (5 * $bmrAge) + 5;

                $_SESSION['hbResult'] = $hbEquation;
                $_SESSION['msjResult'] = $msjEquation;
            
            //Female
            } else if ($gender == "FM"){
                //Harris Benedict Equation
                $hbEquation = 655.1 + (4.35 * $bmrWeight) + (4.7 * $overallInch) - (4.7 * $bmrAge);
                //Mifflin St. Jeor Equation
                $msjEquation = (9.99 * $lbToKg) + (6.25 * $centimeters) - (5 * $bmrAge) - 161;

                $_SESSION['hbResult'] = $hbEquation;
                $_SESSION['msjResult'] = $msjEquation;

            }
            
        }

        //Kilograms chosen
        if ($unit == "kg"){
            $kgToLb = $bmrWeight * 2.205;

            //Male
            if($gender == "M"){
                //Harris Benedict Equation
                $hbEquation = 66.5 + (6.2 * $kgToLb) + (12.7 * $overallInch) - (6.755 * $bmrAge);
                //Mifflin St. Jeor Equation
                $msjEquation = (9.99 * $bmrWeight) + (6.25 * $centimeters) - (5 * $bmrAge) + 5;

                $_SESSION['hbResult'] = $hbEquation;
                $_SESSION['msjResult'] = $msjEquation;

            //Female
            }else if ($gender == "FM"){
                //Harris benedict Equation
                $hbEquation = 655.1 + (4.35 * $kgToLb) + (4.7 * $overallInch) - (4.7 * $bmrAge);
                //Mifflin St. Jeor Equation
                $msjEquation = (9.99 * $bmrWeight) + (6.25 * $centimeters) - (5 * $bmrAge) - 161;

                $_SESSION['hbResult'] = $hbEquation;
                $_SESSION['msjResult'] = $msjEquation;

            }
   
        }

        //Calculating TDEE
        switch($activityLevel){
            case "sedentary":
                $tdeeCalculationHB = $hbEquation * 1.2;
                $tdeeCalculationMSJ = $msjEquation * 1.2;
                break;
            case "lightly_active":
                $tdeeCalculationHB = $hbEquation * 1.375;
                $tdeeCalculationMSJ = $msjEquation * 1.375;
                break;
            case "moderately_active":
                $tdeeCalculationHB = $hbEquation * 1.55;
                $tdeeCalculationMSJ = $msjEquation * 1.55;
                break;
            case "very_active":
                $tdeeCalculationHB = $hbEquation * 1.725;
                $tdeeCalculationMSJ = $msjEquation * 1.725;
                break;
            case "extremely_active":
                $tdeeCalculationHB = $hbEquation * 1.9;
                $tdeeCalculationMSJ = $msjEquation * 1.9;
                break;
            default:
                $tdeeCalculationHB = 0;
                $tdeeCalculationMSJ = 0;
                break;

        }

        //Store calculations in session array
        $_SESSION['tdeeResultHB'] = round($tdeeCalculationHB,2);
        $_SESSION['tdeeResultMSJ'] = round($tdeeCalculationMSJ,2);

    //redirect to results
    header("Location: index2.php");
    exit();

    }

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,viewport-fit=cover">
    <title>BMR and Total Daily Expenditure Calculator</title>
    <style>
        h1{
        padding-left: 100px;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        font-style: italic;
        }
        body{
        background-color: lightblue;
        }
        .BMRintro {
        margin-top: 30px;
        background-color: whitesmoke;
        display: inline-block;
        border: 1px solid red;
        margin-left: 100px;
        padding: 20px;
        vertical-align: right;
        text-align: center;
        width: 400px;
        }
        .BMRinfo {
        margin-left: 2%;
        margin-right: 2%;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        .TDEEintro {
        margin-top: 30px;
        min-height: 10%;
        background-color: whitesmoke;
        display: inline-block;
        border: 1px solid red;
        padding: 20px;
        vertical-align: right;
        margin-left: 150px;
        text-align: center;
        width: 400px;
        }

        .TDEEinfo {
        margin-left: 2%;
        margin-right: 2%;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; 
        }


        h2{
        font-family: Helvetica, Arial, sans-serif;
        }
        .image1{
        height: 300px;
        width: 90%;
        }
        .submitButton{
        height:150px;
        }
        button{
        background-color: beige;
        margin-top: 50px;
        margin-left: 45%;
        padding:1%;
        font-size: 15px;
        }
        button:hover{
        background-color: #c18e8e;
        color: black;
        }
    </style>
</head>
<body>

    <!--Basal Metabolic Rate-->
    <h1><strong>Basal Metabolic Rate and Total Energy Expenditure Calculator</strong></h1>
    <br>
    <br>
    <div class="BMRintro child">
        <h2>Basal Metabolic Rate</h2>
        <p class="BMRinfo"> Basal Metabolic Rate, or BMR or RMR (Resting Metabolic Rate), is the total amount of energy used/needed to perform everday, life sustaining functions. "Everyday" functions does NOT include rigorous exercise or daily work, but instead refers to energy needed to maintain proper neural, digestive, and circulatory systems, as well as the energy needed to move parts like fingers and arms.</p>
        <br>
        <section>
            <p><img src="https://www.creativefabrica.com/wp-content/uploads/2022/10/26/BMR-Basal-Metabolic-Rate-acronym-Vect-Graphics-43423296-1.jpg" class="image1"></p>
        </section>
        <br>
        <p class="BMRinfo">To calculate your BMR/RMR, pease fill out the information about yourself below:</p>
    <form method="post" id="mainForm">
           <strong>Age:</strong> &emsp; <input type="number" name="BMRage"> years old
            <br><br>
            <strong>Weight:</strong> &emsp; <input type="number" name="BMRweight">
            <select name="weightSt" id="weightStandard">
                <option value="lb">lb</option>
                <option value="kg">kg</option>
            </select>
            <br><br>
            <strong style="text-align: left;">Height:&emsp;&emsp;&emsp;</strong> &emsp; <input type="number" name="ft" style="width:50px;"> ft &emsp;<input type="number" name="inches" style="width:50px;"> in
            <br><br>
            <strong >Gender:&emsp;&emsp;&emsp;&emsp;&emsp;</strong>
            
            <select name ="gender" id ="gender" style="width: 150px;text-align: center;">
                <option value = "M">Male</option>
                <option value = "FM">Female</option>
            </select>
            <br><br><br><br>
        
    </div>

    <!--Total Daily Energy Expenditure-->
    <div class="TDEEintro child">
        <h2>Total Daily Energy Expenditure</h2>
        <p class="TDEEinfo">Total Daily Energy Expenditure, or TDEE, is the complete measure of the total amount of energy used during your day. This DOES include exercise and everyday work, as well as your Basal Metabolic Rate. To determine this, the frequency and rigor of your exercise must be taken into account, thus leaving this calculation to have a margin of error. </p>
        <br>
        <section>
            <p><img src="https://tdeecalculator.org/wp-content/uploads/2021/04/TDEE-Chart.jpg" class="image1"></p>
        </section>
        <br>
        <p class="TDEEinfo">To calculate your TDEE, please fill out the information about yourself below:</p>
        
        
        
        
        
   
        <!-- Sedentary -->
        <input type="radio" id="sedentary" name="activityLevel" value="sedentary" required>
            <strong>Sedentary:</strong> This indicates little to no physical activity. This could be due to physical injury or age.
        <br>
        
        <!-- Lightly Active -->
        <input type="radio" id="l.active" name="activityLevel" value="lightly_active">
        
            <strong>Lightly Active:</strong> This indicates exercise 1-2 times a week, or minimal activity daily.
        <br>
        
        <!-- Moderately Active -->
        <input type="radio" id="moderate" name="activityLevel" value="moderately_active">
        
            <strong>Moderately Active:</strong> This indicates exercise 3-4 times a week or substantial amounts of activity daily.
        <br>
        
        <!-- Very Active -->
        <input type="radio" id="very" name="activityLevel" value="very_active">
        
            <strong>Very Active:</strong> This indicates exercise 5-6 times a week or strenuous amounts of activity daily.
        <br>
        
        <!-- Extremely Active -->
        <input type="radio" id="most" name="activityLevel" value="extremely_active">
        
            <strong>Extremely Active:</strong> This indicates daily strenuous work and/or exercise. Can also be descriptive of athletes.
        <br>

    </form>
    </div>
    <section class="submitButton">

        <button method = "post" type="submit" form="mainForm" name="submit">Calculate</button>



    </section>
</body>
<footer>
   
</footer>
</html>



