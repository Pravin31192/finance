
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
                                <select name="vehicle_id" placeholder="Enter Vehicle name" id="customer_vehicles"
                                class="form-control" value="<?php echo set_value('vehicle_id')?>">
                                <option value="">Select Vehicle</option>
                                </select>
                                
                                <?php echo form_error('vehicle_id'); ?>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Loan Amount</label>
                                <input type="text" name="loan_value" placeholder="Enter Loan amount" id="loan_value"
                                class="form-control" value="<?php echo set_value('loan_value')?>">
                                <?php echo form_error('loan_value'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Interest Percentage</label>
                                <input type="text" name="interest_percentage" placeholder="Enter Interest Percentage" id="interest_percentage" onchange="calculateInterest(this)"
                                class="form-control" value="<?php echo set_value('interest_percentage')?>">
                                <?php echo form_error('interest_percentage'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Monthly Interest</label>
                                <input type="text" name="monthly_interest" placeholder="Enter Monthly Interest" id="monthly_interest"
                                class="form-control" value="<?php echo set_value('monthly_interest')?>">
                                <?php echo form_error('monthly_interest'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>No of Installments</label>
                                <input type="text" name="no_of_installments" placeholder="No of Installments" id="no_of_installments" onchange="calculateInstallments(this)"
                                class="form-control" value="<?php echo set_value('no_of_installments')?>">
                                <?php echo form_error('no_of_installments'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Monthly Principle</label>
                                <input type="text" name="monthly_principle" placeholder="Monthly Principle" id="monthly_principle" 
                                class="form-control" value="<?php echo set_value('monthly_principle')?>">
                                <?php echo form_error('monthly_principle'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Monthly Pay</label>
                                <input type="text" name="installment_amount" placeholder="Total return" id="installment_amount" readonly="true"
                                class="form-control" value="<?php echo set_value('installment_amount')?>">
                                <?php echo form_error('installment_amount'); ?>
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
    console.log(customerId);
    $.ajax({
        url : '<?php echo base_url('admin/customer/loadCustomerVehicles');?>',
        type : 'POST',
        data : {customerId : customerId},
        success : function(result){
            var obj = JSON.parse(result);
            console.log(obj);
            $("#customer_vehicles").html('');
            for (var i=0 ; i < obj.length; i++) {
                $("#customer_vehicles").append(obj[i]);
            }
        }
    });
}

function calculateInstallments(noOfInstallmentsObj) {
    var loanAmount = $("#loan_value").val();
    if (loanAmount != '' && loanAmount != undefined) {
        var noOfInstallments = noOfInstallmentsObj.value;
        var monthlyPrinciple = loanAmount / noOfInstallments;
        $("#monthly_principle").val(monthlyPrinciple);
        var monthlyInterest = $("#monthly_interest").val();
        var monthlyPay = +monthlyPrinciple + +monthlyInterest;
        $("#installment_amount").val(monthlyPay);
    } else {
        alert("Enter Loan Amount");
    }
    
}

function calculateInterest(interestObject) {
    var loanAmount = $("#loan_value").val();
    if (loanAmount != '' && loanAmount != undefined) {
        var interestPercentage = interestObject.value;
        var interest = loanAmount * (interestPercentage / 100);
        $("#monthly_interest").val(interest);
    } else {
        alert("Enter Loan Amount");
    }
}
</script>