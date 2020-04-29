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
                <?php
                include_once 'includes/side_menu.php';
                $hidden = "";
                $hidden1 = "";
                if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff" || $_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                    $hidden = "hidden";
                    $hidden1 = "";
                } else {
                    $hidden = "";
                    $hidden1 = "hidden";
                }
                ?>
                <!-- end sidebar menu --> 
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">Dashboard</div>
                                </div>
                            </div>
                        </div>
                        <!-- start widget -->
                        <div class="row">
                            <a class="btn btn-success pull-right"  onclick="window.print();"><i class="fa fa-print">print</i></a>
                        </div>
                        <div id="printable"> 
                            <div class="row">
                                <div class="col-md-12 hidden">
                                    <div class="card card-topline-red">
                                        <div class="card-head">
                                            <header></header>
                                        </div>
                                        <div class="card-body " id="chartjs_polar_parent">
                                            <div class="row">
                                                <canvas id="chartjs_line" height="100"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row <?php echo $hidden1; ?>">
                                <div class="col-md-8 col-xs-12">
                                    <div class="card card-topline-green">
                                        <div class="card-head">
                                            <header>Performance</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">
                                            <?php
                                            $performance_query = "SELECT * FROM staff_performance ";
                                            $performance_list = DB::getInstance()->querySample($performance_query);

                                            if (DB::getInstance()->checkRows($performance_query)) {
                                                ?>
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th >Staff</th>
                                                            <th >Performance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $overall_marks = DB::getInstance()->calculateSum("select Total_Marks from total_correct_answer ", 'Total_Marks');

                                                        $no = 1;
                                                        foreach ($performance_list as $staff_performance) {
                                                            ?>
                                                            <tr> 
                                                                <td><?php echo $staff_performance->Staff_Name; ?></td>
                                                                <td><?php echo $performance = round((($staff_performance->Staff_Performance / $overall_marks) * 100)); ?>%</td>

                                                            </tr>
                                                            <?php
                                                            $no++;
                                                        }
                                                        ?>
                                                    </tbody>

                                                </table>
                                                <?php
                                            } else {
                                                echo '<div class="alert alert-danger">No Question Answered</div>';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div></div>
                                <div class="row <?php echo $hidden; ?>">

                                    <?php
                                    $generalquestionArray = array();
                                    $questionQueryz = "SELECT * FROM survey_questions where Status=1 order by Question_Id";
                                    $question_listz = DB::getInstance()->querySample($questionQueryz);
                                    $categoriesListz = array("Strongly Disagree", "Agree", "Disagree", "Strongly agree");
                                    $questionz = 1;
                                    $questionsz = "";
                                    foreach ($question_listz as $questionListz) {
                                        $questionsz = "Q" . $questionz;

                                        for ($i = 0; $i < sizeof($categoriesListz); $i++) {
                                            $answerz = $categoriesListz[$i];
                                            $questionsz . "=";
                                            $answerz . "=";
                                            $surveyQueryz = "SELECT count(distinct(Staff_Id)) AS staff_totalz FROM survey_answers WHERE Answer='$answerz' AND Question_Id=$questionListz->Question_Id";
                                            $totalsurveysz = DB::getInstance()->DisplayTableColumnValue($surveyQueryz, "staff_totalz");

                                            $surveycategoryUniquez[] = [
                                                "Categoryx" => $answerz,
                                                "Surveyx" => $totalsurveysz
                                            ];
                                        }
                                        $generalquestionArray[] = [
                                            "category_namex" => $questionsz,
                                            "category_datax" => $surveycategoryUniquez
                                        ];
                                        $questionz++;
                                    }

                                    $uniqueCategoriesArray = array();
                                    $categoriesList = array("Strongly Disagree", "Agree", "Disagree", "Strongly agree");
                                    for ($i = 0; $i < sizeof($categoriesList); $i++) {
                                        $answer = $categoriesList[$i];
                                        $surveycategoryUnique = array();
                                        $questionQuery = "SELECT * FROM survey_questions where Status=1 order by Question_Id";
                                        $question_list = DB::getInstance()->querySample($questionQuery);
                                        $question = 0;
                                        $questions = "";
                                        foreach ($question_list as $questionList) {
                                            $question++;
                                            $questions = "Q" . $question;
                                            $surveyQuery = "SELECT count(distinct(Staff_Id)) AS staff_total FROM survey_answers WHERE Answer='$answer' AND Question_Id=$questionList->Question_Id ";
                                            $totalsurveys = DB::getInstance()->DisplayTableColumnValue($surveyQuery, "staff_total");
                                            $surveycategoryUnique[] = [
                                                "Category" => $questions,
                                                "Survey" => $totalsurveys
                                            ];
                                        }
                                        $uniqueCategoriesArray[] = [
                                            "category_id" => $answer,
                                            "category_name" => $answer,
                                            "category_data" => $surveycategoryUnique
                                        ];
                                        ?>
                                        <div class="col-md-6">
                                            <div class="card card-topline-green">
                                                <div class="card-head">
                                                    <header> <?php echo $answer ?></header>
                                                </div>
                                                <div class="card-body " id="chartjs_polar_parent">
                                                    <div class="row">
                                                        <canvas id="chartjs_predictionfactors<?php echo $answer ?>" height="100"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }

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

                                <div class="row <?php echo $hidden; ?>">
                                    <div class="col-md-6">
                                        <div class="card card-topline-red">
                                            <div class="card-head">
                                                <header>Q18. I would recommend this health facility to other workers as a good place to work.</header>
                                            </div>
                                            <div class="card-body " id="chartjs_polar_parent">
                                                <div class="row">
                                                    <canvas id="chartjs_q18" height="100"></canvas>
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
                                                    <canvas id="chartjs_q19" height="100"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div></div>
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
                var uniquequestion18Array = <?php echo json_encode($uniquequestion18Array); ?>;
                var uniqueCategoriesData = <?php echo json_encode($uniqueCategoriesArray); ?>;
                var uniquequestion119Array = <?php echo json_encode($uniquequestion119Array); ?>;
                var generalquestionArray = <?php echo json_encode($generalquestionArray); ?>;


            </script>
            <?php include_once 'includes/footer_js.php'; ?>
            <script type="text/javascript">

            </script>

            <script src="js/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
            <script src="js/counterup/jquery.counterup.min.js" type="text/javascript"></script>

            <script src="js/chart-js/Chart.bundle.js" type="text/javascript"></script>
            <script src="js/chart-js/utils.js" type="text/javascript"></script>
            <script src="js/chart-js/chartjs-data.js" type="text/javascript"></script>
    </body>

</html>