<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

    <head>
        <?php include_once 'includes/header_css.php'; ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-blue">
        <div class="page-wrapper">
            <!-- start header -->
            <?php include_once 'includes/header_menu.php'; ?>
            <!-- end header -->
            <!-- start page container -->
            <div class="page-container">
                <?php include_once 'includes/side_menu.php';?>
                <!-- start sidebar menu -->

                <!-- end sidebar menu -->
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">Email settings</div>
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-5">
                                <?php
                                  if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                  $type="Policy";  
                                }else{
                                    $type="Survey";
                                }
                                
                                if (Input::exists() && Input::get("submit_password") == "submit_password") {
                                    $email = Input::get('email');
                                    $password = Input::get('password');

                                    $queryDup = DB::getInstance()->checkRows("select * from system_email where Email='$email' and Type='$type' and Status=1");
                                    if (!$queryDup) {
                                        DB::getInstance()->insert("system_email", array(
                                            "Email" => $email,
                                            "Type" => $type,
                                            "Password" => $password));
                                        $log = $_SESSION['hospital_staff_names'] . "  registered a new staff :" . $staff_name;
                                        DB::getInstance()->logs($log);
                                        echo '<div class="alert alert-success"> email submitted successfully</div>';
                                    } else {
                                        echo '<div class="alert alert-warning"> email already exisits</div>';
                                    }

                                    Redirect::go_to("index.php?page=" . "system_email" . "&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=system_email"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register Email</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                            <div id="email"><button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_element();">Add more</button>
                                                <div class="form-group" id="add_element">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control"/>
                                                </div>

                                                <div class="form-group" id="add_element">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit"  name="submit_password" value="submit_password" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <!-- /.col (left) -->
                            <div  class="col-md-7" <?php echo $hidden2; ?>>
                                <?php
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $Email_Id = $_GET['Email_Id'];
                                    $query = DB::getInstance()->query("UPDATE system_email SET Status=0 WHERE Email_Id='$Email_Id' and Type='$type'");
                                    if ($query) {

                                        $email = DB::getInstance()->displayTableColumnValue("select email from system_email where Email_Id='$Email_Id' and Type='$type' ", "email");
                                        $log = $_SESSION['hospital_staff_names'] . "  deleted " . $email . "s information";
                                        DB::getInstance()->logs($log);
                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=system_email&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("edit_email") == "edit_email") {
                                    $Email_Id = Input::get('Email_Id');
                                    $email = Input::get('email');
                                    $password=Input::get('password');
                                    $email_z = DB::getInstance()->displayTableColumnValue("select Email from system_email where Email_Id='$Email_Id' and Type='$type' ", "Email");

                                    $editemail = DB::getInstance()->update("system_email", $Email_Id, array(
                                        "Email" => $email,
                                        "Password" => $password), "Email_Id");


                                    if ($editemail) {
                                        $log = $_SESSION['hospital_staff_names'] . "  edited " . $email_z . " to " . $email;
                                        DB::getInstance()->logs($log);
                                        echo $message = "<center><h4 style='color:blue'>data has been edited successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=system_email&mode=" . $mode);
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header>emails List</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $queryemail = "SELECT * FROM system_email WHERE Type='$type' and  Status=1 ORDER BY Email_Id desc";
                                        if (DB::getInstance()->checkRows($queryemail)) {
                                            ?>
                                            <table  class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th >Email</th>
                                                        <th class="hidden">Password</th>
                                                        <th style="width: 20%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($queryemail);

                                                    foreach ($data_got as $emailx) {
                                                        ?>
                                                        <tr> 
                                                            <td><?php echo $emailx->Email; ?></td>
                                                            <td class="hidden"><?php echo $emailx->Password; ?></td>
                                                            <td style="width: 20%;">
                                                                <div class="btn-group xs">
                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a  data-toggle="modal" data-target="#modal-<?php echo $emailx->Email_Id; ?>">Edit</a></li>
                                                                        <li><a href="index.php?page=<?php echo "system_email" . '&action=delete&Email_Id=' . $emailx->Email_Id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $emailx->Email; ?>?');">Delete</a></li>
                                                                        <li class="divider"></li>

                                                                    </ul>
                                                                </div>

                                                            </td>

                                                    <div class="modal fade" id="modal-<?php echo $emailx->Email_Id; ?>">
                                                        <div class="modal-dialog">
                                                            <form role="form" action="index.php?page=<?php echo "system_email" . '&mode=' . $mode; ?>" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>

                                                                    </div> <div class="modal-body">
                                                                        <input type="hidden" name="Email_Id" value="<?php echo $emailx->Email_Id ?>">
                                                                        <div class="form-group" >
                                                                            <label>Email</label>
                                                                            <input type="email" value="<?php echo $emailx->Email; ?>" name="email" class="form-control"/>
                                                                        </div>

                                                                        <div class="form-group" >
                                                                            <label>Password</label>
                                                                            <input type="password" value="<?php echo $emailx->Password; ?>" name="password" class="form-control"/>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit_email" value="edit_email" class="btn btn-primary">Save changes</button>
                                                                    </div>


                                                                </div>
                                                            </form>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                }
                                                ?>
                                                </tbody>


                                            </table>
                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No email registered</div>';
                                        }
                                        ?>

                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <!-- /.col (right) -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </div>
                <!-- end page content -->
            </div>
            <!-- end page container -->
            <!-- start footer -->
            <?php include_once 'includes/footer.php'; ?>
            <!-- end footer -->
        </div>
        <!-- start js include path -->

        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>