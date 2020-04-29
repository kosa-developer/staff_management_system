<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

    <head>
        <?php include_once 'includes/header_css.php'; ?>
    </head>
    <style type="text/css">
        hr {
            width: 80%;
        }
    </style>
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

                if (isset($_GET['mode'])) {
                    echo $mode = $_GET['mode'];

                    if ($mode == 'register') {
                        $hidden = "";
                        $hidden1 = "hidden";
                        $class_width = "col-md-7";
                        $limit = "limit 10";
                    } else {
                        $hidden = "hidden";
                        $hidden1 = "";
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
                                    <div class="page-title">Child Protection Card</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "child_protection_card" . '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> Children</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12" <?php echo $hidden; ?>>
                                <?php
                                if (Input::exists() && Input::get("add_policy_card") == "add_policy_card") {

                                    $child_name = Input::get('child_name');
                                    $year_of_birth = Input::get('year_of_birth');
                                    $gender = Input::get('gender');

                                    $next_of_kin = Input::get('next_of_kin');
                                    $religion = Input::get('religion');
                                    $tribe = Input::get('tribe');
                                    $education = Input::get('education');
                                    $disability = Input::get('disability');
                                    $case_history = addslashes(Input::get('case_history'));
                                    $other_history = Input::get('other_history');

                                    $district_id = Input::get('district');
                                    $subcounty_id = Input::get('subcounty_id');
                                    $parish_id = Input::get('parish_id');
                                    $village_id = Input::get('village_id');

                                    $district = (DB::getInstance()->displayTableColumnValue("select District_Name from districts where Id='$district_id'", "District_Name") != "") ? DB::getInstance()->displayTableColumnValue("select District_Name from districts where Id='$district_id'", "District_Name") : "Other District";
                                    $subcounty = (DB::getInstance()->displayTableColumnValue("select SubcountyName from subcounty where SubcountyId='$subcounty_id'", "SubcountyName") != "") ? DB::getInstance()->displayTableColumnValue("select SubcountyName from subcounty where SubcountyId='$subcounty_id'", "SubcountyName") : "Other Subcounty";
                                    $parish = (DB::getInstance()->displayTableColumnValue("select ParishName from parishes where ParishId='$parish_id'", "ParishName") != "") ? DB::getInstance()->displayTableColumnValue("select ParishName from parishes where ParishId='$parish_id'", "ParishName") : "Other Parish";

                                    $village = (DB::getInstance()->displayTableColumnValue("select VillageName from village where VillageId='$village_id'", "VillageName") != "") ? DB::getInstance()->displayTableColumnValue("select VillageName from village where VillageId='$village_id'", "VillageName") : "Other Village";

                                    $queryDup = DB::getInstance()->checkRows("select * from child_protection_card where Child_Name='$child_name' and Year_Of_Birth='$year_of_birth' and Next_Of_Kin='$next_of_kin' and Gender='$gender' and Status='1'");
                                    if (!$queryDup) {
                                        DB::getInstance()->insert("child_protection_card", array(
                                            "Child_Name" => $child_name,
                                            "Year_Of_Birth" => $year_of_birth,
                                            "Next_Of_Kin" => $next_of_kin,
                                            "Gender" => $gender,
                                            "Education" => $education,
                                            "Village" => $village,
                                            "Parish" => $parish,
                                            "Sub_County" => $subcounty,
                                            "District" => $district,
                                            "Disability" => $disability,
                                            "Case_History" => $case_history,
                                            "Tribe" => $tribe,
                                            "Religion" => $religion,
                                            "Other_History" => $other_history
                                        ));
                                        $message = "" . $child_name . " has been successfull regestered";
                                        echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                        $log = $_SESSION['hospital_child_names'] . "  registered a new a child :" . $child_name;
                                        DB::getInstance()->logs($log);
                                    } else {
                                        echo "<h4 style='color:red;'><center>Staff already exists</center></h4>";
                                    }
                                    Redirect::go_to("index.php?page=child_protection_card&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo "child_protection_card" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register a child here</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">
                                            <div class="col-md-4">

                                                <div class="col-md-12">
                                                    <label>Child Name</label>
                                                    <input type="text" class="form-control" name="child_name" placeholder="Enter child name" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Year of birth</label>
                                                    <select class="select2" name="year_of_birth"  required>
                                                        <option value="">select...</option>
                                                        <?php
                                                        for ($i = date('Y') - 17; $i <= date('Y'); $i++) {
                                                            ?>
                                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Next of kin</label>
                                                    <input type="text" class="form-control" name="next_of_kin" placeholder="Enter next of kin" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Gender</label>
                                                    <select class="select2" name="gender"  required>
                                                        <option value="">select...</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12">
                                                    <label>Religion</label>
                                                    <select class="select2" name="religion"  required>
                                                        <option value="">select...</option>
                                                        <option value="Roman Catholic">Roman Catholic</option>
                                                        <option value="Anglican">Anglican</option>
                                                        <option value="Muslim">Muslim</option>
                                                        <option value="Pentecostal">Pentecostal</option>
                                                        <option value="Seventh day Adventist">Seventh day Adventist</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Tribe</label>

                                                    <select class="select2" name="tribe"  required>
                                                        <option value="">select...</option>
                                                        <option value="Bakiga">Bakiga</option>
                                                        <option value="Batwa">Batwa</option>
                                                        <option value="Bafumbira">Bafumbira</option>
                                                        <option value="Baganda">Baganda</option>
                                                        <option value="Bagisu">Bagisu</option>
                                                        <option value="Bugwe, part of Samia-Bugwe">Bugwe, part of Samia-Bugwe</option>
                                                        <option value="Bagwere">Bagwere</option>
                                                        <option value="Bahororo">Bahororo</option>
                                                        <option value="Bakonzo">Bakonzo</option>
                                                        <option value="Batooro">Batooro</option>
                                                        <option value="Banyankore">Banyankore</option>
                                                        <option value="Banyala">Banyala</option>
                                                        <option value="Banyarwanda">Banyarwanda</option>
                                                        <option value="Banyoro">BanyoroBanyoro</option>
                                                        <option value="Baruuli">Baruuli</option>
                                                        <option value="Basoga">Basoga</option>
                                                        <option value="Basongora">Basongora</option>
                                                        <option value="Batuku">Batuku</option>
                                                        <option value="Baziba">Baziba</option>
                                                        <option value="Chope">Chope</option>
                                                        <option value="Dodoth">Dodoth</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Education</label>
                                                    <select class="select2" name="education"  required>
                                                        <option value="">select...</option>
                                                        <option value="Nursery">Nursery</option>
                                                        <option value="P1">P1</option>
                                                        <option value="P2">P2</option>
                                                        <option value="P3">P3</option>
                                                        <option value="P4">P4</option>
                                                        <option value="P5">P5</option>
                                                        <option value="P6">P6</option>
                                                        <option value="P7">P7</option>
                                                        <option value="P1">S1</option>
                                                        <option value="P2">S2</option>
                                                        <option value="P3">S3</option>
                                                        <option value="P4">S4</option>
                                                        <option value="P5">S5</option>
                                                        <option value="P6">S6</option>
                                                        <option value="Tertially School">Tertially School</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12">
                                                    <label>Disability</label>
                                                    <select class="select2" name="disability"  required>
                                                        <option value="">select...</option>
                                                        <option value="None">None</option>
                                                        <option value="Loss and limited use of limbs ">Loss and limited use of limbs </option>
                                                        <option value="Spine injuries ">Spine injuries </option>
                                                        <option value="Hearing difficulties">Hearing difficulties</option>
                                                        <option value="Seeing difficulties ">Seeing difficulties </option>
                                                        <option value="Mental retardation">Mental retardation</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12">
                                                    <label>District</label>
                                                    <select class="select2" name="district" onchange="returnSubcounty(this.value, 'subcounty_data');" required>
                                                        <?php
                                                        echo DB::getInstance()->dropDowns('districts', 'Id', 'District_Name');
                                                        ?>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div id="subcounty_data" class="col-md-12">
                                                </div>
                                                <div id="selectedData" class="col-md-12">
                                                </div>
                                                <div id="villageData" class="col-md-12">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <label>Case History</label>
                                                    <textarea id="summernote" name="case_history" class="form-controw" rows="5">
                                                    </textarea>

                                                </div>
                                                <div class="col-md-12">
                                                    <label>Other Relative History</label>
                                                    <select class="select2" name="other_history"  required>
                                                        <option value="">select...</option>
                                                        <option value="None">None</option>
                                                        <option value="Pregnancy">Pregnancy</option>
                                                        <option value="Family Planning">Family Planning</option>
                                                        <option value="Orphan">Orphan</option>
                                                        <option value="Habits">Habits</option>
                                                        <option value="Others">Others</option>
                                                    </select>

                                                </div>

                                            </div>
                                            <div class="box-footer col-md-12">
                                                <button type="submit"  name="add_policy_card" value="add_policy_card" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <!-- /.col (left) -->
                            <div class="<?php echo $class_width; ?>" <?php echo $hidden1 ?>>
                                <?php
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $staff_id = $_GET['staff_id'];
                                    $query = DB::getInstance()->query("UPDATE staff SET Status=0 WHERE Staff_Id='$staff_id'");
                                    if ($query) {

                                        $child_name = DB::getInstance()->displayTableColumnValue("select child_name from staff where Staff_Id='$staff_id' ", "child_name");
                                        $log = $_SESSION['hospital_child_names'] . "  deleted " . $child_name . "s information";
                                        DB::getInstance()->logs($log);
                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=child_protection_card&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("edit_staff") == "edit_staff") {
                                    $staff_id = Input::get('staff_id');
                                    $staff_code = Input::get('staff_code');
                                    $child_name = Input::get('child_name');
                                    $staff_title = Input::get("staff_title");
                                    $enrollement_date = Input::get("enrollement_date");
                                    $stuff_photo = ($_FILES['stuff_photo']['name']);
                                    $blood_group = (Input::get("blood_group") != '') ? Input::get("blood_group") : NULL;

                                    $Signature = ($_FILES['Signature']['name']);

                                    $child_namez = DB::getInstance()->displayTableColumnValue("select child_name from staff where Staff_Id='$staff_id' ", "child_name");

                                    if ($stuff_photo != "") {
                                        $target_dir = "..\staff_image/";
                                        $target_file = $target_dir . basename($_FILES["stuff_photo"]["name"]);
                                        move_uploaded_file($_FILES["stuff_photo"]["tmp_name"], $target_file);
                                        if ($Signature != "") {
                                            $starget_dir = "..\staff_signature/";
                                            $starget_file = $starget_dir . basename($_FILES["Signature"]["name"]);
                                            move_uploaded_file($_FILES["Signature"]["tmp_name"], $starget_file);

                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "child_name" => $child_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Image" => $stuff_photo,
                                                "Signature" => $Signature,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        } else {
                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "child_name" => $child_name,
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
                                                "child_name" => $child_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Signature" => $Signature,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        } else {
                                            $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                                "child_name" => $child_name,
                                                "Enrollement_Date" => $enrollement_date,
                                                "Code" => $staff_code,
                                                "Blood_Group" => $blood_group,
                                                "Title" => $staff_title
                                                    ), "Staff_Id");
                                        }
                                    }




                                    if ($editStaff) {
                                        $log = $_SESSION['hospital_child_names'] . "  edited " . $child_namez . " information";
                                        DB::getInstance()->logs($log);
                                        echo $message = "<center><h4 style='color:blue'>data has been edited successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    $test_mode = (isset($_GET["mode"])) ? "&mode=view" : "";
                                    Redirect::go_to("index.php?page=child_protection_card&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("send_survey") == "send_survey") {
                                    $staff_id = Input::get('staff_id');
                                    $email = Input::get('email');
                                    $code = Input::get('code');
                                    $count = 0;
                                    $child_name = "";
                                    $system_email = DB::getInstance()->displayTableColumnValue("select Email from system_email where Status=1 and Type='$type'", 'Email');
                                    $system_email_password = DB::getInstance()->displayTableColumnValue("select Password from system_email where Status=1", 'Password');

                                    for ($i = 0; $i < sizeof($staff_id); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from survey_codes where Email='$email[$i]' and Status='1'");
                                        if (!$queryDup) {
                                            $child_name .= DB::getInstance()->displayTableColumnValue("select child_name from staff where Staff_Id='$staff_id[$i]' ", "child_name");
                                            sendEmail($email[$i], $child_name, $code[$i], $system_email, $system_email_password);
                                            DB::getInstance()->insert("survey_codes", array(
                                                "Code" => $code[$i],
                                                "Email" => $email[$i],
                                                "Staff_Id" => $staff_id[$i]
                                            ));
//
                                            $count++;
                                            $log = $_SESSION['hospital_child_names'] . "  sent survey to :" . $child_name;
                                            DB::getInstance()->logs($log);
                                        }
                                    }
                                    if ($count > 0) {
                                        $message = "Survey has been sent to " . $child_name;
                                        echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                    } else {
                                        echo "<h4 style='color:red;'><center>No survey was sent</center></h4>";
                                    }
                                    Redirect::go_to("index.php?page=child_protection_card&mode=" . $mode);
                                }

                                if (Input::exists() && Input::get("send_policy") == "send_policy") {
                                    $staff_id = Input::get('staff_id');
                                    $email = Input::get('email');
                                    $code = Input::get('code');
                                    $count = 0;
                                    $child_name = "";
                                    $system_email = DB::getInstance()->displayTableColumnValue("select Email from system_email where Status=1 and Type='$type'", 'Email');
                                    $system_email_password = DB::getInstance()->displayTableColumnValue("select Password from system_email where Status=1", 'Password');

                                    for ($i = 0; $i < sizeof($staff_id); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from survey_codes where Email='$email[$i]' and Status='1'");
                                        if (!$queryDup) {
                                            $child_name .= DB::getInstance()->displayTableColumnValue("select child_name from staff where Staff_Id='$staff_id[$i]' ", "child_name");
                                            send_policy_Email($email[$i], $child_name, $code[$i], $system_email, $system_email_password);
                                            DB::getInstance()->insert("policy_codes", array(
                                                "Code" => $code[$i],
                                                "Email" => $email[$i],
                                                "Staff_Id" => $staff_id[$i]
                                            ));
//
                                            $count++;
                                            $log = $_SESSION['hospital_child_names'] . "  sent policy to :" . $child_name;
                                            DB::getInstance()->logs($log);
                                        }
                                    }
                                    if ($count > 0) {
                                        $message = "Policy has been sent to " . $child_name;
                                        echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                    } else {
                                        echo "<h4 style='color:red;'><center>No Policy was sent</center></h4>";
                                    }
                                    Redirect::go_to("index.php?page=child_protection_card&mode=" . $mode);
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>staff List</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $querypolicy = 'SELECT * FROM child_protection_card WHERE Status=1 ORDER BY Id desc ' . $limit;
                                        if (DB::getInstance()->checkRows($querypolicy)) {
                                            ?>
                                        
                                           <a class="btn btn-success btn-xs pull-right" target="_blank" href="index.php?page=<?php echo "child_card". "&type=export_child_protection_card&child_protectioncardQuery=" . $querypolicy; ?>"><i class="fa fa-download"></i> Export </a>
                                                                       
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th >Child Name</th>
                                                        <th >Sex</th>
                                                        <th >Village</th>
                                                        <th >Next of kin</th>
                                                        <th >Child protection card</th>
                                                        <th >action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($querypolicy);
                                                    $no = 1;
                                                    foreach ($data_got as $policy) {
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td ><?php echo $policy->Child_Name; ?></td>
                                                            <td ><?php echo $policy->Gender; ?></td>
                                                            <td ><?php echo $policy->Village; ?></td>
                                                            <td ><?php echo $policy->Next_Of_Kin; ?></td>
                                                            <td ><a class="btn btn-primary xs"data-toggle="modal" data-target="#child_card-<?php echo $policy->Id; ?>">View Child Crotection Card</a></td>
                                                            <td >
                                                                <div class="btn-group xs hidden">
                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a  data-toggle="modal" data-target="#modal-<?php echo $policy->Staff_Id; ?>">Edit</a></li>
                                                                        <?php
                                                                        if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Human Resource" || $_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                                                            
                                                                        } else {
                                                                            ?>
                                                                            <li><a href="index.php?page=<?php echo "child_protection_card" . '&action=delete&staff_id=' . $policy->Staff_Id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $policy->child_name; ?>?');">Delete</a></li>
                                                                        <?php } ?> <li class="divider"></li>

                                                                    </ul>
                                                                </div>

                                                            </td>

                                                    <div class="modal fade" id="child_card-<?php echo $policy->Id; ?>">
                                                        <div class="modal-dialog" style="width:50%" >
                                                            <div class="modal-content" >
                                                                <div class="modal-header">
                                                                    <form target="_blank"action="index.php?page=<?php echo "child_card". "&type=download_child_card" ?>" method="POST">
                                                                        <div>   <input type="hidden" name="child_id" value="<?php echo $policy->Id ?>">

                                                                            <button type="submit"class="btn btn-success fa fa-print pull-right" onclick="printContent('printable_area');">Print</button>
                                                                        </div>
                                                                    </form>     <div  id="printable_area">
                                                                        <div  style="text-align:center;">
                                                                            <h2 class="modal-title">BWINDI COMMUNITY HOSPITAL</h2>
                                                                            <h4 class="modal-title">(We treat but God heals)</h4>
                                                                            <h2 class="modal-title">CHILD PROTECTION CARD</h2>

                                                                        </div>  

                                                                        <div class="modal-body">
                                                                            <div class="col-md-10">
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">Name:</span></strong>

                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Child_Name; ?>  </span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">YEAR OF BIRTH:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Year_Of_Birth; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">NEXT OF KIN:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Next_Of_Kin; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">SEX:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Gender; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">RELIGION:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Religion; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">TRIBE:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Tribe; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">EDUCATION:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Education; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">VILLAGE:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Village; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">PARISH:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Parish; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">SUB-COUNTY:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Sub_County; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">DISTRICT:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->District; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <strong><span class="col-md-6">DISABILITY:</span></strong>
                                                                                    <span class="col-md-6"style="text-decoration: underline;"><?php echo $policy->Disability; ?></span> 
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="col-md-12">
                                                                                    <br/><br/>
                                                                                    <strong><span>CASE HISTORY:</span></strong>
                                                                                    <span style="text-decoration: underline;"><?php echo $policy->Case_History; ?></span> 
                                                                                </div>
                                                                                <div class="col-md-12 col-md-12">
                                                                                    <strong ><span>OTHER RELATIVE HISTORY:</span></strong>
                                                                                    <span  style="text-decoration: underline;"><?php echo $policy->Other_History; ?></span> 
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                                    </div>


                                                                </div>

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
                                            echo '<div class="alert alert-danger">No Child registered</div>';
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
        <script type="text/javascript">

//            function printContent(el) {
//                var restorepage = $('body').html();
//                var printcontent = $('#' + el).clone();
//                $('body').empty().html(printcontent);
//                window.print();
//                $('body').html(restorepage);
//            }

            function getvillage(parish) {
                if (parish && parish != "") {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=<?php echo "ajax_data" ?>',
                        data: 'parish_name=' + parish,
                        success: function (html) {
                            $('#villageData').html(html);
                        }
                    });
                } else {
                    $('#villageData').html('');
                }
            }

            function returnParish(subcounty_id, paris_data) {

                if (subcounty_id && subcounty_id != "") {
                    $('#villageData').html('');
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=<?php echo "ajax_data" ?>',
                        data: 'class_name_model=' + subcounty_id,
                        success: function (html) {

                            $('#' + paris_data).html(html);

                        }
                    });
                } else {
                    $('#' + paris_data).html('');
                }
            }

            function returnSubcounty(district_id, district_data) {

                var district_id = district_id;
                if (district_id && district_id != "") {
                    $('#villageData').html('');
                    $('#selectedData').html('');
                    $('#subcounty_data').html('');

                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=<?php echo "ajax_data" ?>',
                        data: 'district=' + district_id,
                        success: function (html) {
                            $('#' + district_data).html(html);

                        }
                    });
                } else {
                    $('#' + district_data).html('');
                }
            }
        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>