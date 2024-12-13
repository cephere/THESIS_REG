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

    function downloadpageFunction(){
        window.location.href="download.php";
    }
    
    function reportpageFunction(){
        window.location.href="completereport.php";
    }

</script>

<body>
    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
        <div class="kulay-bg">
            <div><img class="lasalle" src="img/lasalle dasma logo.png" alt=""></div>

            <div class="dash">  
                <div class="dash-container">
                    <h4 onClick="reportpageFunction()">REPORT</h4>
                    <p class="pads">This the report page, this is where admins view thesis reports. </p>
                    <p>Click Report to start</p>
                </div>

                <div class="dash-container">
                    <h4 onClick="downloadpageFunction()">DOWNLOAD</h4>
                    <p class="pads">This the download page, this is where admins can download the manuscripts of users.</p>
                    <p>Click Download to start</p>
                </div>

                <div class="dash-container">
                <h4 onClick="dashboardpageFunction()">LOGOUT</h4>
                <p class="pads">This the logout page, this brings you back to the user dashboard and logs out your account.</p>
                <p>Click Logout to start</p>
                </div>
            </div>  
        </div>      
    </form>
</body>
</html>


