<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Registration Form</title>
    <link rel="stylesheet" href="thesis.css">
</head>

<script>
    function admindashboardpageFunction(){
        window.location.href="admindash.php";
    }

    function registerpageFunction(){
        window.location.href="thesisreg.php";
    }
    
    function reportpageFunction(){
        window.location.href="completereport.php";
    }

</script>

<body>
    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">        
        <div class="content-container">
            <div class="kulay">
                <div>
                    <img class="lasalle" src="img/lasalle dasma logo.png" alt="">

                    <h4 onClick="admindashboardpageFunction()">ADMIN</h4>
                </div>
            </div>
            
        </div>
    </form>
</body>
</html>


