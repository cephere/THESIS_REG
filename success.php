<?php
$serverName = "DESKTOP-FQOOPV8\SQLEXPRESS";
$connectionOptions=[
    "Database"=>"WEBAPP",
    "Uid"=>"",
    "PWD"=>""
];

$conn=sqlsrv_connect($serverName, $connectionOptions);

if($conn==false){
    die(print_r(sqlsrv_errors(),true));
}

$SQL="SELECT TITLEID FROM TITLE WHERE TITLEID=(SELECT IDENT_CURRENT('TITLE'))";  
$results=sqlsrv_query($conn, $SQL);

$titleid=sqlsrv_fetch_array($results);
?>

<script>
    function dashboardpageFunction(){
        window.location.href="dashboard.php";
    }

    function registerpageFunction(){
        window.location.href="thesisreg.php";
    }
    
    function reportpageFunction(){
        window.location.href="completereport.php";
    }
</script>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="thesis.css">
</head>

<body>
    <div class="content-container">
    <div class="kulay">
                <div>
                    <img class="lasalle" src="img/lasalle dasma logo.png" alt="">

                    <h4 onClick="dashboardpageFunction()">DASHBOARD</h1>

                    <h4 onClick="registerpageFunction()">REGISTER</h1>

                    <h4 onClick="reportpageFunction()">REPORT</h1>
                </div>
            </div>
        <div class="sub-container">
            <h3 align="center">Registration Successful</h3>
            <h3 align="center">Your TITLEID is: <?php echo $titleid['TITLEID'];?> </h3>
        </div>
    </div>

</body>

