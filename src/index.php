<?php
session_start();
if ($_SESSION['logged_in'] === 'No') {
    header("Location:login.php", TRUE, 302);
} else if ($_SESSION['logged_in'] === 'Yes') {
    $log = true;
} else {
    $_SESSION['logged_in'] = 'No';
    $log = false;
}
?>
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
                <a href="#" class="brand-logo">To-Do List</a>
                <ul id="nav-mobile" class="right hide-on-med-and-dow">
                    <li>
                        <?php 
                            if ($log === false) {
                                echo '<a href="login.php">Login</a>';
                            } else if ($log === true) {
                                echo '<a href="actions/logout-action.php">Logout</a>';
                            }
                        ?>
                    </li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <ul id="myList">
        </ul>
    </div>

    <div class="container">
        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input id="task_name" type="text" class="validate" value="" onkeyup="saveState()">
                        <label for="task_name">New Task Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="duedate" type="text" class="datepicker" value="" onsubmit="saveState()">
                        <label for="duedate">Due Date</label>
                    </div>
                </div>
            </form>
            <button class="btn waves-effect waves-light" type="submit" name="action" id="button">Add Task
                <i class="material-icons right">add</i>
            </button>
        </div>
    </div>

    <div class="container">
        <button class="btn waves-effect waves-light" type="submit" name="action" id="sort_button">Sort List
            <i class="material-icons right">list</i>
        </button>
        <button class="btn waves-effect waves-light" type="submit" name="action" id="unsort_button">Unsort List
            <i class="material-icons right">list</i>
        </button>
    </div>

    <div class="container">
        <?php
        if (isset($_SESSION["newuser"])) {
            echo '
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel" style="background-color: #e64a19">
                    <span class="white-text">' . $_SESSION["newuser"] . '</span>
                </div>
            </div>
        </div>';
            unset($_SESSION["newuser"]);
        }
        if (isset($_SESSION["login_user"])) {
            echo '
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel" style="background-color: #e64a19">
                    <span class="white-text">' . $_SESSION["login_user"] . '</span>
                </div>
            </div>
        </div>';
            unset($_SESSION["login_user"]);
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