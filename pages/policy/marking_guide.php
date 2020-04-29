   <div class="col-md-8 col-xs-12">
       <div class="card card-topline-yellow">
    <div class="card-head">
        <header>Marking guide</header>
    </div>
           <div class="card-body " id="bar-parent">
        <?php
        $queryquestion = 'SELECT * FROM policy_questions WHERE Status=1 ORDER BY Question_Id' . $limit;
        if (DB::getInstance()->checkRows($queryquestion)) {
            ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th >Question</th>
                        <th >Marks @qtn</th>
                        <th >Answers</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data_got = DB::getInstance()->querySample($queryquestion);
                    $no = 1;
                    foreach ($data_got as $questionx) {
                        ?>
                        <tr> 
                            <td><?php echo $questionx->Question; ?></td>
                            <td><?php echo $questionx->Marks; ?></td>
                            <td><?php
                                $data_answer = DB::getInstance()->querySample("select * from policy_answers where Question_Id='$questionx->Question_Id' and status=1 ");
                                $count_answer = 1;
                                foreach ($data_answer as $answerx) {
                                     $alphabet = ($count_answer == 1) ? "a" : (($count_answer == 2) ? "b" : (($count_answer == 3) ? "c" : (($count_answer == 4) ? "d" : (($count_answer == 5) ? "e" : (($count_answer == 6) ? "f" : "g")))));
                                                      
                                    $colorz = ($answerx->Correct == 1) ? 'blue' : 'red';
                                    echo "<strong>".$alphabet . ".</strong> " . $answerx->Answer . "<a style='" . $colorz . "'>(" . $correct = ($answerx->Correct == 1) ? "correct" : "wrong";
                                    echo ").</a> <br/><br/>";
                                    $count_answer++;
                                }
                                ?></td>


                        </tr>
                        <?php
                        $no++;
                    }
                    ?>
                </tbody>

            </table>
            <?php
        } else {
            echo '<div class="alert alert-danger">No Question registered</div>';
        }
        ?>
    </div>
       </div>
   </div>