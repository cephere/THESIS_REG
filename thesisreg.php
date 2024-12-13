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
    function searchpageFunction(){
        window.location.href="search.php";
    }
    function loginpageFunction(){
        window.location.href="login.php";
    }
</script>

<body>
    <?php
        ob_start();
        //Part 1
        $titleErr="";
        $programErr="";
        $subErr="";
        $schoolyearErr="";
        $dateofsubErr="";

        //Part 2.1
        $last1Err="";
        $first1Err="";

        //Part 2.2
        $last2Err="";
        $first2Err="";

        //Part 2.3
        $last3Err="";
        $first3Err="";

        //Part 3.1
        $last4Err="";
        $first4Err="";

        //Part 3.2
        $last5Err="";
        $first5Err="";

        //Part 4
        $emailErr="";
        $contactErr="";
        
        if(empty($_POST['title'])){
            $titleErr = "Title is required";
        }
        
        if(empty($_POST['course'])){
            $programErr = "Program is required";
        }
        
        if(empty($_POST['year'])){
            $schoolyearErr = "School Year is required";
        }
        
        if(empty($_POST['date_sub'])){
            $dateofsubErr = "Date of submission is required";
        }
        
        if(empty($_POST['sub'])){
            $subErr = "Subject of study is required";
        }
        
        if(empty($_POST['last1'])){
            $last1Err = "Last name of First Author is required";
        }
        
        if(empty($_POST['first1'])){
            $first1Err = "First Name of First Author is required";
        }
        if(empty($_POST['last2'])){
            $last2Err = "Last name of Second Author is required";
        }
        
        if(empty($_POST['first2'])){
            $first2Err = "First Name of Second Author is required";
        }
        if(empty($_POST['last3'])){
            $last3Err = "Last name of Third Author is required";
        }
        
        if(empty($_POST['first3'])){
            $first3Err = "First Name of Third Author is required";
        }
        
        if(empty($_POST['last4'])){
            $last4Err = "Last name of Adviser is required";
        }
        
        if(empty($_POST['first4'])){
            $first4Err = "First name of Adviser is required";
        }
        if(empty($_POST['last5'])){
            $last5Err = "Last name of Co-Adviser is required";
        }
        
        if(empty($_POST['first5'])){
            $first5Err = "First name of Co-Adviser is required";
        }

        if(empty($_POST['email'])){
            $emailErr = "Email is required";
        }
        
        if(empty($_POST['contact'])){
            $contactErr = "Mobile number is required";
        }

        if(isset($_POST['contact'])){
            $mobile = $_POST['contact'];
        }else{
            $mobile = "9999999999";
        }

        if(strlen($mobile)!=10){
            $contactErr = "Mobile number should be 10 digits";
        } 
    ?>

    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">        
            <div>
                <div class="nav">
                    <div class="nav-lasalle">
                        <img  src="img/lasalle dasma logo.png" alt="">
                    </div>

                    <div class="nav-container">
                        <h4 onClick="dashboardpageFunction()">DASHBOARD</h4>
                    </div>

                    <div class="nav-container">
                        <h4 onClick="searchpageFunction()">SEARCH</h4>
                    </div>

                    <div class="nav-container">
                        <h4 onClick="loginpageFunction()">LOGIN</h1>
                    </div>
                </div>
            </div> 
        <div class="content-container">

            
            <div class="sub-container">
                <!--PART_1-->
                <h3>Thesis Registration</h3>
                <p>Input all necessary details to register Thesis</p>
                <div class="text-container">
                    <label class="box-left">Title</label>
                </div>
                
                <div class="container">
                    <input class="box-center" type="text" id="title" name="title">
                </div>

                <div class="text-container">
                    <label class="box-left">Program</label>
                    <label class="box-left">Co-program</label>
                    <label class="box-left">Subject of Study</label>
                </div>
                    
                <div class="container">
                    <select style="height: 31.3px;" class="box-center" name="course" id="course">
                        <option class="op;" value="">Select Program</option>
                        <option value="ARCH">Architecture</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="CPE">Computer Engineering</option>
                        <option value="EE">Electrical Engineering</option>
                        <option value="ECE">Electronics Engineering</option>
                        <option value="IE">Industrial Engineering</option>
                        <option value="ME">Mechanical Engineering</option>
                        <option value="SE">Sanitary Engineering</option>
                        <option value="MMA">Multimedia Arts</option>
                    </select>
            
                    <select style="height: 31.3px;" class="box-center" name="coco" id="coco">
                        <option value="n/a">Select Co-Program</option>
                        <option value="ARCH">Architecture</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="CPE">Computer Engineering</option>
                        <option value="EE">Electrical Engineering</option>
                        <option value="ECE">Electronics Engineering</option>
                        <option value="IE">Industrial Engineering</option>
                        <option value="ME">Mechanical Engineering</option>
                        <option value="SE">Sanitary Engineering</option>
                        <option value="MMA">Multimedia Arts</option>
                    </select>
                   
                    <select style="height: 31.3px;" class="box-center" name="sub" id="sub">
                        <option value="">Select Topic</option>
                        <option value="AGRI">Agriculture</option>
                        <option value="BIO">Biology</option>
                        <option value="EDU">Education</option>
                        <option value="HP">Health</option>
                        <option value="AI">Machine Learning</option>
                        <option value="TECH">Technology</option>
                    </select>
                </div>

                <div class="text-container">
                    <label class="box-left">School Year</label>
                    <label class="box-left">Submission Date</label>
                </div>

                <div class="container">
                    <input class="box-center" class="box-size" type="text" name="year" id="year">
                    <input style="height: 28px;" class="box-center" type="date" name="date_sub" id="date_sub">
                </div>
            
                <br>

                <!--PART_2-->
                <h3>Author 1</h3>
                <div class="text-container">
                    <label class="box-left">Last Name: </label>
                    <label class="box-left">First Name: </label>
                    <label class="box-left">Middle Name: </label>
                </div>
            
                <div class="container">
                    <input class="box-center" type="text" name="last1" id="last1">
                    <input class="box-center" type="text" name="first1" id="first1">
                    <input class="box-center" type="text" name="mid1" id="mid1">
                </div>
            
                <h3>Author 2</h3>
                <div class="text-container">
                    <label class="box-left" >Last Name: </label>
                    <label class="box-left" >First Name: </label>
                    <label class="box-left" >Middle Name: </label>
                </div>
            
                <div class="container">
                    <input class="box-center"  type="text" name="last2" id="last2">
                    <input class="box-center"  type="text" name="first2" id="first2">
                    <input class="box-center"  type="text" name="mid2" id="mid2">
                </div>
            
                <h3>Author 3</h3>
                <div class="text-container">
                    <label class="box-left" >Last Name: </label>
                    <label class="box-left" >First Name: </label>
                    <label class="box-left" >Middle Name: </label>
                </div>
            
                <div class="container">
                    <input class="box-center"  type="text" name="last3" id="last3">
                    <input class="box-center"  type="text" name="first3" id="first3">
                    <input class="box-center"  type="text" name="mid3" id="mid3">
                </div>
            
                <br>

                <!--PART_3-->
                <h3>Adviser</h3>
                <div class="text-container">
                    <label class="box-left">Last Name: </label>
                    <label class="box-left">First Name: </label>
                    <label class="box-left">Middle Name: </label>
                </div>
                    
                <div class="container">
                    <input class="box-center" type="text" name="last4" id="last4">
                    <input class="box-center" type="text" name="first4" id="first4">
                    <input class="box-center" type="text" name="mid4" id="mid4">
                </div>
                
                <h3>Co-Adviser</h3>
                <div class="text-container">
                    <label class="box-left">Last Name: </label>
                    <label class="box-left">First Name: </label>
                    <label class="box-left">Middle Name: </label>
                </div> 
                
                <div class="container">
                    <input class="box-center" type="text" name="last5" id="last5">
                    <input class="box-center" type="text" name="first5" id="first5">
                    <input class="box-center" type="text" name="mid5" id="mid5">
                </div>

                <!--PART_4-->

                <h3>Contact Information</h3>
                <div class="text-container">
                    <label class="box-left">Email: </label>
                    <label class="box-left">Mobile Phone: </label>
                </div>
            
                <div class="container">
                    <input class="box-center" type="email" name="email" id="email">
                    <input class="box-center" type="tel" name="contact" id="contact">
                </div>
            
                <br>
            
                <div>
                    <center><input class="button" type="submit" name="submit"></center>
                </div>

                <?php
                    if(isset($_POST['submit'])){
                        if($titleErr==""&&$programErr==""&&$subErr==""&&$schoolyearErr==""&&$dateofsubErr==""
                        &&$last1Err==""&&$first1Err==""&&$last2Err==""&&$first2Err==""&&$last3Err==""&&$first3Err==""
                        &&$last4Err==""&&$first4Err==""&&$last5Err==""&&$first5Err==""&&$emailErr==""&&$contactErr==""){
                            $serverName="DESKTOP-FQOOPV8\SQLEXPRESS";
                            $connectionOptions=[
                                "Database"=>"WEBAPP",
                                "Uid"=>"",
                                "PWD"=>""
                            ];

                            $conn=sqlsrv_connect($serverName, $connectionOptions);
                            if($conn==false)
                            die(print_r(sqlsrv_errors(),true));
                            
                            //FIRST TABLE
                            $title=$_POST['title'];
                            $course=$_POST['course'];
                            $coco=$_POST['coco'];
                            $year=$_POST['year'];
                            $date_sub=$_POST['date_sub'];
                            $sub=$_POST['sub'];
                            
                            //SECOND TABLE
                            $authorl1=$_POST['last1'];
                            $authorf1=$_POST['first1'];
                            $authorm1=$_POST['mid1'];
                            
                            $authorl2=$_POST['last2'];
                            $authorf2=$_POST['first2'];
                            $authorm2=$_POST['mid2'];
                            
                            $authorl3=$_POST['last3'];
                            $authorf3=$_POST['first3'];
                            $authorm3=$_POST['mid3'];
                            
                            //THIRD TABLE
                            $adviserl1=$_POST['last4'];
                            $adviserf1=$_POST['first4'];
                            $adviserm1=$_POST['mid4'];
                            
                            //FOURTH TABLE
                            $adviserl2=$_POST['last5'];
                            $adviserf2=$_POST['first5'];
                            $adviserm2=$_POST['mid5'];
                            
                            //FIFTH TABLE
                            $email=$_POST['email'];
                            $contact=$_POST['contact'];
                            
                            $table1="INSERT INTO TITLE (TITLE_, PROGRAM, CO_PROGRAM, SCHOOL_YEAR, SUB_DATE, SUBJECT_) VALUES ('$title', '$course', '$coco', '$year', '$date_sub', '$sub')";  
                            $results1=sqlsrv_query($conn, $table1);


                            $SQL="SELECT TITLEID FROM TITLE WHERE TITLEID=(SELECT IDENT_CURRENT('TITLE'))";  
                            $results=sqlsrv_query($conn, $SQL);

                            $titleid=sqlsrv_fetch_array($results);
                            $id=$titleid['TITLEID'];


                            $table2_1="INSERT INTO AUTHOR (LAST_NAME, MIDDLE_NAME, FIRST_NAME, TITLEID) VALUES ('$authorl1', '$authorm1', '$authorf1', '$id')"; 
                            $table2_2="INSERT INTO AUTHOR (LAST_NAME, MIDDLE_NAME, FIRST_NAME, TITLEID) VALUES ('$authorl2', '$authorm2', '$authorf1', '$id')"; 
                            $table2_3="INSERT INTO AUTHOR  (LAST_NAME, MIDDLE_NAME, FIRST_NAME, TITLEID) VALUES ('$authorl3', '$authorm3', '$authorf3','$id')"; 
                            $table3="INSERT INTO ADVISER  (LAST_NAME, MIDDLE_NAME, FIRST_NAME, TITLEID) VALUES ('$adviserl1', '$adviserm1', '$adviserf1','$id')"; 
                            $table4="INSERT INTO COADVISER (LAST_NAME, MIDDLE_NAME, FIRST_NAME, TITLEID) VALUES ('$adviserl2', '$adviserm2', '$adviserf2','$id')"; 
                            $table5="INSERT INTO CONTACT (EMAIL, MOBILE_NUMBER, TITLEID) VALUES ('$email', '$contact','$id')";


                            $results2_1=sqlsrv_query($conn, $table2_1);
                            $results2_2=sqlsrv_query($conn, $table2_2);
                            $results2_3=sqlsrv_query($conn, $table2_3);
                            $results3=sqlsrv_query($conn, $table3);
                            $results4=sqlsrv_query($conn, $table4);
                            $results5=sqlsrv_query($conn, $table5);   
                            
                           
                            if($results1){
                                header("Location: success.php");
                                exit();
                            }else{
                                echo "<h1>Registration not Complete</h1>";
                            }
                        }else{
                            echo "<h3>Fill up the form correctly.</h3>";
                            echo "<h1>$titleErr</h1>";
                            echo "<h1>$programErr</h1>";
                            echo "<h1>$subErr</h1>";
                            echo "<h1>$schoolyearErr</h1>";
                            echo "<h1>$dateofsubErr</h1>";
                            echo "<h1>$last1Err</h1>";
                            echo "<h1>$first1Err</h1>";
                            echo "<h1>$last2Err</h1>";
                            echo "<h1>$first2Err</h1>";
                            echo "<h1>$last3Err</h1>";
                            echo "<h1>$first3Err</h1>";
                            echo "<h1>$last4Err</h1>";
                            echo "<h1>$first4Err</h1>";
                            echo "<h1>$last5Err</h1>";
                            echo "<h1>$first5Err</h1>";
                            echo "<h1>$emailErr</h1>";
                            echo "<h1>$contactErr</h1>";
                        }
                    }
                ?>
            </div>
        </div>
    </form>
</body>
</html>

<?php
ob_end_flush();
?>

