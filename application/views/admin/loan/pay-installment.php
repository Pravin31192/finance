
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
                    
                    <?php 
                    //this validation_errors() will display all the validation errors.  
                    //echo validation_errors();?>
                    
                    <?php echo form_open('admin/loan/payInstallment'); ?>
                    <div class="row">
                        <input type="hidden" name="id" value="<?php echo $installmentDetails->id?>">
                        <div class="form-group col-md-4">
                            <label>Monthly Principle</label>
                            <input type="text" name="monthly_principle" placeholder="Monthly Principle" id="monthly_principle"
                            readonly="true"
                            class="form-control" value="<?php echo set_value('monthly_principle', $installmentDetails->monthly_principle)?>">
                            <?php echo form_error('monthly_principle'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Monthly Interest</label>
                            <input type="text" name="monthly_interest" placeholder="Enter Monthly Interest" id="monthly_interest"
                            readonly="true"
                            class="form-control" value="<?php echo set_value('monthly_interest', $installmentDetails->monthly_interest)?>">
                            <?php echo form_error('interest_percentage'); ?>
                        </div>
                        <?php $totalToPay = $installmentDetails->monthly_interest + $installmentDetails->monthly_principle ?>
                        <div class="form-group col-md-4">
                            <label>Total To Pay</label>
                            <input type="text" name="monthly_interest" placeholder="Enter Monthly Interest" id="monthly_interest"
                            readonly="true"
                            class="form-control" value="<?php echo $totalToPay;?>">
                            <?php echo form_error('monthly_interest'); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Fine</label>
                            <input type="text" name="fine" placeholder="Enter Fine If Any" id="fine"  
                            class="form-control" value="0">
                            <?php echo form_error('fine'); ?>
                        </div>
                    </div>
                        <div class="row">
                            <div class="form-group col-md-2 pull-right ">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <strong>Pay Now</strong>
                                </button>

                            </div>
                        </div>
                    </form>
                </div> <!-- End of ibox-content -->
            </div>
        </div>
    </div> <!-- End of row tag-->
</div>

    
    
