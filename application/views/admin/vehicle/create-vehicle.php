
<div class="row border-bottom white-bg">
    <div class="col-sm-12">
        <h2>We can display the breadcrumbs over here</h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <?php if($this->session->flashdata('access_msg')){?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('access_msg');?>
        </div>
    <?php }?>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Create Courts</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                    <?php
                    //this validation_errors() will display all the validation errors.  
                    //echo validation_errors();?>
                    
                        <?php echo form_open(); ?>
                            <div class="form-group col-md-4">
                                <label class="font-normal">Select Customer</label>
                                <div>
                                    <select data-placeholder="Choose a Country..." 
                                    class="chosen-select"  tabindex="2">
                                    <option value="">Select</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Aland Islands">Aland Islands</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-normal">Select Customer</label>
                                <?php echo form_dropdown('name', ['Pravin', 'Vijay', 'Master'], null, ['placeholder' => 'Select a name', 'class' => 'form-control']);?>
                            </div>

                            

                            <div class="form-group col-md-4">
                                <label>Last Name</label>
                                <input type="text" name="last_name" placeholder="Enter Last name" 
                                class="form-control" value="<?php echo set_value('last_name')?>">
                                <?php echo form_error('last_name'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Father Name</label>
                                <input type="text" name="father_name" placeholder="Enter Father name" 
                                class="form-control" value="<?php echo set_value('father_name')?>">
                                <?php echo form_error('father_name'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Mobile number</label>
                                <input type="text" name="mobile" placeholder="Enter mobile number" 
                                class="form-control" value="<?php echo set_value('mobile')?>">
                                <?php echo form_error('mobile'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <textarea type="textarea" name="address" placeholder="Enter Address" 
                                class="form-control" value="<?php echo set_value('address')?>"></textarea>
                                <?php echo form_error('address'); ?>
                            </div>

                             <div class="form-group col-md-4">
                                <label>
                                Gender</label>
                                <input type="radio" name="gender" checked="true" value="1"> Male
                                <input type="radio" name="gender" value="2"> Female
                                <?php echo form_error('gender'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs btnstyle" type="submit">
                                    <strong>Save</strong>
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End of row tag-->
</div>

    
    
    <script>
        $(document).ready(function(){
            $('.clockpicker').clockpicker();

        });

    </script>