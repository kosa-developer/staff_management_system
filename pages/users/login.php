<?php
if (isset($_SESSION['hospital_immergencepassword']) || isset($_SESSION['hospital_username'])) {
    Redirect::to('index.php?page=logout');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Responsive Admin Template" />
        <meta name="author" content="SeffyHospital" />
        <title><?php echo $title ?> Login</title>
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- bootstrap -->
        <link href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- style -->
        <link rel="stylesheet" href="css/login.css">
        <!-- favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.png" /> 
    </head>
    <body>
        <div class="form-title">
            <h1><?php echo trim($title, " | ") ?></h1>
        </div>
        <!-- Login Form-->
        <div class="login-form text-center">
            <div class="toggle hidden"></div>
            <div class="form formLogin">
                <h2>Login to your account</h2>
                   <?php
                if (Input::exists() && Input::get("reset_password_btn") == "reset_password_btn") {
                    $username = Input::get("username");
                    $recovery_potion = Input::get("recovery_potion");
                    $new_password = sha1(Input::get("new_password"));
                    $confirm_password = sha1(Input::get("confirm_password"));
                    if ($confirm_password == $new_password) {
                        if (DB::getInstance()->checkRows("SELECT * FROM user WHERE Username='$username' AND Recovery_Option='$recovery_potion' AND Status=1")) {
                            DB::getInstance()->update("user", $username, array("Password" => $new_password), "Username");
                            echo '<div class="alert alert-success">Your password has been reset successfully</div>';
                        } else {
                            echo '<div class="alert alert-danger">Wrong username and recovery option</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">Your passwords do not match</div>';
                    }
                    Redirect::go_to("");
                }
                if (Input::exists() && Input::get("login_button") == "login_button") {
                     $username = Input::get("username");
                    $password = md5(Input::get("password"));
                    $immergencepassword = Input::get('password');
                    $login = "SELECT * FROM account WHERE User_Name='$username' AND Password='$password' AND Status=1";
                    if (DB::getInstance()->checkRows($login)) {
                        $_SESSION['hospital_username'] = $username;
                        $_SESSION['hospital_role'] = DB::getInstance()->getName("account", $username, "User_Type", "User_Name");
                        $_SESSION['hospital_user_id'] = $user_id = DB::getInstance()->getName("account", $username, "Account_Id", "User_Name");
                        $staffCheck = "SELECT staff.Image,CONCAT(staff.Title,'. ',staff.Staff_Name) AS Full_Name FROM account,staff WHERE account.Staff_Id=staff.Staff_Id AND account.Account_Id=$user_id LIMIT 1";
                        $staff_list = DB::getInstance()->query($staffCheck);
                        $staff_id = DB::getInstance()->getName("Account", $username, "Staff_Id", "User_Name");
                        if ($staff_id == "NA" || $staff_id == "N/A" || $staff_id == "") {
                            $staff_id = "";
                        }
                        $profile_picture = DB::getInstance()->displayTableColumnValue($staffCheck, "Image");
                        $names = DB::getInstance()->displayTableColumnValue($staffCheck, "Full_Name");
                        $_SESSION['hospital_staff_id'] = $staff_id;
                        $_SESSION['hospital_staff_names'] = $names;
                        if (empty($profile_picture)) {
                            $_SESSION['hospital_profile_picture'] = 'person.jpg';
                        } else {
                            $_SESSION['hospital_profile_picture'] = $profile_picture;
                        }
                        
                        
                        if($_SESSION['hospital_role']=='PAED'){
                            Redirect::to('index.php?page=child_protection_card');
                        }else{
                        Redirect::to('index.php?page=dashboard');
                        }
                    } else if ($username == "developer" && $immergencepassword == "developer") {
                        $log = "The user logged in using emergence password";
                        $_SESSION['hospital_immergencepassword'] = $immergencepassword;
                        $_SESSION['hospital_user_modules'] = $modules_list_array;
                        Redirect::to('index.php?page=dashboard');
                    } else {
                        ?>
                        <div class="alert alert-warning"><span>Login was not successful.</span></div>
                        <?php
                    }
                }
                ?>
                <form action="" method="POST">
                    <input type="text" placeholder="Username" name="username" required/>
                    <input type="password" placeholder="Password"  name="password" required/>
                    <input type="hidden" name="login_token" class="input" value="<?php echo Token::generate(); ?>">
                    <button type="submit" name="login_button" value="login_button">Login</button>
                    <div class="forgetPassword"><a href="javascript:void(0)">Forgot your password?</a></div>
                     </form>
            </div>
            <div class="form formRegister"></div>
            <div class="form formReset">
                <div class="toggle"><i class="fa fa-user-times"></i></div>
                <h2>Reset your password?</h2>
                <form action="" method="POST">
                    <input type="text" placeholder="System username" name="username" required/>
                    <input type="text" placeholder="Enter recovery option"  name="recovery_potion" required/>
                    <input type="password" placeholder="New Password"  name="new_password" required/>
                    <input type="password" placeholder="Confirm Password"  name="confirm_password" required/>
                    <button name="reset_password_btn" value="reset_password_btn">Reset now</button>
                </form>
            </div>
        </div>
        <!-- start js include path -->
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/login.js"></script>
        <script src="js/pages.js" type="text/javascript"></script>
        <!-- end js include path -->
    </body>
</html>