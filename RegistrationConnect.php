<?php
$serverName="DESKTOP-FQOOPV8\SQLEXPRESS";
$connectionOptions=[
    "Database"=>"WEBAPP",
    "Uid"=>"",
    "PWD"=>""
];
$conn=sqlsrv_connect($serverName, $connectionOptions);
if($conn==false)
die(print_r(sqlsrv_errors(),true));
else echo 'Woohoo';

$studentname=$_POST['ipe'];
$email=$_POST['email'];
$year=$_POST['year'];
$mobile=$_POST['mobile'];

$SQL="INSERT INTO STUDENT (STUDENT_NAME, STUDENT_EMAIL, YEAR_LEVEL, MOBILE_NUMBER) VALUES ('$studentname', '$email', '$year', '$mobile')";  
$results=sqlsrv_query($conn, $SQL);

if($results){
    echo 'Registration Complete';
}else{
    echo 'Boohoo';
}