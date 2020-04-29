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
                                    <div class="page-title">Child protection policy</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "policy_document" . '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> Child Protection Policy</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12" <?php echo $hidden; ?>>
                                <?php
                                if (Input::exists() && Input::get("submit_policy") == "submit_policy") {
//                                    $policy_notes = Input::get('policy_notes');
                                   $policy_notes = addslashes(Input::get('policy_notes'));
                                        $queryDup = DB::getInstance()->checkRows("select * from child_protection_policy");
                                        if (!$queryDup) {
                                          $insert_query=  DB::getInstance()->insert("child_protection_policy", array(
                                                "Policy" => $policy_notes));
                                            
                                            $log = $_SESSION['hospital_staff_names'] . "  registered a new policy :" . $staff_name;
                                            DB::getInstance()->logs($log);
                                        } else {
                                             $insert_query = DB::getInstance()->query("UPDATE child_protection_policy SET Policy='$policy_notes'");
                                   
                                        }
                                       
                                 
                                     if ($insert_query) {
                                            echo '<div class="alert alert-success"> data submitted successfully</div>';
                                        }else{
                                            echo '<div class="alert alert-warning">data already exisits</div>';
                                        }
                                    Redirect::go_to("index.php?page=policy_document&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo "policy_document" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register Policy</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                           <div class="col-md-12 col-sm-12">
                                               <textarea name="policy_notes" id="summernote" cols="30" rows="10">
					       
					        </textarea>
					    </div>
                                            <div class="box-footer">
                                                <button type="submit"  name="submit_policy" value="submit_policy" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <div class="row" <?php echo $hidden2;?>>
                            <div class="col-md-10" >
                                     <div class="card card-topline-green">
                                        <div class="card-head">
                                            <header>Registered policy</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                           <div class="col-md-12 col-sm-12">
                                               <?php echo DB::getInstance()->displayTableColumnValue("select Policy from child_protection_policy order by Policy_Id desc limit 1", "Policy"); ?>

					    </div>
                                            
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                  
                            </div>
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
                var row_ids = Math.round(Math.random( ) * 300000000);
                document.getElementById('add_element').insertAdjacentHTML('beforeend',
                        '<div id="' + row_ids + '">\n\
     <textarea name="question[]" rows="2" class="form-control" required></textarea> \n\
 <button type="button" value="' + row_ids + '" class="btn btn-danger btn-xs pull-right" onclick="delete_item(this.value);">\n\
<i class ="fa fa-times"></i></button> </div>');

            }
            function delete_item(element_id) {
                $('#' + element_id).html('');
            }

        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>