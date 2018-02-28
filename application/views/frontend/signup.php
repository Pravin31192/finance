<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('resources/includes/headerlinks.php'); ?>
</head>

<body>
    <?php require('resources/includes/header.php'); ?>
        <section>
            <div class="about-us block aboutbanner backgroundImg text-center">
                <div class="about-heading block">
                    <div class="container">
                        <h3>Sign up </h3>
                        <p class="col-sm-offset-2 col-sm-8">Create an account to book your court and get the updates about your court. It's easy to register. </p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="signup-Section block whitebg padding60">
                <div class="container">
                    <h3 class="pageHeading text-center ">Sign up </h3>
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="booking-address block">
                                <!-- <form action="<?php echo base_url("signup");?>" method="post"> -->
                                <?php echo form_open(); ?>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="firstname">First Name</label>
                                            <input type="text" class="form-control bookingJS" name="firstname" required
                                                value="<?php echo set_value('firstname');?>">
                                            <?php echo form_error('firstname');?>
                                        </div>
                                        
                                        <div class="form-group col-sm-6">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" class="form-control bookingJS" name="lastname" required
                                                value="<?php echo set_value('lastname');?>" >
                                            <?php echo form_error('lastname');?>
                                        </div>
                                        
                                        <div class="form-group col-sm-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control bookingJS" name="email" required
                                                value="<?php echo set_value('email');?>" >
                                            <?php echo form_error('email');?>
                                        </div>
                                        
                                        <div class="form-group col-sm-6">
                                            <label for="mobile">Mobile</label>
                                            <input type="number" class="form-control bookingJS" name="mobile" required
                                                value="<?php echo set_value('mobile');?>" maxlength="10">
                                            <?php echo form_error('mobile');?>
                                        </div>
                                        
                                        <div class="form-group col-sm-6">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control bookingJS" name="password" required
                                                value="<?php echo set_value('password');?>" >
                                            <?php echo form_error('password');?>
                                        </div>

                                         <div class="form-group col-sm-6">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" class="form-control bookingJS" name="confirm_password"
                                                required>
                                            <?php echo form_error('confirm_password');?> 
                                        </div>
                                        
                                        <div class="form-group col-sm-12">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control bookingJS" name="address" required
                                                value="<?php echo set_value('address');?>" >
                                            <?php echo form_error('address');?>
                                        </div>
                                        
                                        <div class="checkbox col-sm-12">
                                            <label>
                                                <input type="radio" name="gender" value="1" <?php echo set_radio('gender', '1');?>> Male
                                            </label>
                                            <label>
                                                <input type="radio" name="gender" value="0" <?php echo  set_radio('gender','0');?>> Female
                                            </label>
                                                <!-- <input type="checkbox" required>  -->
                                                <!-- <small>Accept Terms & Privacy</small> -->
                                        </div>
                                        
                                        <div class="col-sm-offset-4 col-sm-4">
                                            <button type="submit" class="mybtn">Signup</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php require('resources/includes/footer.php'); ?>
</body>

</html>