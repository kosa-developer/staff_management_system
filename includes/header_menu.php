<?php
if ((empty($_SESSION['hospital_user_id'])) && (empty($_SESSION['hospital_immergencepassword']))) {
    Redirect::to('index.php?page=survey_logout');
}
$all = 0;

$previous_page = $_SESSION["PREVIOUS_URL"];

$surveydoneQuery = "select * from survey_codes where Status=0";
$PendingsurveydoneQuery = "select * from survey_codes where Status=1";

$policydoneQuery = "select * from policy_codes where Status=0";
$PendingpolicydoneQuery = "select * from policy_codes where Status=1";

$PolicydoneData = DB::getInstance()->querySample($policydoneQuery);
$PendingpolicydoneData = DB::getInstance()->querySample($PendingpolicydoneQuery);

$SurveydoneData = DB::getInstance()->querySample($surveydoneQuery);
$PendingsurveydoneData = DB::getInstance()->querySample($PendingsurveydoneQuery);

$hidden = "";
$hidden1='';
if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff" || $_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
    $hidden = "hidden";
   $hidden1="";
} else {
    $hidden = "";
     $hidden1="hidden";
}
?>

<div class="page-header navbar navbar-fixed-top" onload="openModel()">
    <div class="page-header-inner ">
        <!-- logo start -->
        <div class="page-logo">
            <a href="index.php?page=dashboard">
                <span class="logo-icon fa fa-hospital-o fa-rotate-left"></span>
                <span class="logo-default" ><?php echo $HOSPITAL_NAME_ABREV ?></span> </a>
        </div>
        <!-- logo end -->
        <ul class="nav navbar-nav navbar-left in">
            <li><a href="javascript:void(0)" class="menu-toggler sidebar-toggler"><i class="icon-menu"></i></a></li>
        </ul>
        <!-- start mobile menu -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- end mobile menu -->
        <!-- start header menu -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- start notification dropdown -->
      <li class="dropdown dropdown-extended dropdown-notification <?php echo $hidden1?>" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge orange-bgcolor"><?php echo DB::getInstance()->countElements("select * from policy_codes"); ?></span>
                    </a>     
                    <ul class="dropdown-menu">
                        <li class="external ">
                            <h3><span class="bold">surveys</span></h3>
                            <span class="notification-label purple-bgcolor"><?php echo DB::getInstance()->countElements("select * from policy_codes"); ?></span>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                                <li>
                                    <!--<a href="javascript:;">-->

                                    <div class="col-lg-6 table-bordered " style="color: blue;">Pending Policy Surveys</div>
                                    <div class="col-lg-6 table-bordered" style="color: blue">Policy Surveys done</div>
                                    <div class="col-lg-6 table-bordered">
                                        <?php
                                        $k = 1;
                                        foreach ($PendingpolicydoneQuery as $pendingPolicy) {
                                            ?>
                                            <div><?php echo $k . ". " . DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$pendingPolicy->Staff_Id'", 'Staff_Name') ?></div> 
                                            <?php
                                            $k++;
                                        }
                                        ?>
                                    </div>

                                    <div class="col-lg-6 table-bordered"> <?php
                                        $i = 1;
                                        foreach ($PolicydoneData as $policydone) {
                                            ?>
                                            <div><?php echo $i . ". " . DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$policydone->Staff_Id'", 'Staff_Name') ?></div>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </div>

                                    <!--</a>-->
                                </li>
                            </ul>
                            <div class="dropdown-menu-footer">
                                <a href="javascript:void(0)"> All notifications </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown dropdown-extended dropdown-notification <?php echo $hidden?>" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge orange-bgcolor"><?php echo DB::getInstance()->countElements("select * from survey_codes "); ?></span>
                    </a>     
                    <ul class="dropdown-menu">
                        <li class="external ">
                            <h3><span class="bold">surveys</span></h3>
                            <span class="notification-label purple-bgcolor"><?php echo DB::getInstance()->countElements("select * from survey_codes"); ?></span>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                                <li>
                                    <!--<a href="javascript:;">-->

                                    <div class="col-lg-6 table-bordered " style="color: blue;">Pending surveys</div>
                                    <div class="col-lg-6 table-bordered" style="color: blue">Surveys done</div>
                                    <div class="col-lg-6 table-bordered">
                                        <?php
                                        $k = 1;
                                        foreach ($PendingsurveydoneData as $pendingSurvey) {
                                            ?>
                                            <div><?php echo $k . ". " . DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$pendingSurvey->Staff_Id'", 'Staff_Name') ?></div> 
                                            <?php
                                            $k++;
                                        }
                                        ?>
                                    </div>

                                    <div class="col-lg-6 table-bordered"> <?php
                                        $i = 1;
                                        foreach ($SurveydoneData as $surveydone) {
                                            ?>
                                            <div><?php echo $i . ". " . DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$surveydone->Staff_Id'", 'Staff_Name') ?></div>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </div>

                                    <!--</a>-->
                                </li>
                            </ul>
                            <div class="dropdown-menu-footer">
                                <a href="javascript:void(0)"> All notifications </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- end notification dropdown -->
                <!-- start manage user dropdown -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle " src="..\staff_image/<?php echo $_SESSION['hospital_profile_picture'] ?>" />
                        <span class="username username-hide-on-mobile"><?php echo $_SESSION['hospital_staff_names']; ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <?php if (!isset($_SESSION['hospital_immergencepassword'])) { ?>

                            <li>
                                <a data-toggle="modal" href="#account_settings"><i class="fa fa-gear"></i>Account Update</a>
                            </li>
                        <?php } ?>
                        <li class="divider"> </li>
                        <li>
                            <a href="index.php?page=logout">
                                <i class="fa fa-lock"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php
if (Input::exists() && Input::get("edit_my_account") == "edit_my_account") {
    $user_id = $_SESSION['hospital_user_id'];
    $user = $_SESSION['hospital_username'];
    $username = Input::get("username");
    $old_password = sha1(Input::get('old_password'));
    $new_password = sha1(Input::get('new_password'));
    $queryUpdateUser = DB::getInstance()->checkRows("select * from user where  Username='$user' AND Password='$old_password'");
    if ($queryUpdateUser) {
        $queryUpdateCheck = DB::getInstance()->checkRows("select * from user where User_Id!='$user_id' AND Username='$username'");
        if ($queryUpdateCheck) {
            $message = "The username entered is already used by another person";
        } else {
            $queryUpdate = DB::getInstance()->query("update  user set Password='$new_password',Username='$username' where  Username='$user'");
            if ($queryUpdate) {
                $message = "Your account user credentials have been changed successfully";
                $_SESSION['hospital_username'] = $username;
            } else {
                $message = "Could not update your user credentials, please try again later";
            }
        }
    } else {
        $message = "Incorrect old password";
    }
    redirect($message, "");
}
?>
<div class="modal fade" data-backdrop="static" id="account_settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog animated fadeInDown">
        <div class="modal-content animated">
            <form action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Account Details for <b style="color: blue"><?php echo $_SESSION['hospital_staff_names'] ?></b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="hidden" value="<?php echo $_SESSION['hospital_user_id']; ?>" name="user_id" class="form-control">
                                <input type="text" value="<?php echo $_SESSION['hospital_username']; ?>" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Old Password</label> 
                                <input type="password" name="old_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>New Password:</label>
                                <input type="password" name="new_password" id="new_password" pattern="[a-zA-Z0-9]{8,}" title="Password must be a minimum of 8 letters" onkeyup="emptyConfirm();" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Re-Enter password:</label>
                                <input type="password" id="confirm_password" required onkeyup="compare_password(this.value);" class="form-control" pattern="[a-zA-Z0-9]{8,}" title="Password must be a minimum of 8 letters">
                            </div>
                            <strong id="check_password" style="color: red">Passwords enetered must match</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit_my_account" id="edit_my_account_button" disabled value="edit_my_account" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function compare_password(confirm) {
        if (confirm !== "") {
            var old_password = document.getElementById("new_password").value;
            if (confirm === old_password) {
                document.getElementById("edit_my_account_button").disabled = false;
                document.getElementById("check_password").style.display = "none";
            } else {
                document.getElementById("edit_my_account_button").disabled = true;
                document.getElementById("check_password").style.display = "block";
            }

        } else {
            document.getElementById("edit_my_account_button").disabled = true;
            document.getElementById("check_password").style.display = "block";
        }
    }
    function emptyConfirm() {
        document.getElementById("confirm_password").value = "";
        document.getElementById("edit_my_account_button").disabled = true;
    }
</script>