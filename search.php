<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Registration Form</title>
    <link rel="stylesheet" href="thesis.css">
    <script>
        function dashboardpageFunction() {
            window.location.href = "dashboard.php";
        }

        function registerpageFunction() {
            window.location.href = "thesisreg.php";
        }

        function loginpageFunction() {
            window.location.href = "login.php";
        }
    </script>
</head>

<!--   -->

<body>
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
                    <h4 onClick="registerpageFunction()">REGISTER</h4>
                </div>

                <div class="nav-container">
                    <h4 onClick="loginpageFunction()">LOGIN</h1>
                </div>
            </div>
        </div>

        <div class="content-container">
             <div class="sub-container">
                <h1 style="font-size: 40px; text-align: center; margin-bottom:1%;">SEARCH THESIS</h1>

                <center>
                    <div>
                    <?php
                        $serverName = "DESKTOP-FQOOPV8\SQLEXPRESS";
                        $connectionOptions = [
                            "Database" => "WEBAPP",
                            "Uid" => "",
                            "PWD" => ""
                        ];

                        $conn = sqlsrv_connect($serverName, $connectionOptions);

                        if ($conn == false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

                        $sql = "SELECT T.TITLEID, T.TITLE_, T.PROGRAM, MIN(A.LAST_NAME) AS A_LAST_NAME, MAX(A.FIRST_NAME) AS A_FIRST_NAME, 
                                AD.LAST_NAME AS AD_LAST_NAME, AD.FIRST_NAME AS AD_FIRST_NAME, M.PATH
                                FROM TITLE AS T 
                                INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                INNER JOIN ADVISER AS AD ON T.TITLEID = AD.TITLEID
                                LEFT OUTER JOIN ABSTRACT AS M ON T.TITLEID = M.TITLEID
                                WHERE T.TITLE_ LIKE ? OR A.LAST_NAME LIKE ? OR A.FIRST_NAME LIKE ? OR AD.LAST_NAME LIKE ? OR AD.FIRST_NAME LIKE ?
                                GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM, AD.LAST_NAME, AD.FIRST_NAME, M.PATH";

                        $params = ['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%'];

                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        $sql2 = "SELECT COUNT(*) AS TOTAL 
                                FROM (
                                    SELECT T.TITLEID 
                                    FROM TITLE AS T 
                                    INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                    INNER JOIN ADVISER AS AD ON T.TITLEID = AD.TITLEID
                                    WHERE T.TITLE_ LIKE ? OR A.LAST_NAME LIKE ? OR A.FIRST_NAME LIKE ? OR AD.LAST_NAME LIKE ? OR AD.FIRST_NAME LIKE ?
                                    GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM
                                ) AS FilteredResults";

                        $countResults = sqlsrv_query($conn, $sql2, $params);
                        if ($countResults === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        $totalcount = sqlsrv_fetch_array($countResults);
                    ?>

                        <center>
                            <form method="POST">
                                <input 
                                    class="search" 
                                    type="text" 
                                    placeholder="Search by title, author, or adviser" 
                                    name="search" 
                                    id="search" 
                                    value="<?php echo htmlspecialchars($searchTerm); ?>">
                                <button class="button-report" type="submit" name=submit>Search</button>
                            </form>
                        </center>

                        <br>

                        <table class="table-design">
                            <thead>
                                <tr>
                                    <th>TitleID</th>
                                    <th>Title</th>
                                    <th>Program</th>
                                    <th>Author Last Name</th>
                                    <th>Author First Name</th>
                                    <th>Adviser Last Name</th>
                                    <th>Adviser First Name</th>
                                    <th>Abstract</th>
                                </tr>
                            </thead>

                            <?php
                                if(isset($_POST['submit'])){
                                while ($rows = sqlsrv_fetch_array($results)) {
                                    $fieldname1 = $rows['TITLEID'];
                                    $fieldname2 = $rows['TITLE_'];
                                    $fieldname3 = $rows['PROGRAM'];
                                    $fieldname4 = $rows['A_LAST_NAME'];
                                    $fieldname5 = $rows['A_FIRST_NAME'];
                                    $fieldname6 = $rows['AD_LAST_NAME'];
                                    $fieldname7 = $rows['AD_FIRST_NAME'];
                                    $fieldname8 = $rows['PATH'];

                                    $cheese  = "http://localhost/webapp/THESIS_REG/uploads/";

                                    $change = substr($fieldname8, 42);
                                    $wow = $cheese.$change;

                                    echo '<tr>
                                            <td>' . $fieldname1 . '</td>
                                            <td>' . $fieldname2 . '</td>
                                            <td>' . $fieldname3 . '</td>
                                            <td>' . $fieldname4 . '</td>
                                            <td>' . $fieldname5 . '</td>
                                            <td>' . $fieldname6 . '</td>
                                            <td>' . $fieldname7 . '</td>
                                            <td>';
        
                                                if ($fieldname8 !== null) {
                                                    echo '<form action="' . htmlspecialchars($wow) . '" method="POST">
                                                            <button type="submit">VIEW</button>
                                                            </form>';
                                                }else{
                                                    echo "n/a";
                                                }
                                            echo '</td>
                                        </tr>';
                                }}
                            ?>
                        </table>
                        
                        <?php
                            if (isset($_POST['submit'])) {
                                echo '<h5 align="center">Total Records: ' . $totalcount['TOTAL'] . '</h5>';
                            }
                        ?>
                    </div>
                </center>
            </div>
        </div>
    </form>
</body>

</html>
