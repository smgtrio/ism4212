<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require '../includes/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);


include_once("includes.php");
//$utility = new Utility($conn_iss, "user");
$tbl = 'user';
?>
<!-- ##### Submit Registration ##### -->
<!-- ##### Verify account ##### -->

<div id="register" class="app" style="">
    <?php
    if (isset($_POST['submitRegister'])) {
        function test_input($data): string
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email_posted = test_input($_POST['email']);
        $username = test_input($_POST['username']);
        $password1 = test_input($_POST['password1']);
        $password2 = test_input($_POST['password2']);
        $fname = test_input($_POST['first_name']);
        $lname = test_input($_POST['last_name']);
        $fsu_id = test_input($_POST['fsu_id']);

// https://www.w3schools.com/php/php_form_required.asp
        $result = $conn_iss->query("SELECT email FROM user WHERE email = '$email_posted' ");
        if ($result->rowCount() > 0) {
            messageWithFadeOut("This email is already registered...", 'message', 'danger', '5000');
        } elseif (empty($email_posted)) {
            messageWithFadeOut('Email address is required.');
        } elseif (empty($password1) || empty($password2)) {
            messageWithFadeOut('Type the password again.');
        } elseif ($password1 != $password2) {
            messageWithFadeOut("The passwords do not match.");
        } elseif (empty($username)) {
            messageWithFadeOut('Username is required.');
        } elseif (empty($fname)) {
            messageWithFadeOut('First name is required');
        } elseif (empty($lname)) {
            messageWithFadeOut('Last name is required.');
        } elseif (empty($fsu_id)) {
            messageWithFadeOut('FSU ID is required.');
        } else {
            if (!filter_var($email_posted, FILTER_VALIDATE_EMAIL)) {
                messageWithFadeOut('Email address format incorrect.');
            } elseif (preg_match('/^[a-zA-Z_\-0-9]+$/', $username) === 0) {
                messageWithFadeOut('Only letters and numbers are allowed in Username.');
            } elseif (!preg_match("/^[a-zA-Z_\-]+$/", $fname)) {
                messageWithFadeOut('First name contains invalid character.');
            } elseif (!preg_match("/^[a-zA-Z_\-]+$/", $lname)) {
                messageWithFadeOut('Last name contains invalid character.');
            } else {
                $pass_hash = password_hash($password1, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user(email, password, username, first_name, last_name, fsu_id, date_registered ) VALUES ( '$email_posted', '$pass_hash', '$username', '$fname', '$lname', '$fsu_id', CURRENT_TIMESTAMP)  ";
                $conn_iss->exec($sql);

                $token = substr("abcdefghijklmnopqrstuvwxyz", mt_rand(0, 25), 1) . substr(md5(time()), 1);
                $hashRegVerify = password_hash("$token", PASSWORD_DEFAULT);
                $sql = "UPDATE user SET hash_reg_verify = '$hashRegVerify' WHERE email = '$email_posted' ";
                $stmt = $conn_iss->prepare($sql)->execute();


                ##### send email with token link
                $link = "<a href='$iss/user/register.php?emailRegVerify=" . $email_posted . "&hashRegVerify=" .
                    $hashRegVerify . "'> Click here to verify your bashnet.org account registration.</a>";
/// http://talkerscode.com/webtricks/password-reset-system-using-php.php
                try {
                    // the headers: https://stackoverflow.com/questions/28026932/php-warning-mail-sendmail-from-not-set-in-php-ini-or-custom-from-head
//                    $headers = 'MIME-Version: 1.0' . "\r\n";
//                    $headers .= 'From: tychen@bashnet.org<tychen@bashnet.org>' . "\r\n";
//                    $headers .= '-f tychen@bashnet.org<tychen@bashnet.org>' . "\r\n";
//                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    // the message
                    $msg = "
In response to your request for account registration on bashnet.org:<br> 
                -------------------------------------------------------------------------------------------------------- <br>
                DO NOT REPLY to this email. Contact your system administrator for technical issues. <br>
                -------------------------------------------------------------------------------------------------------- <br>
                <br>
                VERIFICATION: $link. <br>
                <br>
                If the link above is not working for you, copy and paste the URL below
                and paste to the address bar of your browser and hit enter to verify your account:<br>
                   https://bashnet.org/user/register.php?emailRegVerify=$email_posted&hashRegVerify=$hashRegVerify
                    ";

                    $msg_text = "
In response to your request for account registration on bashnet.org:
------------------------------------------------------------------------------------------------------- 
                DO NOT REPLY to this email. Contact your system administrator for technical issues. 
-------------------------------------------------------------------------------------------------------- 
               
               Copy and paste the URL below and paste to the address bar of your browser and hit enter to verify your account:
               https://bashnet.org/user/register.php?emailRegVerify=$email_posted&hashRegVerify=$hashRegVerify
                    ";

//                    try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host = 'smtp.ionos.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                    $mail->Username = 'tychen@tychen.us';                     //SMTP username
                    $mail->Password = 'Redcar.2019';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have
                    // set `SMTPSecure
                    // = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('tychen@tychen.us', 'FSU iSchool bashnet.org Admin');
                    $mail->addAddress($email_posted, "$fname $lname");     //Add a recipient
//                        $mail->addAddress('ellen@example.com');               //Name is optional
                    $mail->addReplyTo('tychen@tychen.us', 'TY Chen');
//                        $mail->addCC('cc@example.com');
//                        $mail->addBCC('bcc@example.com');

                    //Attachments
//                        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//                        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'FSU iSchool bashnet.org: Verify Your Account Registration';
                    $mail->Body = "$msg";
                    $mail->AltBody = "$msg_text";
?>
                    <div style="opacity: 0">
    <?php
                    $mail->send();
                    ?>
                    </div>
    <?php
                    messageWithFadeOut("Account verification email sent.<br> Check your Spam folder if you do not see the email.", 'message', 'success', '9000');
                    redirect('../index.php', '10000');
                    exit;
                } catch (Exception $e) {
                    messageWithFadeOut('message', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }

                // send emailå
//                    mail("$email_posted", "bashnet.org: Verify Your Account Registration", "$msg","$headers");
//                } catch (Exception $exception) {
//                    echo $exception;
            }
            // will make request page disappear

        }
//        }
        ##### Verification #####
        ##### Verification #####
    } elseif (isset($_GET['emailRegVerify']) && isset($_GET['hashRegVerify'])) {

        $emailRegVerify_email = $_GET['emailRegVerify'];
        $hashRegVerify_email = $_GET['hashRegVerify'];
        $sql = "SELECT email, hash_reg_verify FROM user WHERE email = '$emailRegVerify_email'";
        $row = $conn_iss->query($sql)->fetch();
        $email_db = $row['email'];
        $hashRegVerify_db = $row['hash_reg_verify'];
        if ($hashRegVerify_email == $hashRegVerify_db) {

            $verified = $utility->select_one_one('account_verified', 'email', "$emailRegVerify_email");
            if ($verified == 0) {
                $time = current_time($conn_iss);
                $utility->update_two_one('account_verified', '1', 'date_verified', "$time", 'email', "$emailRegVerify_email");

                messageWithFadeOut("Congratulations! Verification completed. Redirecting to homepage...", 'message', 'success', '5000');
                redirect('../index.php', '6000');
                exit; // to stop showing the registration form
            } else {
                messageWithFadeOut("You have already verified this account.<br> Redirecting to homepage...", 'message', 'danger', '5000');
                exit();
            }
        } else {
            messageWithFadeOut("There is a problem with your verification email.<br> Please contact your system administrator.", 'message',
                'danger', '5000');
            exit();
        }
    }
    ?>


    <div class="container-fluid" id="">
        <div class="row divUserElement">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <!-- ////////// THE Registration FORM ////////// -->
                <form name="form" method="post" action="">

                    <div class="form-inline form-group">
                        <label class="col-md-4"></label> <label class="" style="font-weight: bold"> REGISTER </label>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="text" autocomplete="email"
                                                                placeholder="Your FSU email" name="email">
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="password"
                                                                autocomplete="new-password"
                                                                placeholder="password" name="password1" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="password"
                                                                autocomplete="new-password"
                                                                placeholder="password" name="password2" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="text" name="username"
                                                                autocomplete="username"
                                                                placeholder="username" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="text"
                                                                placeholder="first name" name="first_name" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="text" name="last_name"
                                                                placeholder="last name" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label> <input class="form-control" type="text" name="fsu_id"
                                                                placeholder="FSU ID" required>
                    </div>
                    <div class="form-inline">
                        <label class="col-md-4"></label>
                        <div class="col-md-8 row">
                            <button class="btn col-4" id="divUserButton" type="submit"
                                    name="submitRegister">Submit
                            </button>
                        </div>
                    </div>
                </form>
                <!-- ////////// END OF Registration FORM ////////// -->
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</div>
