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
                <!-- start sidebar menu -->
                <?php
                include_once 'includes/side_menu.php';

                $query_number = DB::getInstance()->displayTableColumnValue("select Code from staff order by Staff_Id desc Limit 1", "Code");
                $number = $query_number + 1;
                if (isset($_GET['mode'])) {
                    echo $mode = $_GET['mode'];

                    if ($mode == 'register') {
                        $hidden = "";
                        $class_width = "col-md-7";
                        $limit = "limit 10";
                    } else {
                        $hidden = "hidden";
                        $class_width = "col-md-12";
                        $limit = "";
                    }
                }
                ?>
                <!-- end sidebar menu -->
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">Staff</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "add_staff" . '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> Staff</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-5" <?php echo $hidden; ?>>
                                <?php
                                 if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                  $type="Policy";  
                                }else{
                                    $type="Survey";
                                }
                                
                                if (Input::exists() && Input::get("add_staff") == "add_staff") {
                                    $staff_id = strtoupper(Input::get('staff_id'));
                                    $staff_name = strtoupper(Input::get('staff_name'));
                                    $staff_title = Input::get("staff_title");
                                    $enrollement_date = Input::get("enrollement_date");
                                    $stuff_photo = ($_FILES['stuff_photo']['name']);
                                    $blood_group = Input::get("blood_group");
                                    $Signature = ($_FILES['Signature']['name']);

                                    if ($Signature != "") {
                                        $starget_dir = "staff_signature/";
                                        $starget_file = $starget_dir . basename($_FILES["Signature"]["name"]);
                                        move_uploaded_file($_FILES["Signature"]["tmp_name"], $starget_file);
                                    }
                                    if ($stuff_photo != "") {
                                        $target_dir = "staff_image/";
                                        $target_file = $target_dir . basename($_FILES["stuff_photo"]["name"]);
                                        move_uploaded_file($_FILES["stuff_photo"]["tmp_name"], $target_file);
                                    }
                                    $queryDup = DB::getInstance()->checkRows("select * from staff where Staff_Name='$staff_name' and Code='$staff_id'");
                                    if (!$queryDup) {
                                        DB::getInstance()->insert("staff", array(
                                            "Staff_Name" => $staff_name,
                                            "Enrollement_Date" => $enrollement_date,
                                            "Code" => $staff_id,
                                            "Image" => $stuff_photo,
                                            "Signature" => $Signature,
                                            "Blood_Group" => $blood_group,
                                            "Title" => $staff_title
                                        ));
                                        $message = "" . $fname . "    " . $lname . " has been successfull regestered";
                                        echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                        $log = $_SESSION['hospital_staff_names'] . "  registered a new staff :" . $staff_name;
                                        DB::getInstance()->logs($log);
                                    } else {
                                        echo "<h4 style='color:red;'><center>Staff already exists</center></h4>";
                                    }
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo "add_staff" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register staff</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                            <div id="file_div">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Staff Image</label>

                                                    <input type="file" id="i_file" name="stuff_photo" accept="image/*" onchange="readURL1(this);">

                                                    <img id="blah" src="staff_image/person.JPG" class="user-image" alt="User Image">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Staff Id</label>
                                                <input type="text" class="form-control" name="staff_id" value="<?php echo $number; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Staff Name</label>
                                                <input type="text" class="form-control" name="staff_name" placeholder="Enter staff names" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" name="staff_title" placeholder="Enter staff title" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Blood Group</label>
                                                <input type="text" class="form-control" name="blood_group" placeholder="Enter staff blood group" >
                                            </div>
                                            <div class="form-group">
                                                <label>Enrollement Date:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" name="enrollement_date" class="form-control pull-right" id="datepicker">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Staff signature</label>
                                                <input type="file" id="i_files" name="Signature" accept="image/*" onchange="readURL2(this);">

                                                <div id="file_divs">
                                                    <img id="blahs" src="Hmsignature/signiture.PNG"  style="width:70px"class="user-image" alt="User Image">
                                                </div>
                                            </div>

                                            <div class="box-footer">
                                                <button type="submit"  name="add_staff" value="add_staff" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <!-- /.col (left) -->
                            <div class="<?php echo $class_width; ?>">
                                <?php
                               
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $staff_id = $_GET['staff_id'];
                                    $query = DB::getInstance()->query("UPDATE staff SET Status=0 WHERE Staff_Id='$staff_id'");
                                    if ($query) {

                                        $staff_name = DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$staff_id' ", "Staff_Name");
                                        $log = $_SESSION['hospital_staff_names'] . "  deleted " . $staff_name . "s information";
                                        DB::getInstance()->logs($log);
                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("edit_staff") == "edit_staff") {
                                    $staff_id = Input::get('staff_id');
                                    $staff_code = strtoupper(Input::get('staff_code'));
                                    $staff_name = strtoupper(Input::get('staff_name'));
                                    $staff_title = Input::get("staff_title");
                                    $enrollement_date = Input::get("enrollement_date");
                                    $stuff_photo = ($_FILES['stuff_photo']['name']);
                                    $blood_group = (Input::get("blood_group") != '') ? Input::get("blood_group") : NULL;

                                    $Signature = ($_FILES['Signature']['name']);

                                    $staff_namez = DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$staff_id' ", "Staff_Name");

                                    if ($stuff_photo != "") {
                                        $target_dir = "..\staff_image/";
                                        $target_file = $target_dir . basename($_FILES["stuff_photo"]["name"]);
                                        move_uploaded_file($_FILES["stuff_photo"]["tmp_name"], $target_file);
                                        if ($Signature != "") {
                                            $starget_dir = "..\staff_signature/";
                                            $starget_file = $starget_dir . basename($_FILES["Signature"]["name"]);
                                            move_uploaded_file($_FILES["Signature"]["tmp_name"], $starget_file);

                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "Staff_Name" => $staff_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Image" => $stuff_photo,
                                                "Signature" => $Signature,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        } else {
                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "Staff_Name" => $staff_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Image" => $stuff_photo,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        }
                                    } else {

                                        if ($Signature != "") {
                                            $starget_dir = "..\staff_signature/";
                                            $starget_file = $starget_dir . basename($_FILES["Signature"]["name"]);
                                            move_uploaded_file($_FILES["Signature"]["tmp_name"], $starget_file);

                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "Staff_Name" => $staff_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Signature" => $Signature,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        } else {
                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "Staff_Name" => $staff_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        }
                                    }




                                    if ($editStaff) {
                                        $log = $_SESSION['hospital_staff_names'] . "  edited " . $staff_namez . " information";
                                        DB::getInstance()->logs($log);
                                        echo $message = "<center><h4 style='color:blue'>data has been edited successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    $test_mode = (isset($_GET["mode"])) ? "&mode=view" : "";
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("send_survey") == "send_survey") {
                                    $staff_id = Input::get('staff_id');
                                    $email = Input::get('email');
                                    $code = Input::get('code');
                                    $count = 0;
                                    $staff_name = "";
                                    $system_email = DB::getInstance()->displayTableColumnValue("select Email from system_email where Status=1 and Type='$type'", 'Email');
                                    $system_email_password = DB::getInstance()->displayTableColumnValue("select Password from system_email where Status=1", 'Password');

                                    for ($i = 0; $i < sizeof($staff_id); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from survey_codes where Email='$email[$i]' and Status='1'");
                                        if (!$queryDup) {
                                            $staff_name .= DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$staff_id[$i]' ", "Staff_Name");
                                            sendEmail($email[$i], $staff_name, $code[$i], $system_email, $system_email_password);
                                            DB::getInstance()->insert("survey_codes", array(
                                                "Code" => $code[$i],
                                                "Email" => $email[$i],
                                                "Staff_Id" => $staff_id[$i]
                                            ));
//
                                            $count++;
                                            $log = $_SESSION['hospital_staff_names'] . "  sent survey to :" . $staff_name;
                                            DB::getInstance()->logs($log);
                                        }
                                    }
                                    if ($count > 0) {
                                        $message = "Survey has been sent to " . $staff_name;
                                        echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                    } else {
                                        echo "<h4 style='color:red;'><center>No survey was sent</center></h4>";
                                    }
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                
                                     if (Input::exists() && Input::get("send_policy") == "send_policy") {
                                    $staff_id = Input::get('staff_id');
                                    $email = Input::get('email');
                                    $code = Input::get('code');
                                    $count = 0;
                                    $staff_name = "";
                                    $system_email = DB::getInstance()->displayTableColumnValue("select Email from system_email where Status=1 and Type='$type'", 'Email');
                                    $system_email_password = DB::getInstance()->displayTableColumnValue("select Password from system_email where Status=1", 'Password');

                                    for ($i = 0; $i < sizeof($staff_id); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from survey_codes where Email='$email[$i]' and Status='1'");
                                        if (!$queryDup) {
                                            $staff_name .= DB::getInstance()->displayTableColumnValue("select Staff_Name from staff where Staff_Id='$staff_id[$i]' ", "Staff_Name");
                                            send_policy_Email($email[$i], $staff_name, $code[$i], $system_email, $system_email_password);
                                            DB::getInstance()->insert("policy_codes", array(
                                                "Code" => $code[$i],
                                                "Email" => $email[$i],
                                                "Staff_Id" => $staff_id[$i]
                                            ));
//
                                            $count++;
                                            $log = $_SESSION['hospital_staff_names'] . "  sent policy to :" . $staff_name;
                                            DB::getInstance()->logs($log);
                                        }
                                    }
                                    if ($count > 0) {
                                        $message = "Policy has been sent to " . $staff_name;
                                        echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                    } else {
                                        echo "<h4 style='color:red;'><center>No Policy was sent</center></h4>";
                                    }
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>staff List</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $queryStaff = 'SELECT * FROM staff WHERE Status=1 ORDER BY Staff_Id desc ' . $limit;
                                        if (DB::getInstance()->checkRows($queryStaff)) {
                                            ?>
                                            <?php
                                            if ($mode == 'register') {
                                                
                                            } else {
                                                if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                                    
                                                } else {
                                                    ?>
                                                    <a data-toggle='modal' class="btn btn-success pull-right" href='#modal-form'><i class="fa fa-mail">Send survey</i></a>
                                                    <?php
                                                }
                                                if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Human Resource")) && !isset($_SESSION['immergencepassword'])) {
                                                    
                                                } else {
                                                    ?>
                                                    <a data-toggle='modal' class="btn btn-success pull-right" href='#modal-child_protection'><i class="fa fa-mail">Send Child Protection Questions</i></a>


                                                    <?php
                                                }
                                            }
                                            ?>

                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th style="width: 4%;">Staff Id</th>
                                                        <th style="width: 25%;">Staff Name</th>
                                                        <th style="width: 15%;">Title</th>
                                                        <th style="width: 15%;">Enrollement Date</th>
                                                        <th style="width: 15%;">Photo</th>
                                                        <th style="width: 25%;"> <?php
                                                            if ($mode == 'register') {
                                                                
                                                            } else {
                                                                if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                                                    
                                                                } else {
                                                                    ?> 
                                                                    <label class="btn btn-success btn-xs" for="selectall" id="selectControl" onclick="Check()">Click to Select All</label>
                                                                    <?php
                                                                }
                                                                if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Human Resource")) && !isset($_SESSION['immergencepassword'])) {
                                                                    
                                                                } else {
                                                                    ?>

                                                                    <!--<label class="btn btn-primary btn-xs" for="selectall" id="selectControl_policy" onclick="clicked_policy()">Select All</label>-->

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($queryStaff);
                                                    $no = 1;
                                                    foreach ($data_got as $staffs) {
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td style="width: 4%;"><?php echo $staffs->Code; ?></td>
                                                            <td style="width: 25%;"><?php echo $staffs->Staff_Name; ?></td>
                                                            <td style="width: 15%;"><?php echo $staffs->Title; ?></td>
                                                            <td style="width: 15%;"><?php echo $staffs->Enrollement_Date; ?></td>
                                                            <td style="width: 15%;"><img class="img-circle" height="40px" width="40px" src="..\staff_image/<?php echo $staffs->Image; ?>" alt="<?php echo $staffs->Code; ?>"></td>
                                                            <td style="width: 25%;"><div class="btn-group xs">
                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a  data-toggle="modal" data-target="#modal-<?php echo $staffs->Staff_Id; ?>">Edit</a></li>
                                                                        <?php
                                                                        if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Human Resource" || $_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                                                            
                                                                        } else {
                                                                            ?>
                                                                            <li><a href="index.php?page=<?php echo "add_staff" . '&action=delete&staff_id=' . $staffs->Staff_Id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $staffs->Staff_Name; ?>?');">Delete</a></li>
                                                                        <?php } ?> <li class="divider"></li>

                                                                    </ul>
                                                                </div>
                                                                <?php
                                                                if ($mode == 'register') {
                                                                    
                                                                } else {
                                                                    if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                                                        
                                                                    } else {
                                                                        ?> <input type="checkbox" id="<?php echo $staffs->Staff_Id ?>"onchange="clicked('<?php echo $staffs->Staff_Id; ?>', '<?php echo $staffs->Staff_Name; ?>');" value="<?php echo $staffs->Staff_Name; ?>" name="staff[]">
                                                                        <?php
                                                                    }
                                                                    if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Human Resource")) && !isset($_SESSION['immergencepassword'])) {
                                                                        
                                                                    } else {
                                                                        ?>
                                                                        <input type="checkbox" id="policy_<?php echo $staffs->Staff_Id ?>"onchange="clicked_policy('<?php echo $staffs->Staff_Id; ?>', '<?php echo $staffs->Staff_Name; ?>');" value="<?php echo $staffs->Staff_Name; ?>" name="staff_policy[]">

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>

                                                    <div class="modal fade" id="modal-<?php echo $staffs->Staff_Id; ?>">
                                                        <div class="modal-dialog">
                                                            <form role="form" action="index.php?page=<?php echo "add_staff". '&mode=' . $mode; ?>" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Edit <?php echo $staffs->Staff_Name; ?>'s Information</h4>
                                                                    </div> <div class="modal-body">
                                                                        <div id="file_div<?php echo $staffs->Staff_Id; ?>">
                                                                            <div class="form-group">
                                                                                <label for="exampleInputFile">Staff Image</label>
                                                                                <input type="file" id="i_file<?php echo $staffs->Staff_Id; ?>" name="stuff_photo" value="<?php echo $staffs->Image; ?>" accept="image/*" onchange="readURL(this, '<?php echo $staffs->Staff_Id; ?>');">

                                                                                <img style="width:100px;" id="blah<?php echo $staffs->Staff_Id; ?>" src="..\staff_image/<?php echo $staffs->Image; ?>" class="user-image" alt="User Image">

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Staff Id</label>
                                                                            <input type="text" class="form-control" name="staff_code" value="<?php echo $staffs->Code; ?>" required>
                                                                            <input type="hidden" class="form-control" name="staff_id" value="<?php echo $staffs->Staff_Id; ?>" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Staff Name</label>
                                                                            <input type="text" class="form-control" name="staff_name" value="<?php echo $staffs->Staff_Name; ?>" placeholder="Enter staff names" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Title</label>
                                                                            <input type="text" class="form-control" value="<?php echo $staffs->Title; ?>"name="staff_title" placeholder="Enter staff title" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Blood Group</label>
                                                                            <input type="text" class="form-control" name="blood_group" value="<?php echo $staffs->Blood_Group; ?>" placeholder="Enter staff blood group" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Enrollement Date:</label>

                                                                            <div class="input-group date">
                                                                                <div class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </div>
                                                                                <input type="text" value="<?php echo $staffs->Enrollement_Date; ?>"name="enrollement_date" class="form-control pull-right" id="datepicker">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="exampleInputFile">Staff signature</label>

                                                                            <div id="file_divs<?php echo $staffs->Staff_Id; ?>" >
                                                                                <input type="file" id="i_files<?php echo $staffs->Staff_Id; ?>" name="Signature"  style="width:10%;" value="<?php echo $staffs->Signature; ?>" accept="image/*" onchange="readURL2(this, '<?php echo $staffs->Staff_Id; ?>');">

                                                                                <img style="width:50px;" id="blahs<?php echo $staffs->Staff_Id; ?>" src="..\staff_signature/<?php echo $staffs->Signature; ?>" class="user-image" alt="User Image">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit_staff" value="edit_staff" class="btn btn-primary">Save changes</button>
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
                                            echo '<div class="alert alert-danger">No staff registered</div>';
                                        }
                                        ?>

                                        <div class="modal fade" id="modal-form">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Fill in this form and send a survey</h4>
                                                    </div> 
                                                    <form role="form" action="index.php?page=<?php echo "add_staff" . '&mode=registered&token=' . Token::generate(); ?>" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">


                                                                </div>

                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="col-lg-4 col-md-4 col-sm-4">Staff</div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-8">email</div>

                                                                </div>

                                                                <div class="col-lg-12 col-md-12 col-sm-12" id="id_data">

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="send_survey" value="send_survey" id="printing_button" class="btn btn-primary">Send survey</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

                                        <div class="modal fade" id="modal-child_protection">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Fill in this form and send a Policy</h4>
                                                    </div> 
                                                    <form role="form" action="index.php?page=<?php echo "add_staff" . '&mode=registered&token=' . Token::generate(); ?>" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">


                                                                </div>

                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="col-lg-4 col-md-4 col-sm-4">Staff</div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-8">email</div>

                                                                </div>

                                                                <div class="col-lg-12 col-md-12 col-sm-12" id="id_data_policy">

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="send_policy" value="send_policy" id="policy_button" class="btn btn-primary">Send Policy</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>


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