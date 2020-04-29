<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once 'includes/header_css.php'; ?>
    </head>
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-blue">
        <div class="page-wrapper">
            <!-- start header -->
            <?php include_once 'includes/header_menu.php'; ?>
            <!-- end header -->
            <!-- start page container -->
            <div class="page-container">
                <!-- start sidebar menu -->
                <?php include_once 'includes/side_menu.php'; ?>
                <!-- end sidebar menu --> 
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">Other charts</div>
                                </div>
                            </div>
                        </div>
                        <!-- start widget -->
                        <div class="row">
                            <div class="col-lg-8">
                                <form role="form" action="" method="post">
                                    <div class="form-group col-lg-10">
                                        <label>Select a Question:</label>
                                        <select class="form-control select2"  style="width: 100%;" name="question">

                                            <option value="">select...</option>
                                            <?php
                                            $count=1;
                                            $qstnList = DB::getInstance()->querySample("SELECT * FROM survey_questions WHERE Status=1");
                                            foreach ($qstnList AS $questn) {
                                                echo '<option value="' . $questn->Question_Id . '"> Q' . $count.'. '.$questn->Question . '</option>';
                                           $count++;
                                           }
                                            ?>
                                        </select>
                                    </div>

                                    <div class='form-group'> <br/>
                                        <button type="submit" name="search" value="search" class="btn btn-primary pull-right">Search</button>
                                    </div>
                                </form>
                            </div>
                            <a class="btn btn-success pull-right"><i class="fa fa-print">print</i></a></div>
                        <div class="row">
                            <?php
                            $dynamiquestion = "";
                            if (isset($_POST['search']) && $_POST['search'] == 'search') {

                                $question = Input::get("question");
                                $dynamiquestion = DB::getInstance()->DisplayTableColumnValue("select Question from survey_questions where Question_Id='$question'", "Question");


                                $uniquedynamicQuestionsArray = array();
                                $dynamicquestionList = array("Strongly Disagree", "Agree", "Disagree", "Strongly agree");
                                for ($i = 0; $i < sizeof($dynamicquestionList); $i++) {
                                    $answerdynamic = $dynamicquestionList[$i];
                                    $surveyQuerydynamic = "SELECT count(distinct(Staff_Id)) AS staffDynamic_total FROM survey_answers WHERE Answer='$answerdynamic' and Question_Id='$question' ";
                                    $totalsurveysdynamic = DB::getInstance()->DisplayTableColumnValue($surveyQuerydynamic, "staffDynamic_total");
                                    $uniquedynamicQuestionsArray[] = [
                                        "category_name" => $answerdynamic,
                                        "category_data" => $totalsurveysdynamic
                                    ];
                                }
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="card card-topline-green">
                                    <div class="card-head">
                                        <header id="heading"><?php echo $dynamiquestion; ?></header>
                                    </div>
                                    <div class="card-body " id="chartjs_polar_parent">
                                        <div class="row">
                                            <canvas id="chartjs_dynamecQuestion_pie" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $uniquequestion18Array = array();
                            $question8List = array("Definitely No", "Probably No", "Probably Yes", "Definitely Yes");
                            for ($i = 0; $i < sizeof($question8List); $i++) {
                                $answer8 = $question8List[$i];
                                $surveyQuery8 = "SELECT count(distinct(Staff_Id)) AS staff8_total FROM staff_recommendation WHERE Recommendation='$answer8' ";
                                $totalsurveys8 = DB::getInstance()->DisplayTableColumnValue($surveyQuery8, "staff8_total");
                                $uniquequestion18Array[] = [
                                    "category_name" => $answer8,
                                    "category_data" => $totalsurveys8
                                ];
                            }


                            $uniquequestion119Array = array();
                            $question19List = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10");
                            for ($i = 0; $i < sizeof($question19List); $i++) {
                                $answer19 = $question19List[$i];
                                $surveyQuery19 = "SELECT count(distinct(Staff_Id)) AS staff19_total FROM hospital_ratings WHERE Rate='$answer19' ";
                                $totalsurveys19 = DB::getInstance()->DisplayTableColumnValue($surveyQuery19, "staff19_total");
                                $uniquequestion119Array[] = [
                                    "category_name" => $answer19,
                                    "category_data" => $totalsurveys19
                                ];
                            }
                            ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-topline-red">
                                    <div class="card-head">
                                        <header>Q18. I would recommend this health facility to other workers as a good place to work.</header>
                                    </div>
                                    <div class="card-body " id="chartjs_polar_parent">
                                        <div class="row">
                                            <canvas id="chartjs_q18_pie" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header>Q19. How would you rate this health facility as a place to work on a scale 1(the worst) to 10(the best).</header>
                                    </div>
                                    <div class="card-body " id="chartjs_polar_parent">
                                        <div class="row">
                                            <canvas id="chartjs_q19_pie" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        <script>
            var uniquequestion18Array_pie = <?php echo json_encode($uniquequestion18Array); ?>;
            var uniquequestion119Array_pie = <?php echo json_encode($uniquequestion119Array); ?>;
            var uniquedynamicQuestionsArray_pie=<?php echo json_encode($uniquedynamicQuestionsArray); ?>;

        </script>
        <?php include_once 'includes/footer_js.php'; ?>

        <script src="js/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="js/counterup/jquery.counterup.min.js" type="text/javascript"></script>

        <script src="js/chart-js/Chart.bundle.js" type="text/javascript"></script>
        <script src="js/chart-js/utils.js" type="text/javascript"></script>
        <script src="js/chart-js/chartjs-data.js" type="text/javascript"></script>
    </body>

</html>