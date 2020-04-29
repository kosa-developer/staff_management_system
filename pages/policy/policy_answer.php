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
                if (isset($_GET['mode'])) {
                    echo $mode = $_GET['mode'];
                    $hidden = "";
                    $hidden2 = "";
                    if ($mode == 'register') {

                        $hidden = "";
                        $hidden2 = "hidden";
                        $class_width = "col-md-7";
                        $limit = "limit 10";
                    } else {
                        $hidden2 = "";
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
                                    <div class="page-title">Marking Guide</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "policy_answer". '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> Answer(s)</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12" <?php echo $hidden; ?>>
                                <?php
                                if (Input::exists() && Input::get("submit_answer") == "submit_answer") {
                                    $question = Input::get('question');
                                    $answer = Input::get('answer');
                                    $validity = Input::get('validity');
                                    $duplicate = 0;
                                    $submited = 0;
                                    for ($i = 0; $i < sizeof($answer); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from policy_answers where Answer='$answer[$i]' AND Question_Id='$question'");
                                        if (!$queryDup) {
                                            DB::getInstance()->insert("policy_answers", array(
                                                "Question_Id" => $question,
                                                "Answer" => $answer[$i],
                                                "Correct" => $validity[$i]));
                                            $submited++;
                                            $log = $_SESSION['hospital_staff_names'] . "  registered a new child protection answer :";
                                            DB::getInstance()->logs($log);
                                        } else {
                                            $duplicate++;
                                        }
                                    }
                                    if ($submited > 0) {
                                        $qtnz= DB::getInstance()->displayTableColumnValue("select Question from policy_questions where Question_Id='$question'", "Question");
                                        echo '<div class="alert alert-success">' . $submited . ' Answers to '.$qtnz.' submitted successfully</div>';
                                    }
                                    if ($duplicate > 0) {
                                        echo '<div class="alert alert-warning">' . $duplicate . ' answers already exisits</div>';
                                    }
                                    Redirect::go_to("index.php?page=policy_answer&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo"policy_answer" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register Answer</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                            <div class="form-group">
                                                <label>Question:</label>
                                                <select name="question" class="select2" style="width: 100%" required>
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    $qstn_list = DB::getInstance()->querySample("select * from policy_questions ORDER BY Question_Id");
                                                    foreach ($qstn_list as $qtn):
                                                        echo '<option value="' . $qtn->Question_Id . '">' . $qtn->Question . '.  (' . $qtn->Marks . 'mark(s)</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>

                                            <div id="question"><button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_element();">Add more</button>
                                                <div id="add_element" > 
                                                    <div class="form-group col-md-10" >
                                                        <label>Answer(s)</label>
                                                        <textarea name="answer[]" rows="2" class="form-control" required></textarea>

                                                    </div>
                                                    <div class="form-group col-md-2" id="add_element">
                                                            <select name="validity[]" class="select2" style="width: 100%" required>
                                                                 <option value="0">Wrong</option> 
                                                                 <option value="1">Correct</option> 
                                                            </select>
                                                        
                                                    </div>
                                                    <br/> 
                                                </div>
                                                <button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_element();">Add more</button>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit"  name="submit_answer" value="submit_answer" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <!-- /.col (left) -->
                            <div  class="col-md-12" <?php echo $hidden2; ?>>
                                <?php
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $quetion_id = $_GET['question_id'];
                                    $query = DB::getInstance()->query("UPDATE policy_answers SET Status=0 WHERE Question_Id='$quetion_id'");
                                    if ($query) {
                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=policy_answer&mode=" . $mode);
                                }
                               
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>questions List</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $queryquestion = 'SELECT * FROM policy_questions WHERE Status=1 ORDER BY Question_Id' . $limit;
                                        if (DB::getInstance()->checkRows($queryquestion)) {
                                            ?>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th >Question</th>
                                                        <th >Marks @qtn</th>
                                                        <th >Answers</th>
                                                        <th style="width: 20%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($queryquestion);
                                                    $no = 1;
                                                    foreach ($data_got as $questionx) {
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td><?php echo $questionx->Question; ?></td>
                                                            <td><?php echo $questionx->Marks;  ?></td>
                                                             <td><?php 
                                                             $data_answer = DB::getInstance()->querySample("select * from policy_answers where Question_Id='$questionx->Question_Id' and status=1 ");
                                                             $count_answer=1;
                                                             foreach ($data_answer as $answerx) {
                                                                  $alphabet = ($count_answer == 1) ? "a" : (($count_answer == 2) ? "b" : (($count_answer == 3) ? "c" : (($count_answer == 4) ? "d" : (($count_answer == 5) ? "e" : (($count_answer == 6) ? "f" : "g")))));
                                   
                                                                 $colorz=($answerx->Correct==1)?'blue':'red'; 
                                                              echo "<strong>".$alphabet . ".</strong> ".$answerx->Answer."<a style='".$colorz."'>(".$correct=($answerx->Correct==1)?"correct":"wrong"; echo ").</a> <br/><br/>";
                                                              $count_answer++;
                                                              }
                                                             ?></td>
                                                            <td style="width: 20%;"><?php echo $questionx->Choice;  ?>
                                                                <div class="btn-group xs">
                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a href="index.php?page=<?php echo "policy_answer" . '&action=delete&question_id=' . $questionx->Question_Id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $questionx->Question; ?>?');">Delete</a></li>
                                                                        <li class="divider"></li>

                                                                    </ul>
                                                                </div>

                                                            </td>

                                                    </tr>
                                                    <?php
                                                    $no++;
                                                }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th>Question</th>
                                                        <th>Marks @ Qtn</th>
                                                          <th>Answers</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No Question registered</div>';
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
        <script>
            function add_element() {
                var row_ids = Math.round(Math.random() * 300000000);
                document.getElementById('add_element').insertAdjacentHTML('beforeend',
                        '<div id="' + row_ids + '"><div class="form-group col-md-10">\n\
     <textarea name="answer[]" rows="2" class="form-control" required></textarea> \n\
 </div>\n\
    <div class="form-group col-md-2" id="add_element">\n\
     <select name="validity[]" class="select2" style="width: 100%" required>\n\
    <option value="0">Wrong</option> \n\
    <option value="1">Correct</option> \n\
</select><button type="button" value="' + row_ids + '" class="btn btn-danger btn-xs pull-right" onclick="delete_item(this.value);">\n\
<i class ="fa fa-times"></i></button></div></div>');

            }
            function delete_item(element_id) {
                $('#' + element_id).html('');
            }

        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>