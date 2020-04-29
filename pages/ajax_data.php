<link href="js/select2/css/select2.css" rel="stylesheet" type="text/css" />
<link href="js/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<?php
if (isset($_POST["district"]) && !empty($_POST["district"])) {
   
    $district_id = $_POST["district"];
    $query = "select * from subcounty WHERE District_Id='$district_id'";
    ?>
    <div class="form-group">
        <label>Subcounty:</label>
        <select name="subcounty_id" class="select2"  onchange="returnParish(this.value, 'selectedData');" required>
            <option value="">select</option>
            <?php
            if (DB::getInstance()->checkRows($query)) {
                $subcounty_query = DB::getInstance()->query($query);
                foreach ($subcounty_query->results() as $subcounty) {
                    echo '<option value="' . $subcounty->SubcountyId . '">' . $subcounty->SubcountyName . '</option>';
                }
            }
            ?>
            <option value="Other">Other</option>
        </select>
    </div>

    <?php
}

if (isset($_POST["class_name_model"]) && !empty($_POST["class_name_model"])) {
    $subcounty_id = $_POST["class_name_model"];
    
    $query = "select * from parishes WHERE SubcountyId='$subcounty_id'";
    ?>
    <div class="form-group">
        <label>Parish:</label>
        <select name="parish_id" class="select2"  onchange="getvillage(this.value);" required>
            <option value="">select</option>
            <?php
            if (DB::getInstance()->checkRows($query)) {
                $parish_query = DB::getInstance()->query($query);
                foreach ($parish_query->results() as $parish) {
                    echo '<option value="' . $parish->ParishId . '">' . $parish->ParishName . '</option>';
                }
            }
            ?>  
            <option value="Other">Other</option>
        </select>
    </div>
    <?php
}
if (isset($_POST["parish_name"]) && !empty($_POST["parish_name"])) {
    $parish_id = $_POST["parish_name"];
    $query = "select * from village WHERE ParishId='$parish_id'";
    ?>
    <div class="form-group">
        <label>Village:</label>
        <select name="village_id" class="select2" required >
            <option value="">select</option>
            <?php
            if (DB::getInstance()->checkRows($query)) {
                $village_query = DB::getInstance()->query($query);
                foreach ($village_query->results() as $village) {
                    echo '<option value="' . $village->VillageId . '">' . $village->VillageName . '</option>';
                }
            }
            ?>
            <option value="Other">Other</option>
        </select>
    </div>
    <?php
}
if (isset($_POST["type"]) && $_POST["type"] == "submit_answer") {
    $question_id = Input::get('question_id');
    $answer = Input::get("value");
    $staff_id = Input::get("staff_id");
    if (DB::getInstance()->checkRows("select * from survey_answers where Question_Id='$question_id' and Staff_Id='$staff_id'")) {
        $update = DB::getInstance()->query("UPDATE survey_answers SET Answer='$answer' WHERE Question_Id='$question_id' and Staff_Id='$staff_id'");
        if ($update) {
            echo "success";
        }
    } else {
        $insert = DB::getInstance()->insert("survey_answers", array(
            "Question_Id" => $question_id,
            "Staff_Id" => $staff_id,
            "Answer" => $answer
        ));
        if ($insert) {
            echo "success";
        }
    }
}


if (isset($_POST["type"]) && $_POST["type"] == "submit_policy_answer") {
    $question_id = Input::get('question_id');
    $answer = Input::get("answer");
    $staff_id = Input::get("staff_id");
    $choice = Input::get("choice");
    if (DB::getInstance()->checkRows("select * from staff_answer where Question_Id='$question_id' and Staff_Id='$staff_id'") && $choice == 1) {
        $update = DB::getInstance()->query("UPDATE staff_answer SET Answer_Id='$answer' WHERE Question_Id='$question_id' and Staff_Id='$staff_id'");
        if ($update) {
            echo "success";
        }
    } else {
        if (DB::getInstance()->checkRows("select * from staff_answer where Question_Id='$question_id' and Staff_Id='$staff_id' and Answer_Id='$answer'") && $choice > 1) {
            DB::getInstance()->query("DELETE FROM staff_answer WHERE Question_Id='$question_id' and Staff_Id='$staff_id' and Answer_Id='$answer'");
        } else {
            $insert = DB::getInstance()->insert("staff_answer", array(
                "Question_Id" => $question_id,
                "Staff_Id" => $staff_id,
                "Answer_Id" => $answer
            ));
            if ($insert) {
                echo "success";
            }
        }
    }
}

if (isset($_POST["type"]) && $_POST["type"] == "submit_rate") {
    $answer = Input::get("value");
    $staff_id = Input::get("staff_id");
    if (DB::getInstance()->checkRows("select * from hospital_ratings where  Staff_Id='$staff_id'")) {
        $update = DB::getInstance()->query("UPDATE hospital_ratings SET Rate='$answer' WHERE Staff_Id='$staff_id'");
        if ($update) {
            echo "success";
        }
    } else {
        $insert = DB::getInstance()->insert("hospital_ratings", array(
            "Staff_Id" => $staff_id,
            "Rate" => $answer
        ));
        if ($insert) {
            echo "success";
        }
    }
}
if (isset($_POST["type"]) && $_POST["type"] == "submit_recommendation") {
    $answer = Input::get("value");
    $staff_id = Input::get("staff_id");
    if (DB::getInstance()->checkRows("select * from staff_recommendation where  Staff_Id='$staff_id'")) {
        $update = DB::getInstance()->query("UPDATE staff_recommendation SET Recommendation='$answer' WHERE Staff_Id='$staff_id'");
        if ($update) {
            echo "success";
        }
    } else {
        $insert = DB::getInstance()->insert("staff_recommendation", array(
            "Staff_Id" => $staff_id,
            "Recommendation" => $answer
        ));
        if ($insert) {
            echo "success";
        }
    }
}
?>


<script src="js/select2/js/select2.js" type="text/javascript"></script>
<script src="js/select2/js/select2-init.js" type="text/javascript"></script>