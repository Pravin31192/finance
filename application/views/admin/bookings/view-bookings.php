<div class="row border-bottom white-bg">
                <div class="col-sm-12">
                    <h2>We can display the breadcrumbs over here</h2>
                </div>
            </div>
            <?php //var_dump($bookingsTable);exit;?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <?php if($this->session->flashdata('access_msg')){?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('access_msg');?>
        </div>
    <?php }?>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Available Bookings</h5><br>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form action="<?php echo base_url('admin/checkBookings');?>" method="post">
                        <div class="col-md-6">
                            <div class="form-group" id="admin-date">
                                <div class="input-group date pull-left">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" name="selected-date" placeholder="Select a date"
                                        required id="admin-date-field"
                                        value="<?php echo !empty($selectedDate) ? $selectedDate : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary pull-right date-submit">Submit
                            </button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End of row-->
    <?php if(isset($bookingDetailsForDate) && !empty($bookingDetailsForDate)) {?>
    <div class="row">
    <?php //echo "<pre>"; print_r($selectedDate);exit;
        foreach($bookingDetailsForDate as $courtsKey => $tempCourts) {?>

        <div class="courts boxshadow block margin20TB whitebg padding10">
            <div class="courtnumber block"><?php echo $bookingDetailsForDate[$courtsKey]['name'] ?></div>
            <div class="courtSlots block">
                <ul class="nav-justified">
                <?php foreach($tempCourts['bookingSlots'] as $bookingKey => $tempBookings) {?>    
                    <li 
                        id="<?php echo  $tempBookings['bookings_id'];?>"
                        class="<?php echo ($tempBookings['status'] == 1) ? 'active' : 'available';?>"
                        style="<?php echo ($tempBookings['status'] != 0) ? "pointer-events:none" : ''; ?>"
                    >
                        <?php echo $tempBookings['slotDetails']['slot_timing']; ?>
                    </li>
                <?php }?>
                </ul>
            </div>
        </div>
    <?php } // end of Courts For loop?>
        <div>
            <button style="display: none" id="originalBookNow" type="button" class="btn btn-info btn-primary pull-right" data-toggle="modal" data-target="#myModal"></button>

            <button type="button" class="btn btn-info btn-primary pull-right" onclick="validateSelection()">
                Book Now
            </button>
        </div>
    </div>
    <?php }?>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form action="<?php echo base_url('admin/bookslots');?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="slots" id="admin-selected-slots">
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstname" 
                                placeholder="Firstname" required >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastname" 
                                placeholder="Lastname" required >
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" 
                                placeholder="email" required >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="mobile" 
                                placeholder="Mobile" pattern=".{10,12}" required title="10 characters">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- data-dismiss="modal" -->
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

// For the date picker to work
     $('#admin-date .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
    });

     // If the date field is empty
     var dateSelected = $('#admin-date-field').val();
     if (dateSelected == '' || dateSelected == undefined) {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        } 
        if(mm<10) {
            mm = '0'+mm
        } 
        today = dd + '-' + mm + '-' + yyyy;
        $("#admin-date-field").val(today);
        $('.date-submit').click();
     }

// To keep on tracking the slots selected by the admin.
var selectedSlotsArray = [];
     $(".courtSlots ul li").click(function () {
        //$(this).toggleClass("active");
        var appliedClass = this.className;
        // Selecting the slot
        if (appliedClass == 'available') {
            $(this).toggleClass("active");
            $(this).removeClass("available");
            selectedSlotsArray.push(this.id);
        } else { // Unselecting the Slot
            $(this).toggleClass("available");
            $(this).removeClass("active");
            var index = selectedSlotsArray.indexOf(this.id);
            if (index > -1) {
                selectedSlotsArray.splice(index, 1);
            }
        }
        //console.log(selectedSlotsArray);
        var selectedSlotsInString = selectedSlotsArray.toString();
        $('#admin-selected-slots').val(selectedSlotsInString)
    });

    function validateSelection()
    {
        var adminSelectedSlots = $('#admin-selected-slots').val();
        if (adminSelectedSlots == '' || adminSelectedSlots == undefined) {
            alert("Please select a slot");
        } else {
            $('#originalBookNow').click();
        }
    }

    

    //$('input[name="daterange"]').daterangepicker();
</script>