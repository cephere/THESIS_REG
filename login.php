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

                    <h3 style="text-align:center; padding:50px">Login</h3>

                    <?php
                    $useridErr = $passwordErr = "";
                    $successMessage = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (empty($_POST['user'])) {
                            $useridErr = "UserID is required";
                        }

                        if (empty($_POST['pass'])) {
                            $passwordErr = "Password is required";
                        }

                        if ($useridErr == "" && $passwordErr == "") {
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

                            $sql = "SELECT * FROM LOGIN2 WHERE USERID = ? AND PASSWORD_ = ?";
                            $params = array($userid, $encrypt);
                            $stmt = sqlsrv_query($conn, $sql, $params);

                            if (sqlsrv_fetch_array($stmt)) {
                                header("Location: admindash.php");
                                exit();
                            } else {
                                $successMessage = "Invalid username or password.";
                            }
                        }
                    }
                    ?>

                    <center>
                        <form id="regis" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <label for="user" style="padding-left:10px">USERID:</label>
                            <input class="login" type="text" name="user" id="user" value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>">
                            <br>
                            <span style="color:red;"><?php echo $useridErr; ?></span>
                            <br>
                            <label for="pass">Password:</label>
                            <input class="login" type="password" name="pass" id="pass">
                            <br>
                            <span style="color:red;"><?php echo $passwordErr; ?></span>
                            <br>
                            <button class="button" type="submit" name="submit">Submit</button>
                        </form>
                        
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
