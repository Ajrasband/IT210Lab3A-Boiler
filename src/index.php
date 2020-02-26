<?php
session_start();
include 'config/settings.php'; //DB Connect Function Defined Here

if ($_SESSION['logged_in'] === 'No') {
    header('Location:login.php', TRUE, 302);
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
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <!--Import materialize.css-->
    <link type='text/css' rel='stylesheet' href='css/materialize.min.css' media='screen,projection' />

    <link rel='stylesheet' href='css/styles.css'>

    <!--Let browser know website is optimized for mobile-->
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
</head>

<body>
    <nav>
        <div class='nav-wrapper'>
            <div class='container'>
                <a href='#' class='brand-logo'>To-Do List</a>
                <ul id='nav-mobile' class='right hide-on-med-and-dow'>
                    <li>
                        <?php
                        if ($log === false) {
                            echo '<a href="login.php">Login</a>';
                        } else if ($log === true) {
                            echo '<a href="actions/logout-action.php">Logout</a>';
                        }
                        ?>
                    </li>
                    <li><a href='register.php'>Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class='container'>
        <ul id='myList'>
            <?php
            $conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);
            $sql_get_tasks;

            if($_SESSION['sort'] === 'sort') {
                $sql_get_tasks = 'SELECT task, due_date, done, id FROM Tasks';
            } else if ($_SESSION['sort'] === 'unsort') {
                $sql_get_tasks = 'SELECT task, due_date, done, id FROM Tasks ORDER BY due_date ASC';
            }


            $stmt_get_tasks = $conn->prepare($sql_get_tasks);
            $stmt_get_tasks->execute();
            $stmt_get_tasks->bind_result($task_result, $duedate_result, $done_state, $task_id);

            while ($stmt_get_tasks->fetch()) { ?>
                <li class="list-group-item">
                    <form action="actions/update-action.php" method="post">
                        <button type="submit">
                            <a class="btn waves-effect waves-light"><i class="material-icons">check</i></a>
                        </button>
                        <?php if ($done_state === 1) {
                            echo '<s>';
                        } ?>
                        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                        <span name='task'><?php echo $task_result ?></span>
                        <span name='due_date'><?php echo $duedate_result ?></span>
                        <?php if ($done_state === 1) {
                            echo '</s>';
                        } ?>
                    </form>
                    <form class="delete-form" action="actions/delete-action.php" method="post">
                    <input type="hidden" name="delete" value="<?php echo $task_id; ?>">
                        <button type='submit'><a id="delete-button" class="waves-effect waves-light btn-small"><i class="material-icons right">clear</i>Delete</a></button>
                    </form>
                </li>
            <?php
            }
            $stmt_get_tasks->close();
            $conn->close();
            ?>
        </ul>
    </div>

    <div class='container'>
        <div class='row'>
            <form class='col s12' action="actions/create-action.php" method='post'>
                <div class='row'>
                    <div class='input-field col s6'>
                        <input id='task_name' type='text' class='validate' value='' name='task' required>
                        <label for='task_name'>New Task Name</label>
                    </div>
                    <div class='input-field col s6'>
                        <input id='duedate' type='text' class='datepicker' value='' name='duedate' required>
                        <label for='duedate'>Due Date</label>
                    </div>
                </div>
                <button class='btn waves-effect waves-light' type='submit' id='button'>Add Task
                    <i class='material-icons right'>add</i>
                </button>
            </form>
        </div>
    </div>

    <div class='container'>
        <form action="actions/sort-action.php">
            <button class='btn waves-effect waves-light' type='submit' name='action' id='sort_button'>Sort List
                <i class='material-icons right'>list</i>
            </button>
        </form>
    </div>

    <div class='container'>
        <?php
        if (isset($_SESSION['newuser'])) {
            echo '
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel" style="background-color: #e64a19">
                    <span class="white-text">' . $_SESSION['newuser'] . '</span>
                </div>
            </div>
        </div>';
            unset($_SESSION['newuser']);
        }
        if (isset($_SESSION['login_user'])) {
            echo '
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel" style="background-color: #e64a19">
                    <span class="white-text">' . $_SESSION['login_user'] . '</span>
                </div>
            </div>
        </div>';
            unset($_SESSION['login_user']);
        }
        ?>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type='text/javascript' src='js/materialize.min.js'></script>
    <script src='js/scripts.js'></script>
</body>

</html>