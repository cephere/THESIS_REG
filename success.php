<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="thesis.css">
</head>

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
    
    function searchpageFunction(){
        window.location.href="search.php";
    }
</script>

<body>
    <div class="nav">
        <div class="nav-lasalle">
            <img class="lasalle" src="img/lasalle dasma logo.png" alt="">
        </div>
        <div class="nav-container">
            <h4 onClick="dashboardpageFunction()">DASHBOARD</h4>
        </div>
        <div class="nav-container">
            <h4 onClick="registerpageFunction()">REGISTER</h4>
        </div>

        <div class="nav-container">
            <h4 onClick="searchpageFunction()">SEARCH</h4>
        </div>
    </div>

    <div class="content-container">
        <div class="sub-container">
            <h3 align="center">Registration Successful</h3>
            <h3 align="center">Your TITLEID is: <?php echo $titleid['TITLEID'];?> </h3>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <h3>Upload your manuscript, select pdf to upload:</h3>
            <input class="file-upload" type="file" name="pdf" id="pdf">
            <input class="button" type="submit" name="submit" value="Upload PDF">

            <h3>Upload your abstract, select pdf to upload:</h3>
            <input class="file-upload" type="file" name="pdf_abs" id="pdf_abs">
            <input class="button" type="submit" name="submit_abs" value="Upload PDF">

            </form>

            <?php
                //$_FILES GLOBAL VARIABLE TO HANDLE FILES
                if(isset($_POST['submit'])){
                    print_r($_FILES);

                    //to declare file to be uploaded, MIME (MULTIMEDIA)
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime_type = $finfo -> file($_FILES["pdf"]["tmp_name"]);
                
                    //declare exact files type you are accepting
                    $mime_types = ["application/pdf"];
                
                    //if error
                    if(!in_array($_FILES["pdf"]["type"],$mime_types)){
                        exit("File type not accepted");
                    }
                
                    //if there is no error
                    $file = $_FILES["pdf"]["name"];
                    $filesize = $_FILES["pdf"]["size"];
                    $destination = __DIR__ . "/uploads/" .$file;
                
                    //moving file in the chosen folder
                    move_uploaded_file($_FILES["pdf"]["tmp_name"], $destination);
                
                    //echo success
                    if($_FILES["pdf"]["error"]==0){
                        echo"<h3>Finished Uploading</h3>";
                
                        $serverName="DESKTOP-FQOOPV8\SQLEXPRESS";
                        $connectionOptions=[
                            "Database"=>"WEBAPP",
                            "Uid"=>"",
                            "PWD"=>""
                        ];
                
                        $conn=sqlsrv_connect($serverName, $connectionOptions);
                        if($conn==false){
                            die(print_r(sqlsrv_errors(),true));
                        }

                        $id=$titleid['TITLEID'];
                
                        $sql = "INSERT INTO MANUS (NAME,SIZE,PATH,TITLEID) VALUES ('$file','$filesize','$destination','$id')";
                        $result = sqlsrv_query($conn,$sql);
                
                        if($result){
                            echo"<h3>File uploaded to db</h3>";
                        }else{
                            die(print_r(sqlsrv_errors()));
                        }
                    }
                }
            ?>

<?php
                //$_FILES GLOBAL VARIABLE TO HANDLE FILES
                if(isset($_POST['submit_abs'])){

                    //to declare file to be uploaded, MIME (MULTIMEDIA)
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime_type = $finfo -> file($_FILES["pdf_abs"]["tmp_name"]);
                
                    //declare exact files type you are accepting
                    $mime_types = ["application/pdf"];
                
                    //if error
                    if(!in_array($_FILES["pdf_abs"]["type"],$mime_types)){
                        exit("File type not accepted");
                    }
                
                    //if there is no error
                    $file = $_FILES["pdf_abs"]["name"];
                    $filesize = $_FILES["pdf_abs"]["size"];
                    $destination = __DIR__ . "/uploads/" .$file;
                
                    //moving file in the chosen folder
                    move_uploaded_file($_FILES["pdf_abs"]["tmp_name"], $destination);
                
                    //echo success
                    if($_FILES["pdf_abs"]["error"]==0){
                        echo"<h3>Finished Uploading</h3>";
                
                        $serverName="DESKTOP-FQOOPV8\SQLEXPRESS";
                        $connectionOptions=[
                            "Database"=>"WEBAPP",
                            "Uid"=>"",
                            "PWD"=>""
                        ];
                
                        $conn=sqlsrv_connect($serverName, $connectionOptions);
                        if($conn==false){
                            die(print_r(sqlsrv_errors(),true));
                        }

                        $id=$titleid['TITLEID'];
                
                        $sql = "INSERT INTO ABSTRACT (NAME,SIZE,PATH,TITLEID) VALUES ('$file','$filesize','$destination','$id')";
                        $result = sqlsrv_query($conn,$sql);
                
                        if($result){
                            echo"<h3>File uploaded to db</h3>";
                        }else{
                            die(print_r(sqlsrv_errors()));
                        }
                    }
                }
            ?>
        </div>
    </div>

</body>

