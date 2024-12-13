<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Registration Form</title>
    <link rel="stylesheet" href="thesis.css">
    <script>
        function admindashboardpageFunction(){
            window.location.href="admindash.php";
        }

        function downloadpageFunction() {
            window.location.href = "download.php";
        }

        function logoutpageFunction() {
            window.location.href = "dashboard.php";
        }
    </script>
</head>

<body>
    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
                <div class="nav">
                    <div class="nav-lasalle">
                        <img  src="img/lasalle dasma logo.png" alt="">
                    </div>

                    <div class="nav-container">
                        <h4 onClick="admindashboardpageFunction()">DASHBOARD</h4>
                    </div>

                    <div class="nav-container">
                        <h4 onClick="downloadpageFunction()">DOWNLOAD</h4>
                    </div>

                    <div class="nav-container">
                        <h4 onClick="logoutpageFunction()">LOGOUT</h4>
                    </div>
                </div>
            </div> 
        <div class="content-container">
            <div class="sub-container">
                <h1 style="font-size: 40px; text-align: center; margin-bottom:1%;">COMPLETE REPORT LIST</h1>
                <center>
                    <p>Click choice for table to display.</p>
                </center>

                <center>
                <input <?php if(isset($_POST['search'])) echo 'checked'; ?> class="spacing" type="radio" name="radio-table" value="all-table" id="all-table" />
                <label for="all-table">All</label>

                <input <?php if(isset($_POST['title'])) echo 'checked'; ?> class="spacing" type="radio" name="radio-table" value="title-table" id="title-table" />
                <label for="title-table">Title</label>

                <input <?php if(isset($_POST['program'])) echo 'checked'; ?> class="spacing" type="radio" name="radio-table" value="program-table" id="program-table"/>
                <label for="program-table">Program</label>

                <input <?php if(isset($_POST['author'])) echo 'checked'; ?> class="spacing" type="radio" name="radio-table" value="author-table" id="author-table"/>
                <label for="author-table">Author</label>

                <input  <?php if(isset($_POST['adviser'])) echo 'checked'; ?> class="spacing" type="radio" name="radio-table" value="adviser-table" id="adviser-table"/>
                <label for="adviser-table">Adviser</label>

                <br>

                <div class="all-cont">
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

                        $sql = "SELECT T.TITLEID, T.TITLE_, T.PROGRAM, MIN(A.LAST_NAME) AS LAST_NAME, MAX(A.FIRST_NAME) AS FIRST_NAME
                                FROM TITLE AS T 
                                INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM";

                        $params = [];
                        if (!empty($searchTerm)) {
                            $sql .= " HAVING T.TITLE_ LIKE ? OR MIN(A.LAST_NAME) LIKE ? OR MAX(A.FIRST_NAME) LIKE ?";
                            $params = ['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%'];
                        }

                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        // Count query with filtering
                        $sql2 = "SELECT COUNT(*) AS TOTAL 
                                FROM (
                                    SELECT T.TITLEID 
                                    FROM TITLE AS T 
                                    INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                    GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM
                                    " . (!empty($searchTerm) ? "HAVING T.TITLE_ LIKE ? OR MIN(A.LAST_NAME) LIKE ? OR MAX(A.FIRST_NAME) LIKE ?" : "") . "
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
                                placeholder="Please search by title or author." 
                                name="search" 
                                id="search" 
                                value="<?php echo htmlspecialchars($searchTerm); ?>">
                            <button class="button-report" type="submit" name="submit-all">Search</button>
                        </form>
                    </center>

                    <br>

                    <table class="table-design">
                        <thead>
                            <tr>
                                <th>TitleID</th>
                                <th>Title</th>
                                <th>Program</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                            </tr>
                        </thead>

                        <?php
                        if(isset($_POST['submit'])){
                        while ($rows = sqlsrv_fetch_array($results)) {
                            $fieldname1 = $rows['TITLEID'];
                            $fieldname2 = $rows['TITLE_'];
                            $fieldname3 = $rows['PROGRAM'];
                            $fieldname4 = $rows['LAST_NAME'];
                            $fieldname5 = $rows['FIRST_NAME'];

                            echo '<tr>
                                    <td>' . $fieldname1 . '</td>
                                    <td>' . $fieldname2 . '</td>
                                    <td>' . $fieldname3 . '</td>
                                    <td>' . $fieldname4 . '</td>
                                    <td>' . $fieldname5 . '</td>
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

                <div class="title-cont">
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
                        
                        $searchTitle = isset($_POST['title']) ? $_POST['title'] : '';

                        $sql = "SELECT T.TITLEID, T.TITLE_, T.PROGRAM, MIN(A.LAST_NAME) AS LAST_NAME, MAX(A.FIRST_NAME) AS FIRST_NAME
                                FROM TITLE AS T 
                                INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM";
                        
                        $params = [];
                        if (!empty($searchTitle)) {
                            $sql .= " HAVING T.TITLE_ LIKE ?";
                            $params = ['%' . $searchTitle . '%'];
                        }
                        
                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        
                        $sql2 = "SELECT COUNT(*) AS TOTAL 
                                FROM (
                                    SELECT T.TITLEID 
                                    FROM TITLE AS T 
                                    INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                    GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM
                                    " . (!empty($searchTitle) ? "HAVING T.TITLE_ LIKE ?" : "") . "
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
                                placeholder="Please input title name (EX. Sound Heart...)" 
                                name="title" 
                                id="title" 
                                value="<?php echo htmlspecialchars($searchTitle); ?>">
                            <button class="button-report" type="submit" name="submit-title">Search</button>
                        </form>
                    </center>

                    <br>

                    <table class="table-design">
                        <thead>
                            <tr>
                                <th>TitleID</th>
                                <th>Title</th>
                                <th>Program</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                            </tr>
                        </thead>

                        <?php
                        if(isset($_POST['submit-title']))
                        while ($rows = sqlsrv_fetch_array($results)) {
                            $fieldname1 = $rows['TITLEID'];
                            $fieldname2 = $rows['TITLE_'];
                            $fieldname3 = $rows['PROGRAM'];
                            $fieldname4 = $rows['LAST_NAME'];
                            $fieldname5 = $rows['FIRST_NAME'];

                            echo '<tr>
                                    <td>' . $fieldname1 . '</td>
                                    <td>' . $fieldname2 . '</td>
                                    <td>' . $fieldname3 . '</td>
                                    <td>' . $fieldname4 . '</td>
                                    <td>' . $fieldname5 . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                    <?php
                        if (isset($_POST['submit-title'])) {
                            echo '<h5 align="center">Total Records: ' . $totalcount['TOTAL'] . '</h5>';
                        }
                    ?>
                </div>

                <div class="prog-cont">
                    <?php
                        $serverName = "DESKTOP-FQOOPV8\SQLEXPRESS";
                        $connectionOptions = [
                            "Database" => "WEBAPP",
                            "Uid" => "",
                            "PWD" => ""
                        ];

                        $conn = sqlsrv_connect($serverName, $connectionOptions);

                        if ($conn === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        $selectedProgram = isset($_POST['program']) ? $_POST['program'] : '';

                        $sql = "SELECT T.TITLEID, T.TITLE_, T.PROGRAM, MIN(A.LAST_NAME) AS LAST_NAME, MIN(A.FIRST_NAME) AS FIRST_NAME 
                                FROM TITLE AS T 
                                INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM";
                        
                        $params = [];
                        if (!empty($selectedProgram) && $selectedProgram !== 'n/a') {
                            $sql .= " HAVING T.PROGRAM = ?";
                            $params = [$selectedProgram];
                        }
                        
                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true)); 
                        }
                        
                        $sql2 = "SELECT COUNT(*) AS TOTAL 
                                FROM (
                                    SELECT T.TITLEID 
                                    FROM TITLE AS T 
                                    INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                    GROUP BY T.TITLEID, T.TITLE_, T.PROGRAM
                                    " . (!empty($selectedProgram) && $selectedProgram !== 'n/a' ? "HAVING T.PROGRAM = ?" : "") . "
                                ) AS FilteredResults";
                        
                        $countResults = sqlsrv_query($conn, $sql2, $params);
                        if ($countResults === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        
                        $totalcount = sqlsrv_fetch_array($countResults);                        
                    ?>


                    <center>
                        <form method="POST">
                            <select style="height: 31.3px;" class="box-center" name="program" id="program">
                                <option value="n/a">Select Program</option>
                                <option value="ARCH">Architecture - ARCH</option>
                                <option value="CE">Civil Engineering - CE</option>
                                <option value="CPE">Computer Engineering - CPE</option>
                                <option value="EE">Electrical Engineering - EE</option>
                                <option value="ECE">Electronics Engineering - ECE</option>
                                <option value="IE">Industrial Engineering - IE</option>
                                <option value="ME">Mechanical Engineering - ME</option>
                                <option value="SE">Sanitary Engineering - SE</option>
                                <option value="MMA">Multimedia Arts - MMA</option>
                            </select>
                            <button class="button-report" name="submit-prog">Filter</button>
                        </form>
                    </center>

                    <br>

                    <table class="table-design">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>TitleID</th>
                                <th>Title</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                            </tr>
                        </thead>
                        <?php
                        if(isset($_POST['submit-prog']))
                        while ($rows = sqlsrv_fetch_array($results)) {
                            $fieldname1 = $rows['PROGRAM'];
                            $fieldname2 = $rows['TITLE_'];
                            $fieldname3 = $rows['TITLEID'];
                            $fieldname4 = $rows['LAST_NAME'];
                            $fieldname5 = $rows['FIRST_NAME'];

                            echo '<tr>
                                    <td>' . $fieldname1 . '</td>
                                    <td>' . $fieldname2 . '</td>
                                    <td>' . $fieldname3 . '</td>
                                    <td>' . $fieldname4 . '</td>
                                    <td>' . $fieldname5 . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                    <?php
                        if (isset($_POST['submit-prog'])) {
                            echo '<h5 align="center">Total Records: ' . $totalcount['TOTAL'] . '</h5>';
                        }
                    ?>
                </div>

                <div class="auth-cont">
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

                        $searchAuthor = isset($_POST['author']) ? $_POST['author'] : '';

                        $sql = "SELECT T.TITLEID, T.TITLE_, T.PROGRAM, A.LAST_NAME, A.FIRST_NAME 
                                FROM TITLE AS T 
                                INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID";
                        
                        $params = [];
                        if (!empty($searchAuthor)) {
                            $sql .= " WHERE A.LAST_NAME LIKE ? OR A.FIRST_NAME LIKE ?";
                            $params = ['%' . $searchAuthor . '%', '%' . $searchAuthor . '%'];
                        }
                        
                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        
                        $sql2 = "SELECT COUNT(T.TITLEID) AS TOTAL 
                                FROM TITLE AS T 
                                INNER JOIN AUTHOR AS A ON T.TITLEID = A.TITLEID
                                " . (!empty($searchAuthor) ? "WHERE A.LAST_NAME LIKE ? OR A.FIRST_NAME LIKE ?" : "");
                        
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
                                placeholder="Please input author name (EX. Matthew...)" 
                                name="author" 
                                id="author" 
                                value="<?php echo htmlspecialchars($searchAuthor); ?>">
                            <button class="button-report" type="submit" name="submit-auth">Search</button>
                        </form>
                    </center>

                    <br>

                    <table class="table-design">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>TitleID</th>
                                <th>Title</th>
                            </tr>
                        </thead>

                        <?php
                        if(isset($_POST['submit-auth']))
                        while ($rows = sqlsrv_fetch_array($results)) {
                            $fieldname1 = $rows['TITLEID'];
                            $fieldname2 = $rows['TITLE_'];
                            $fieldname4 = $rows['LAST_NAME'];
                            $fieldname5 = $rows['FIRST_NAME'];

                            echo '<tr>
                                    <td>' . $fieldname5 . '</td>
                                    <td>' . $fieldname4 . '</td>
                                    <td>' . $fieldname1 . '</td>
                                    <td>' . $fieldname2 . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                    <?php
                        if (isset($_POST['submit-auth'])) {
                            echo '<h5 align="center">Total Records: ' . $totalcount['TOTAL'] . '</h5>';
                        }
                    ?>
                </div>

                <div class="advi-cont">
                    <?php
                        $serverName = "DESKTOP-FQOOPV8\SQLEXPRESS";
                        $connectionOptions = [
                            "Database" => "WEBAPP",
                            "Uid" => "",
                            "PWD" => ""
                        ];

                        $conn = sqlsrv_connect($serverName, $connectionOptions);

                        if ($conn === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        $searchAdviser = isset($_POST['adviser']) ? $_POST['adviser'] : '';

                        $sql = "SELECT A.FIRST_NAME, A.LAST_NAME, A.TITLEID, T.TITLE_ 
                                FROM ADVISER AS A 
                                INNER JOIN TITLE AS T ON A.TITLEID = T.TITLEID";
                        
                        $params = [];
                        if (!empty($searchAdviser)) {
                            $sql .= " WHERE A.FIRST_NAME LIKE ? OR A.LAST_NAME LIKE ?";
                            $params = ['%' . $searchAdviser . '%', '%' . $searchAdviser . '%'];
                        }
                        
                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        
                        $sql2 = "SELECT COUNT(A.TITLEID) AS TOTAL 
                                FROM ADVISER AS A 
                                INNER JOIN TITLE AS T ON A.TITLEID = T.TITLEID
                                " . (!empty($searchAdviser) ? "WHERE A.FIRST_NAME LIKE ? OR A.LAST_NAME LIKE ?" : "");
                        
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
                            placeholder="Please input adviser name (EX. John...)" 
                            name="adviser" 
                            id="adviser" 
                            value="<?php echo htmlspecialchars($searchAdviser); ?>">
                        <button class="button-report" type="submit" name='submit-advi'>Search</button>
                    </form>
                    </center>

                    <br>

                    <table class="table-design">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>TitleID</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <?php
                        if(isset($_POST['submit-advi']))
                        while ($rows = sqlsrv_fetch_array($results)) {
                            $fieldname1 = $rows['TITLEID'];
                            $fieldname2 = $rows['TITLE_'];
                            $fieldname4 = $rows['LAST_NAME'];
                            $fieldname5 = $rows['FIRST_NAME'];

                            echo '<tr>
                                    <td>' . $fieldname5 . '</td>
                                    <td>' . $fieldname4 . '</td>
                                    <td>' . $fieldname1 . '</td>
                                    <td>' . $fieldname2 . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                    <?php
                        if (isset($_POST['submit-advi'])) {
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

