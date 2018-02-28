<!DOCTYPE html>
<html lang="en">
<head>
<?php //print_r($this->session->userdata());exit;?>
    <?php require('resources/includes/headerlinks.php'); ?>
</head>
<?php //echo "<pre>"; print_r($bookingDetails);exit;?>
<body>
    <?php require('resources/includes/header.php'); ?>

        <section>
            <div class="block courtbanner backgroundImg text-center">
                <div class="about-heading block">
                    <div class="container">
                        <h3>Book your court</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="courtbooking-container block padding60">
                <div class="container">
                    <div class="courtbooking-inner  block">
                        <div class="row">
                            <div class="col-md-4 col-sm-5">
                                <div class="booking-details-container padding10 whitebg block">
                                    <div class="booking-head block"> Cart Preview </div>
                                    <div class="booking-details margin20TB block">
                                        <ul class="block">

                                            <?php $totalPrice = 0; $courtNameArray = []; $bookedIds = array();?>
                                            <li>Court Name

                                                <?php foreach($bookingDetails as $tempbookDet) {
                                                    $bookedIds[] = $tempbookDet['bookings_id'];
                                                    $courtNameArray[] = $tempbookDet['courtDetail']['name']; 
                                                }
                                                $courtName = array_unique($courtNameArray);
                                                $bookedIdsInString = implode(',', $bookedIds);
                                                // Above are the configurations.
                                                foreach ($courtName as $key => $tempCourtName) { ?>
                                                    <span class="bookedCourtNo pull-right">
                                                        <?php echo $tempCourtName;?>
                                                    </span>
                                                 <?php } ?>

                                            </li>
                                            <li>Timings 
                                            <?php foreach($bookingDetails as $tempbookDet) { ?>
                                                <span class="bookedCourtTime pull-right">
                                                    <?php echo $tempbookDet['slotDetail']['slot_timing'];
                                                        // calculating the total price here to avaoid one more for loop.
                                                        $totalPrice += $tempbookDet['slotDetail']['price'];
                                                    ?>
                                                </span>
                                            <?php }?>
                                            </li>
                                            <li>
                                                Amount
                                                <span class="bookedCourtAmt pull-right">
                                                     <?php echo number_format($totalPrice, 2); ?>
                                                </span>
                                            </li>
                                            <li class="totalCls">Total 
                                                <span class="bookedCourtTotal pull-right">
                                                    <?php echo number_format($totalPrice, 2);?>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-7">
                                <div class="booking-address block  ">
                                    <form action="<?php echo base_url('make-payment'); ?>" method="post">
                                        <input type="hidden" name="booked_id" value="<?php echo $bookedIdsInString; ?>">
                                        <input type="hidden" name="price" value="<?php echo $totalPrice; ?>">

                                    <?php if(!empty($this->session->userdata('username'))) { ?>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control bookingJS" name="name"
                                            id="name" required value="<?php echo $this->session->userdata('firstname');?>"> 
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control bookingJS" name="email"
                                            id="email" required value="<?php echo $this->session->userdata('username');?>"> 
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="number" class="form-control bookingJS" name="mobile"
                                                id="phone" required value="<?php echo $this->session->userdata('mobile');?>">
                                        </div>
                                        <?php } else {?>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control bookingJS" id="name" required
                                            name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control bookingJS" id="email" required
                                            name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="number" class="form-control bookingJS" id="phone" required
                                            name="mobile">
                                        </div>
                                        <?php } ?>
                                        <!-- <div class="checkbox">
                                            <label>
                                                <input type="checkbox" required> <small>Accept Terms & Privacy</small></label>
                                        </div>
                                       -->
                                        
                                        <div class="bookingdate-container boxshadow margin20TB block whitebg">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-3 col-xs-6 ">
                                                    <div class="checkout block"> <a href="<?php echo base_url('courtBooking')?>" class="mybtn">Cancel </a> </div>
                                                </div>
                                                <div class="col-md-offset-8 col-md-2 col-sm-offset-6 col-sm-3 col-xs-6 ">
                                                    <div class="checkout block">
                                                        <button type="submit" class="mybtn">Pay Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                </div>
            </div>
        </section>
        <?php require('resources/includes/footer.php'); ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/frontend');?>/js/calender/foundation-datepicker.min.css" />
            <script type="text/javascript" src="<?php echo base_url('assets/frontend');?>/js/calender/foundation-datepicker.min.js"></script>
            <script>
                $('#startdate').fdatepicker({
                    closeButton: true
                });
            </script>
</body>

</html>