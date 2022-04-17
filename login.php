<!--
    ##### in this login script, you need a "user" table
-->
<?php
include_once("includes.php");
if (isset($_SESSION['email'])) {
    $email_iss = $_SESSION['email'];
    $username_iss = $_SESSION['username'];
}


if (isset($_POST['login'])) {
    $email_posted = $_POST['email'];
    $password_posted = $_POST['password'];

    ### get vars
    $sql = "SELECT customer_id, `password`, email, username, user_type FROM customers WHERE email = '$email_posted' ";
    $results = $conn->query($sql)->fetch();
    if (!is_null($results)) { ### must use "is_null"
        $uid = $results['customer_id'] ? $results['customer_id'] : '';
        $email = $results['email'] ? $results['email'] : '';
        $password_db = $results['password'] ? $results['password'] : '';
        echo "email: $email";

        if ($password_posted != $password_db) {
            echo "Password or email not correct.";
            header('Location: login.php');
            exit;
        }
        ### password match
        else {
            ##### create sessions ==> make sure to go to headers.php to make vars #####
            $_SESSION['customer_id'] = $results['customer_id'];
            $_SESSION['email'] = $results['email'];
            $_SESSION['username'] = $results['username'];
            $_SESSION['user_type'] = $results['user_type'];
            $email = $_SESSION['email']; //            $time = current_time($conn_iss);
            header('Location: home.php');
            exit;
        }
    }
    else {
        echo "Email address incorrect.";
        header('Location: login.php');
        exit;
    }

}
?>

<div id="login" class="app">

    <!-- ##### login FORM ##### -->
    <div class="container-fluid" id="">
        <div class="row divUserElement">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">

                <form name="form" method="post" action="">
                    <div class="form-inline form-group">
                        <label class="col-md-4"></label> <label class="" style="font-weight: bold"> LOG IN </label>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="text" placeholder="email"
                            name="email" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="password"
                            placeholder="password" name="password" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label>
                        <div class="col-md-8 row">

                            <button class="btn col-4" style="display: inline" id="divUserButton" type="submit"
                                name="login">Login
                            </button>

                        </div>
                    </div>
                </form>

            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</div>