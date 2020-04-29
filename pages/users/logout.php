<?php

session_start();
unset($_SESSION['hospital_role']);
unset($_SESSION['hospital_username']);
unset($_SESSION['hospital_immergencepassword']);
unset($_SESSION['hospital_user_id']);
unset($_SESSION['hospital_staff_id']);
unset($_SESSION['hospital_staff_names']);
unset($_SESSION['hospital_profile_picture']);
unset($_SESSION['hospital_user_modules']);
unset($_SESSION["PREVIOUS_URL"]);
unset($_SESSION['survey_code']);
unset($_SESSION['survey_id']);
$user = new User();
$user->logout();
Redirect::to('index.php?page=login');
?>