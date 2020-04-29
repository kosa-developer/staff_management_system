<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.blockui.min.js" type="text/javascript"></script>
<!-- bootstrap -->
<script src="js/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

<script src="js/jquery.slimscroll.js"></script>
<script src="js/app.js" type="text/javascript"></script>
<script src="js/layout.js" type="text/javascript"></script>
<script src="js/theme-color.js" type="text/javascript"></script>
<!--select2-->
<script src="js/select2/js/select2.js" type="text/javascript"></script>
<script src="js/select2/js/select2-init.js" type="text/javascript"></script>
<!-- data tables -->
<script src="js/datatables/datatables.min.js" type="text/javascript"></script>
<script src="js/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="js/table_data.js" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script> var logoutLink = '<?php echo "logout"; ?>';</script>
<script src="js/jquery-idle-timeout/jquery.idletimeout.js" type="text/javascript"></script>
<script src="js/jquery-idle-timeout/jquery.idletimer.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="js/jquery-idle-timeout/ui-idletimeout.js"></script>

    <!-- bootstrap -->
    <script src="js/summernote/summernote.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
<script>
    jQuery(document).ready(function () {
        //App.init();
        // initialize session timeout settings
        //UIIdleTimeout.init();
    });
</script>

<script>

    function readURL1(input) {
        var file = $('#i_file')[0].files[0];
        var fsize = file.size;
        var imgwidth = 0;
        var imgheight = 0;
        var maxwidth = 2.489;
        var maxheight = 3.34;
        var _URL = window.URL || window.webkitURL;
        img = new Image();
        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            
            imgwidth = this.width * (2.54 / 96);
            imgheight = this.height * (2.54 / 96);
          
            if (imgwidth <= maxwidth && imgheight <= maxheight) {
                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah')
                                .attr('src', e.target.result)
                                .width(120)
                                .height(130);
                    };

                    reader.readAsDataURL(input.files[0]);
                }

            } else {
                alert('The image width and height must be less than to  2.49 and 3.34 cm respectively \nPlease reformat your image and try again');
                $('#file_div').html('<div class="form-group"><label for="exampleInputFile">Staff Image</label>\n\
    <input type="file" id="i_file" name="stuff_photo" accept="image/*" onchange="readURL1(this);">\n\
<img id="blah" src="staff_image/person.JPG" class="user-image" alt="User Image">\n\
</div>');

            }

        }
    }

    function readURL2(input) {
        var fsize = $('#i_files')[0].files[0].size;

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blahs')
                        .attr('src', e.target.result)
                        .width(50)
                        .height(40);
            };

            reader.readAsDataURL(input.files[0]);
        }

    }

    function readURL(input, id) {
        var file = $('#i_file' + id)[0].files[0];
        var fsize = file.size;
        var imgwidth = 0;
        var imgheight = 0;
        var maxwidth = 2.489;
        var maxheight = 3.34;
        var _URL = window.URL || window.webkitURL;
        img = new Image();
        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            imgwidth = this.width * (2.54 / 96);
            imgheight = this.height * (2.54 / 96);
            if (imgwidth <= maxwidth && imgheight <= maxheight) {
                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah' + id)
                                .attr('src', e.target.result)
                                .width(90)
                                .height(119);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            } else {

                alert('The image width and height must be less or equal to 2.48 and 3.34 respectively \nPlease reformat your image and try again');
                $('#file_div' + id).html('<div class="form-group"><label for="exampleInputFile">Staff Image</label>\n\
    <input type="file" id="i_file' + id + '" name="stuff_photo" accept="image/*" onchange="readURL(this,' + id + ');">\n\
<img id="blah' + id + '" src="staff_image/person.JPG" class="user-image" alt="User Image">\n\
</div>');
//                alert('The image width and height must be 90 and 119 respectively \nPlease reformat your image and try again');
//                $('#file_div' + id).html('<img style="width:100%;"id="blah' + id + '" src="staff_image/person.jpg" alt="your image" align="left"/><br/><br/><p style="color:blue">Upload a clear and professional photo .</p><input type="file" class="form-control" id="i_file" name="std_photo" accept="image/*" onchange="readURL(this,"' + id + '");" />');

            }

        }


    }
    function readURL2(input, id) {
        var fsize = $('#i_files' + id)[0].files[0].size;
        if (fsize > 7168000) {
            alert('The image size is very big, must be less than 700 KBs\nPlease select another image');
            $('#file_divs').html('<img style="width:10%;"id="blah" src="logo/logo.png" alt="your image" align="left"/><br/><br/><p style="color:blue">Upload a clear and professional photo .</p><input type="file" class="form-control" id="i_file" name="std_photo" accept="image/*" onchange="readURL(this);" />');
        } else {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blahs' + id)
                            .attr('src', e.target.result)
                            .width(50)
                            .height(40);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    }
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, locale: {format: 'MM/DD/YYYY hh:mm A'}})
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })


    function Check() {
        var checkBoxes = document.getElementsByName('staff[]');
        for (i = 0; i < checkBoxes.length; i++) {
            checkBoxes[i].checked = (selectControl.innerHTML == "Click to Select All") ? 'checked' : '';

            var staff_id = checkBoxes[i].id;
            var staff_name = checkBoxes[i].value;
            clicked(staff_id, staff_name);
        }
        selectControl.innerHTML = (selectControl.innerHTML == "Click to Select All") ? "Click to Unselect All" : 'Click to Select All';
    }
    $tr_id = 1;
    function clicked(staff_id, staff_name) {
        var btn = document.getElementById("printing_button");
        var row_ids = Math.round(Math.random( ) * 300000000);
        $tr_id = row_ids + 2;
        if (document.getElementById(staff_id).checked) {
            document.getElementById('id_data').insertAdjacentHTML('beforeend', '<div id="' + row_ids + '" class="col-lg-12 col-md-12 col-sm-12"><div class="col-lg-3 col-md-3 col-sm-3"><label>' + staff_name + '</label><input type="hidden" value="' + staff_id + '" class="form-control" name="staff_id[]"/></div>\n\
                  <div  class="col-lg-8 col-md-8 col-sm-8"><input type="email" name="email[]" class="form-control pull-right" required> <input type="hidden" value="' + staff_id + '<?php echo generatePasswordz(); ?>" name="code[]" class="form-control pull-right" required></div>\n\
<div class="col-lg-1 col-md-1 col-sm-1"><button type="button" value="' + row_ids + '" class="fa fa-trash-o btn btn-danger btn-xs" onclick="delete_item(this.value);"></button><br></div></div>');
            btn.setAttribute("type", "submit");
        } else {
            $('#id_data').html('');
            btn.setAttribute("type", "button");
        }



    }

    function clicked_policy(staff_id, staff_name) {
        var btn = document.getElementById("policy_button");
        var row_ids = Math.round(Math.random( ) * 300000000);
        $tr_id = row_ids + 2;
        if (document.getElementById('policy_' + staff_id).checked) {
            document.getElementById('id_data_policy').insertAdjacentHTML('beforeend', '<div id="' + row_ids +'_policy" class="col-lg-12 col-md-12 col-sm-12"><div class="col-lg-3 col-md-3 col-sm-3"><label>' + staff_name + '</label><input type="hidden" value="' + staff_id + '" class="form-control" name="staff_id[]"/></div>\n\
                  <div  class="col-lg-8 col-md-8 col-sm-8"><input type="email" name="email[]" class="form-control pull-right" required> <input type="hidden" value="' + staff_id + '<?php echo generatePasswordz(); ?>" name="code[]" class="form-control pull-right" required></div>\n\
<div class="col-lg-1 col-md-1 col-sm-1"><button type="button" value="' + row_ids + '_policy" class="fa fa-trash-o btn btn-danger btn-xs" onclick="delete_item1(this.value);"></button><br></div></div>');
            btn.setAttribute("type", "submit");
        } else {
            $('#id_data').html('');
            btn.setAttribute("type", "button");
        }



    }

    function delete_item(element_id) {
        //            document.getElementById('add_button').style.display = 'block';
        $('#' + element_id).html('');
    }
      function delete_item1(element_id) {
        
        //            document.getElementById('add_button').style.display = 'block';
        $('#' + element_id).html('');
    }
</script>