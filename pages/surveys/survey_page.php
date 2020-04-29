<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Responsive Admin Template" />
        <meta name="author" content="SeffyHospital" />
        <title><?php echo $title; ?> Survey</title>

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
            include_once 'includes/survey_header_menu.php';
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
                    <div class="row" style="text-align: justify">
                        <div class="page-title center">welcome to bwindi community hospital staff satsifaction survey</div>
                        <div class="col-md-12 center">
                            <div class="card card-topline-green">
                                <div class="card-head">
                                    <header>Survey</header>
                                </div>
                                <div class="card-body " id="bar-parent">
                                    <?php
                                    if (Input::exists() && Input::get("submit_survey") == "submit_survey") {
                                        DB::getInstance()->query("UPDATE survey_codes SET Status=0 WHERE Code='$staff_code'");

                                        echo '<div class="alert alert-success">survey submitted successfully</div>';
                                    }
                                    if (!DB::getInstance()->checkRows("SELECT * FROM survey_codes WHERE Code='$staff_code' AND Status=1")) {
                                        if (!isset($_POST['submit_survey'])) {
                                            echo '<div class="alert alert-danger">You have already participated in this survey</div>';
                                        }
                                    } else {

                                        $queryquestion = 'SELECT * FROM survey_questions WHERE Status=1 ORDER BY Question_Id  ' . $limit;
                                        if (DB::getInstance()->checkRows($queryquestion)) {
                                            ?>
                                            <form role="form" action="index.php?page=<?php echo "survey_page" . '&code=' . $staff_code; ?>" method="POST" enctype="multipart/form-data">
                                                <table id="example1"  style="text-align: left" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 70%;">Questions</th>
                                                            <th>Strongly agree</th>
                                                            <th >Disagree</th>
                                                            <th >Agree</th>
                                                            <th>Strongly agree</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $data_got = DB::getInstance()->querySample($queryquestion);
                                                        $no = 1;
                                                        foreach ($data_got as $questionx) {
                                                            ?>
                                                            <tr >
                                                                <td><?php echo $no . ". " . $questionx->Question; ?></td>
                                                                <td id='<?php echo $questionx->Question_Id; ?>_1'>
                                                                    <div class="custom-control custom-radio">
                                                                        1 <input type="radio" class="custom-control-input" id="defaultUnchecked" onchange='Check("<?php echo $questionx->Question_Id; ?>", "<?php echo $questionx->Question_Id; ?>_1", this.value, "<?php echo $staff_id; ?>")' value="Strongly Disagree" name="<?php echo $questionx->Question_Id ?>">

                                                                        </td>
                                                                        <td id="<?php echo $questionx->Question_Id; ?>_2"> 
                                                                            <div class="custom-control custom-radio">
                                                                                2 <input type="radio" class="custom-control-input" id="defaultUnchecked" onchange='Check("<?php echo $questionx->Question_Id; ?>", "<?php echo $questionx->Question_Id; ?>_2", this.value, "<?php echo $staff_id; ?>")' value="Disagree" name="<?php echo $questionx->Question_Id ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td id="<?php echo $questionx->Question_Id; ?>_3"> 
                                                                            <div class="custom-control custom-radio">
                                                                                3 <input type="radio" class="custom-control-input" id="defaultUnchecked" onchange='Check("<?php echo $questionx->Question_Id; ?>", "<?php echo $questionx->Question_Id; ?>_3", this.value, "<?php echo $staff_id; ?>")' value="Agree" name="<?php echo $questionx->Question_Id ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td id="<?php echo $questionx->Question_Id; ?>_4"> 
                                                                            <div class="custom-control custom-radio">
                                                                                4 <input type="radio" class="custom-control-input" id="defaultUnchecked" onchange='Check("<?php echo $questionx->Question_Id; ?>", "<?php echo $questionx->Question_Id; ?>_4", this.value, "<?php echo $staff_id; ?>")' value="Strongly agree" name="<?php echo $questionx->Question_Id ?>">
                                                                            </div>
                                                                        </td>
                                                            </tr>
                                                            <?php
                                                            $no++;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td style="width: 70%;"><?php echo $no; ?>. I would recommend this health facility to other workers as a good place to work.</td>
                                                            <td colspan="4" style="width: 30%;">
                                                                <div class="col-lg-3">Definitely No
                                                                    <div id="recommend_1" class="custom-control custom-radio">
                                                                        1 <input type="radio" class="custom-control-input" onchange='recommend(this.value, "<?php echo $staff_id; ?>",1)' value="Definitely No" id="defaultUnchecked" name="recomendation">
                                                                    </div></div>
                                                                <div class="col-lg-3">Probably No
                                                                    <div id="recommend_2" class="custom-control custom-radio">
                                                                        2 <input type="radio"  onchange='recommend(this.value, "<?php echo $staff_id; ?>",2)' class="custom-control-input" value="Probably No" id="defaultUnchecked" name="recomendation">
                                                                    </div></div>
                                                                <div class="col-lg-3">Probably Yes
                                                                    <div id="recommend_3" class="custom-control custom-radio">
                                                                        3 <input type="radio"  onchange='recommend(this.value, "<?php echo $staff_id; ?>",3)' class="custom-control-input" value="Probably Yes" id="defaultUnchecked" name="recomendation">
                                                                    </div></div>
                                                                <div class="col-lg-3">Definitely Yes
                                                                    <div id="recommend_4" class="custom-control custom-radio">
                                                                        4 <input type="radio"   onchange='recommend(this.value, "<?php echo $staff_id; ?>",4)' class="custom-control-input" value="Definitely Yes" id="defaultUnchecked" name="recomendation">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 70%;"><?php echo $no + 1; ?>. How would you rate this health facility as a place to work on a scale 1(the worst) to 10(the best).</td>
                                                            <td colspan="4" style="width: 30%;"> 
                                                                <div id="rate_1" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        1 <input type="radio" class="custom-control-input" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' value="1" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_2" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        2 <input type="radio" class="custom-control-input" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' value="2" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_3" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        3 <input type="radio" class="custom-control-input" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' value="3" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_4" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        4 <input type="radio" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="4" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_5" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        5 <input type="radio" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="5" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_6" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        6 <input type="radio" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="6" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_7" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        7 <input type="radio"  onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="7" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_8" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                         8<input type="radio" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="8" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_9" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        9 <input type="radio" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="9" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                                <div id="rate_10" class="col-lg-1">
                                                                    <div class="custom-control custom-radio">
                                                                        10 <input type="radio" onchange='Checked(this.value, "<?php echo $staff_id; ?>")' class="custom-control-input" value="10" id="defaultUnchecked" name="rate">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button type="submit" name="submit_survey" class="btn btn-success pull-right" value="submit_survey">Finish</button>
                                            </form>

                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No Question registered</div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function Check(question_id, column_id, value, staff_id) {
                var i;
                if (value != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=ajax_data',
                        data: {question_id: question_id, value: value, type: "submit_answer", staff_id: staff_id},
                        success: function (html) {
                            var sprinttext = column_id.split("_");

                            for (i = 1; i <= 4; i++) {
                                if (i != sprinttext[1]) {
                                    $('#' + question_id + "_" + i).attr({
                                        "class": "btn-warning"        // values (or variables) here
                                    });
                                }
                            }
                            $('#' + column_id).attr({
                                "class": "btn-success"        // values (or variables) here
                            });

                        }
                    });
                } else {
                }
            }
            
             function Checked(value, staff_id) {
                var i;
                if (value != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=ajax_data',
                        data: {value: value, type: "submit_rate", staff_id: staff_id},
                        success: function (html) {
                            for (i = 1; i <= 10; i++) {
                                if (i != value) {
                                    $('#rate_' + i).attr({
                                        "style": "background:orange"        // values (or variables) here
                                    });
                                }
                            }
                            $('#rate_'+ value).attr({
                                "style": "background:green"        // values (or variables) here
                            });

                        }
                    });
                } else {
                }
            }
            
              function recommend(value, staff_id,digit) {
                var i;
                if (value != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=ajax_data',
                        data: {value: value, type: "submit_recommendation", staff_id: staff_id},
                        success: function (html) {
                            
                            for (i = 1; i <= 4; i++) {
                                if (i != digit) {
                                    $('#recommend_' + i).attr({
                                        "style": "background:orange"        // values (or variables) here
                                    });
                                }
                            }
                            $('#recommend_'+ digit).attr({
                                "style": "background:green"        // values (or variables) here
                            });

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