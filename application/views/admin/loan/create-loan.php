
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
                                    <select name="user_id" 
                                    class="chosen-select"  tabindex="2" onchange="getVehicles(this)">
                                    <option value="">Select Customer</option>
                                    <?php foreach($userList as $temp) {?>
                                    <option value="<?php echo $temp->user_id?>"><?php echo $temp->first_name.' '.$temp->last_name?></option>
                                    <?php }?>
                                    </select>
                                    <?php echo form_error('user_id'); ?>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Vehicle Name</label>
                                <input type="text" name="vehicle_name" placeholder="Enter Vehicle name" 
                                class="form-control" value="<?php echo set_value('vehicle_name')?>">
                                <?php echo form_error('vehicle_name'); ?>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Vehicle Model</label>
                                <input type="text" name="vehicle_model" placeholder="Enter Vehicle Model" 
                                class="form-control" value="<?php echo set_value('vehicle_model')?>">
                                <?php echo form_error('vehicle_model'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Vehicle Company</label>
                                <input type="text" name="vehicle_company" placeholder="Enter Vehicle Manufacturer"
                                class="form-control" value="<?php echo set_value('vehicle_company')?>">
                                <?php echo form_error('vehicle_company'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Registration number</label>
                                <input type="text" name="reg_number" placeholder="Enter Registration number" 
                                class="form-control" value="<?php echo set_value('reg_number')?>">
                                <?php echo form_error('reg_number'); ?>
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

function getVehicles(userObject)
{
    var customerId = userObject.value;
    alert(customerId);
    $.ajax({
        url : '<?php echo base_url('admin/customer/loadCustomerVehicles');?>',
        type : 'POST',
        data : {customerId : customerId},
        success : function(result){
            console.log(result);
        }
    });
}
</script>