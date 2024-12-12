<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Registration Form</title>
    <link rel="stylesheet" href="thesis.css">
</head>

<script>
    function dashboardpageFunction(){
        window.location.href="dashboard.php";
    }

    function registerpageFunction(){
        window.location.href="thesisreg.php";
    }
    
    function searchpageFunction(){
        window.location.href="search.php";
    }

    function loginpageFunction(){
        window.location.href="login.php";
    }
</script>

<body>
    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">        
        <div class="kulay-bg">
            <div><img class="lasalle" src="img/lasalle dasma logo.png" alt=""></div>

            <div class="dash">  
                <div class="dash-container">
                    <h4 onClick="registerpageFunction()">REGISTER</h4>
                </div>

                <div class="dash-container">
                    <h4 onClick="searchpageFunction()">SEARCH</h4>
                </div>

                <div class="dash-container">
                    <h4 onClick="loginpageFunction()">LOGIN</h4>
                </div>
            </div>  
        </div>
    </form>
</body>
</html>


