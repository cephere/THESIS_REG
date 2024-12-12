<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Registration Form</title>
    <link rel="stylesheet" href="thesis.css">
</head>

<body>
    <form id="thesis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="content-container">
            <div class="kulay">
                <div>
                    <img class="lasalle" src="img/lasalle dasma logo.png" alt="">

                    <h1 style="text-align:center;">Login</h1>

                    <?php
                    // Initialize error variables
                    $useridErr = $passwordErr = "";
                    $successMessage = "";

                    // Check if form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (empty($_POST['user'])) {
                            $useridErr = "UserID is required";
                        }

                        if (empty($_POST['pass'])) {
                            $passwordErr = "Password is required";
                        }

                        if ($useridErr == "" && $passwordErr == "") {
                            // Database connection
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

                            $userid = $_POST['user'];
                            $password = $_POST["pass"];
                            $encrypt = md5($password);

                            // SQL query to verify user credentials
                            $sql = "SELECT * FROM LOGIN2 WHERE USERID = ? AND PASSWORD_ = ?";
                            $params = array($userid, $encrypt);
                            $stmt = sqlsrv_query($conn, $sql, $params);

                            if (sqlsrv_fetch_array($stmt)) {
                                // Login successful, redirect to report page
                                header("Location: admindash.php");
                                exit();
                            } else {
                                $successMessage = "Invalid username or password.";
                            }
                        }
                    }
                    ?>

                    <center>
                        <!-- Login Form -->
                        <form id="regis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <label for="user">USERID:</label>
                            <input type="text" name="user" id="user" value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>">
                            <br>
                            <span style="color:red;"><?php echo $useridErr; ?></span>
                            <br>
                            <label for="pass">Password:</label>
                            <input type="password" name="pass" id="pass">
                            <br>
                            <span style="color:red;"><?php echo $passwordErr; ?></span>
                            <br>
                            <button type="submit" name="submit">Submit</button>
                        </form>

                        <!-- Display error or success message -->
                        <?php if ($successMessage) : ?>
                            <h2 style="color:red;"><?php echo $successMessage; ?></h2>
                        <?php endif; ?>
                    </center>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
