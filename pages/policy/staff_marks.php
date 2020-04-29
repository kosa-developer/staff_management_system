<?php
$total_questions = DB::getInstance()->countElements("select Question_Id from policy_questions");
$answered_questions = DB::getInstance()->countElements("select distinct(Question_Id) from staff_answer where Staff_Id='$staff_id'");
$queryscores = "SELECT distinct(staff_answer.Question_Id) FROM staff_answer,policy_answers  WHERE staff_answer.Staff_Id='$staff_id' and staff_answer.Answer_Id=policy_answers.Answer_Id and staff_answer.Question_Id=policy_answers.Question_Id and policy_answers.Correct=1";
$total_scores= DB::getInstance()->displayTableColumnValue("select Staff_Performance from  staff_performance where Staff_Id='$staff_id'", 'Staff_Performance'); 
 $overall_marks= DB::getInstance()->calculateSum("select Total_Marks from total_correct_answer ", 'Total_Marks');
 $percentage_score=round(($total_scores/$overall_marks)*100);
$remarks=($percentage_score<30)?"Tried":(($percentage_score<50)?"Fair Performance":(($percentage_score<60)?"Average Performance":(($percentage_score<70)?"Good Performance":(($percentage_score<80)?"Very Good Performance":"Excellent Performance"))));

?>    
<div class="col-md-4 col-xs-12">
    <div class="card card-topline-green">
        <div class="card-head">
            <header> <a style="color:blue">Performance For</a>: <?php echo $names; ?> </header>
        </div>
        <div class="white-box">
            <div class=" cardbox patient-profile">
                
                <img src="..\staff_image/<?php echo $profile_picture=($profile_picture!='')?$profile_picture:'person.JPG'; ?>" class="img-responsive" alt="">
            </div>
            <div class="cardbox">
                <div class="header">
                    <h2 class="font-bold">Performance</h2>
                </div>
                <div class="body">
                    <div class="user-btm-box">
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 b-r"><strong>Total Marks</strong>
                                <p>Questions</p>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12"><strong>100%</strong>
                                <p><?php echo $total_questions; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 b-r"><strong>Marks Scored</strong>
                                <p>Answered</p>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12"><strong><?php echo $percentage_score; ?>%</strong>
                                <p><?php echo $answered_questions; ?></p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                         <div class="row text-center m-t-10">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 b-r"><strong>Remarks</strong>
                             
                            </div>
                             <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12"><strong style="color: blue"><?php echo $remarks;?></strong>
                                
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div></div>