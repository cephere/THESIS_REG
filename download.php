<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
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

    function reportpageFunction(){
        window.location.href="completereport.php";
    }

    function logoutpageFunction(){
        window.location.href="dashboard.php";
    }
</script>

<body>
    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <div class="nav">
                <div class="nav-lasalle">
                    <img src="img/lasalle dasma logo.png" alt="">
                </div>

                <div class="nav-container">
                    <h4 onClick="admindashboardpageFunction()">DASHBOARD</h4>
                </div>

                <div class="nav-container">
                    <h4 onClick="reportpageFunction()">REPORT</h4>
                </div>

                <div class="nav-container">
                    <h4 onClick="logoutpageFunction()">LOGOUT</h4>
                </div>
            </div>
        </div>

        <div class="content-container">
             <div class="sub-container">
                <h1 style="font-size: 40px; text-align: center; margin-bottom:1%;">DOWNLOAD THESIS</h1>


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

                        // Main query with filtering
                        $sql = "SELECT MANUSID, NAME, SIZE, PATH, M.TITLEID, TITLE_
                                FROM MANUS AS M
                                LEFT OUTER JOIN TITLE AS T ON M.TITLEID = T.TITLEID";
                        
                        $params = [];
                        if (!empty($searchTerm)) {
                            $sql .= " WHERE TITLE_ LIKE ? OR NAME LIKE ? OR PATH LIKE ?";
                            $params = ['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%'];
                        }

                        $results = sqlsrv_query($conn, $sql, $params);
                        if ($results === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        // Count query with the same filtering
                        $sql2 = "SELECT COUNT(*) AS TOTAL 
                                FROM MANUS AS M
                                LEFT OUTER JOIN TITLE AS T ON M.TITLEID = T.TITLEID";
                        
                        if (!empty($searchTerm)) {
                            $sql2 .= " WHERE TITLE_ LIKE ? OR NAME LIKE ? OR PATH LIKE ?";
                        }

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
                                    placeholder="Search by title" 
                                    name="search" 
                                    id="search" 
                                    value="<?php echo htmlspecialchars($searchTerm); ?>">
                                <button class="button-report" type="submit">Search</button>
                            </form>
                        </center>

                        <br>

                        <table class="table-design">
                            <thead>
                                <tr>
                                    <th>ManusID</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Path</th>
                                    <th>TitleID</th>
                                    <th>Title</th>
                                    <th>Download</th>
                                </tr>
                            </thead>

                            <?php
                            while ($rows = sqlsrv_fetch_array($results)) {
                                $fieldname1 = $rows['MANUSID'];
                                $fieldname2 = $rows['NAME'];
                                $fieldname3 = $rows['SIZE'];
                                $fieldname4 = $rows['PATH'];
                                $fieldname5 = $rows['TITLEID'];
                                $fieldname6 = $rows['TITLE_'];

                                $cheese  = "http://localhost/webapp/THESIS_REG/uploads/";

                                $change = substr($fieldname4, 42);
                                $wow = $cheese.$change;

                                error_log("Generated file path: " . $wow);

                                echo '<tr>
                                        <td>' . $fieldname1 . '</td>
                                        <td>' . $fieldname2 . '</td>
                                        <td>' . $fieldname3 . '</td>
                                        <td>' . $fieldname4 . '</td>
                                        <td>' . $fieldname5 . '</td>
                                        <td>' . $fieldname6 . '</td>
                                        <td> 
                                            <a href="' . htmlspecialchars($wow) . '" download="' . htmlspecialchars($fieldname2) . '">
                                            <button type="button">DOWNLOAD</button>
                                            </a>
                                        </td>
                                    </tr>';
                            }
                            ?>
                        </table>

                        <h5 align="center">Total Records: <?php echo $totalcount['TOTAL']; ?></h5>
                    </div>
                </center>
            </div>
        </div>
    </form>
</body>
</html>
