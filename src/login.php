<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <link rel="stylesheet" href="css/styles.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <div class="container">
                <a href="index.php" class="brand-logo">To-Do List</a>
                <ul id="nav-mobile" class="right hide-on-med-and-dow">
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <form class="col s12" action="actions/login-action.php" method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="username" required>
                        <label for="password">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" class="validate" name="password" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit">Login
                    <i class="material-icons right">check</i>
                </button>
            </form>
        </div>
    </div>

    <div class="container">
    <?php
        if (isset($_SESSION["login_error"])) {
            echo'
            <div class="row">
                <div class="col s12 m5">
                    <div class="card-panel" style="background-color: #e64a19">
                        <span class="white-text">' . $_SESSION["login_error"] . '</span>
                    </div>
                </div>
            </div>';
            unset($_SESSION["login_error"]);
        }
        ?>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        function saveState() {
            var x = document.getElementById("task_name").value;
            var y = document.getElementById("duedate").value;
            localStorage.setItem("task_name", x);
            localStorage.setItem("duedate", y);
        }
    </script>
</body>

</html>