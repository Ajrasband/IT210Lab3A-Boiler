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
            <form class="col s12" action="actions/login-action.php" method="$_POST">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="text" class="validate">
                        <label for="password">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit">Login
                    <i class="material-icons right">check</i>
                </button>
            </form>
        </div>
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