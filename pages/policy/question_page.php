<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Responsive Admin Template" />
        <meta name="author" content="SeffyHospital" />
        <title><?php echo $title; ?> policy</title>

        <!-- icons -->
        <link href="js/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!--bootstrap -->
        <link href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

        <!-- theme style -->
        <link href="css/theme_style.css" rel="stylesheet" id="rt_style_components" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/theme-color.css" rel="stylesheet" type="text/css" />

        <!-- favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.png" /> 
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-full-width page-md header-blue">
        <div class="page-wrapper">
            <!-- start header -->
            <?php
            include_once 'includes/policy_header_menu.php';
            ?>
            <!-- end header -->
            <!-- start page container -->

            <!-- end sidebar menu --> 
            <!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="page-title center">welcome to bwindi community hospital child protection policy page</div>
                        <div class="col-md-10 ">
                            <div class="card card-topline-green">
                                <div class="card-head">
                                    <header>Child protection Policy</header>
                                     <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "policy_document_page" . '&code=' . $staff_code; ?>"><i class="fa fa-eye"></i>View Child Protection Policy document</a>
                                </div>
                                </div>
                                <div class="card-body " id="bar-parent">

                                    <?php
                                    if (Input::exists() && Input::get("submit_policy") == "submit_policy") {
                                        DB::getInstance()->query("UPDATE policy_codes SET Status=0 WHERE Code='$staff_code'");

                                        echo '<div class="alert alert-success">policy submitted successfully</div>';
                                          include_once 'pages/policy/staff_marks.php';
                                           include_once 'pages/policy/marking_guide.php';
                                    }
                                    if (!DB::getInstance()->checkRows("SELECT * FROM policy_codes WHERE Code='$staff_code' AND Status=1")) {
                                        if (!isset($_POST['submit_policy'])) {
                                            echo '<div class="alert alert-danger">You have already participated in this policy</div>';
                                               include_once 'pages/policy/staff_marks.php';
                                                include_once 'pages/policy/marking_guide.php';
                                        }
                                    } else {

                                        $queryquestion = 'SELECT * FROM policy_questions WHERE Status=1 ORDER BY Question_Id  ' . $limit;
                                        if (DB::getInstance()->checkRows($queryquestion)) {

                                            $data_got = DB::getInstance()->querySample($queryquestion);
                                            $no = 1;
                                            foreach ($data_got as $questionx) {
                                                ?>
                                                <div class="col-md-10">
                                                    <?php
                                                    echo"<strong> " . $questionx->Question . "</strong><br/>";

                                                    $data_answer = DB::getInstance()->querySample("select * from policy_answers where Question_Id='$questionx->Question_Id' and status=1 ");
                                                    $count_answer = 1;
                                                    foreach ($data_answer as $answerx) {
                                                        $alphabet = ($count_answer == 1) ? "a" : (($count_answer == 2) ? "b" : (($count_answer == 3) ? "c" : (($count_answer == 4) ? "d" : (($count_answer == 5) ? "e" : (($count_answer == 6) ? "f" : "g")))));
                                                        ?>
                                                        <div class='col-md-8' id="<?php echo $questionx->Question_Id . "_" . $count_answer . "_answer" ?>"><strong><?php echo $alphabet; ?>.</strong> <?php echo $answerx->Answer; ?>
                                                        </div>
                                                        <div class='col-md-1'> 
                                                            <div class='form-group'>
                                                                <?php if ($questionx->Choice > 1) { ?>
                                                                    <div class='checkbox checkbox-icon-black'>

                                                                        <input id='<?php echo $answerx->Answer_Id; ?>' type='checkbox' value='<?php echo $answerx->Answer_Id; ?>' onchange="check(this.value, '<?php echo $questionx->Question_Id; ?>', '<?php echo $staff_id; ?>', '<?php echo $questionx->Choice; ?>', '<?php echo $count_answer ?>')">

                                                                    </div><?php } else {
                                                                    ?>

                                                                    <div class="radio">
                                                                        <input type="radio" name="<?php echo $questionx->Question_Id; ?>" id="<?php echo $answerx->Answer_Id; ?>" value='<?php echo $answerx->Answer_Id; ?>' onchange="radio(this.value, '<?php echo $questionx->Question_Id; ?>', '<?php echo $staff_id; ?>', '<?php echo $questionx->Choice; ?>', '<?php echo $count_answer ?>')">

                                                                    </div>
                                                                <?php } ?>
                                                            </div>


                                                        </div><br/><?php
                                                        $count_answer++;
                                                    }
                                                    ?> 
                                                    <br/>
                                                </div>
                                                <?php
                                                $no++;
                                            }
                                        } else {
                                            echo '<div class="alert alert-danger">No Question registered</div>';
                                        }
                                   
                                    ?>
                                   
                                </div>
                                 <form role="form" action="index.php?page=<?php echo "question_page" . '&code=' . $staff_code; ?>" method="POST" enctype="multipart/form-data">
                                   
                                     <div class="col-md-10">
                                         <button type="submit" name="submit_policy" class="btn btn-success pull-right" value="submit_policy">Finish</button>
                                     </div> 
                                 </form>
                                    <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function check(answer_id, question_id, staff_id, choice, count) {


                if (answer_id != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=ajax_data',
                        data: {question_id: question_id, answer: answer_id, type: "submit_policy_answer", staff_id: staff_id, choice: choice},
                        success: function (html) {
                            if (document.getElementById(answer_id).checked == false) {
                                $('#' + question_id + '_' + count + '_answer').attr({
                                    "style": "color:black"        // values (or variables) here
                                });
                            }
                            if (document.getElementById(answer_id).checked == true && document.getElementById(answer_id).value != '') {
                                $('#' + question_id + '_' + count + '_answer').attr({
                                    "style": "color:blue"        // values (or variables) here
                                });
                            }

                        }
                    });
                } else {
                }
            }


            function radio(answer_id, question_id, staff_id, choice, count) {

                if (answer_id != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=ajax_data',
                        data: {question_id: question_id, answer: answer_id, type: "submit_policy_answer", staff_id: staff_id, choice: choice},
                        success: function (html) {
                            for (i = 1; i <= 10; i++) {
                                if (i != count) {

                                    $('#' + question_id + '_' + i + '_answer').attr({
                                        "style": "color:black"        // values (or variables) here
                                    });

                                } else {
                                    $('#' + question_id + '_' + count + '_answer').attr({
                                        "style": "color:blue"        // values (or variables) here
                                    });
                                }
                            }

                        }
                    });
                } else {
                }
            }

        </script>
        <!-- end page content -->
        <!-- end page container -->
        <!-- start footer -->
        <?php include_once 'includes/footer.php'; ?>
        <!-- end footer -->
        <!-- start js include path -->
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery.blockui.min.js" type="text/javascript"></script>
        <!-- bootstrap -->
        <script src="js/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="js/jquery.slimscroll.js"></script>
        <script src="js/app.js" type="text/javascript"></script>
        <script src="js/layout.js" type="text/javascript"></script>
        <script src="js/theme-color.js" type="text/javascript"></script>


        <!-- end js include path -->
    </body>
</html>