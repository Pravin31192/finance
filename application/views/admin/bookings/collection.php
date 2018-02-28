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
        <?php if($this->session->flashdata('msg')){?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('msg');?>
        </div>
        <?php }?>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Courts List</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Court Name</th>
                                    <th>Booked For</th>
                                    <th>Slot</th>
                                    <th>Price</th>
                                    <th>Booked On</th>
                                    <th>Customer</th>
                                    <th>Contact Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <?php if(!empty($adminBookedSlots)) {?>
                            <tbody>
                                <?php $srno = 1; foreach($adminBookedSlots as $tempBookedSlots):?>
                                <tr class="gradeX" id="<?php echo $tempBookedSlots['bookings_id'];?>">
                                    <td><?php echo $srno;?></td>
                                    <td><?php echo ucwords($tempBookedSlots['courtDetails']['name']);?></td>
                                    <td><?php echo $tempBookedSlots['date'];?></td>
                                    <td><?php echo ucwords($tempBookedSlots['slotDetails']['slot_timing']);?></td>
                                    <td><?php echo ucfirst($tempBookedSlots['slotDetails']['price']);?></td>
                                    <td><?php echo date('d/m/Y h:m a', $tempBookedSlots['booked_on']);?></td>

                                    <td>
                                    	<?php echo ucfirst($tempBookedSlots['userDetails']->firstname.' '. $tempBookedSlots['userDetails']->lastname);?>
                                    </td>
                                    <td>
                                    	<?php echo ucfirst($tempBookedSlots['userDetails']->mobile);?>
                                    </td>
                                    <td>
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                        <p>
                                            <!-- <a href="<?php //echo base_url('admin/bookings/release').'/'.$tempBookedSlots['bookings_id'];?>">
                                                <i class="glyphicon glyphicon-pencil" title="Edit"></i>
                                            </a> -->
                                            <!-- <i class="glyphicon glyphicon-trash" title="Delete"></i> -->
                                            <a 
                                            	href="<?php echo base_url('admin/booking-release').'/'.$tempBookedSlots['bookings_id'];?>" class="btn btn-primary btn-sm">
												Release                                                
                                            </a>
                                            
                                            <button style="display: none" id="originalBookNow" type="button" 
                                            	class="btn btn-info btn-primary pull-right" data-toggle="modal" 
                                            	data-target="#myModal">
                                            </button>
                                            <?php if($tempBookedSlots['amount'] == 0) {?>
                                            <button type="button" class="btn btn-primary btn-sm"
                                            	id="<?php echo  $tempBookedSlots['bookings_id'].'-'.$tempBookedSlots['slotDetails']['price'];?>" 
                                            	onclick="activatePayment(this.id)">
                								Pay
            								</button>
            								<?php }?>
                                            
                                        </p>
                                    </td>
                                </tr>
                                <?php $srno++;endforeach;?>
                            </tbody>
                            <?php } else {?>
                                <tbody>
                                    <tr>
                                    <td colspan="9" style="text-align:center">No bookings are available.</td>
                                    </tr>
                                </tbody>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form action="<?php echo base_url('admin/payForBookings');?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="bookings" id="booking-id">
                        <div class="form-group">
                            <input type="text" class="form-control" name="amount-paid"
                            	id="amount-to-pay"
                                placeholder="Enter the amount" required >
                        </div>

                        <div class="form-group" >
                        	<select class="form-group" name="mode-of-payment">
                        		<option value="0">Select Payment Mode</option>	
								<option value="1">Cash</option>
								<option value="2">Card</option>
								<option value="3">Paytm</option>
							</select>			
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
	function activatePayment(bookingId)
    {
    	var idPrice = bookingId.split('-');
    	$('#booking-id').val(idPrice[0]);
    	$('#amount-to-pay').val(idPrice[1]);
        $('#originalBookNow').click();
    }

</script>