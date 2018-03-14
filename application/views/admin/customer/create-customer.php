
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
                                <label>First Name</label>
                                <input type="text" name="first_name" placeholder="Enter First name" 
                                class="form-control" value="<?php echo set_value('first_name')?>">
                                <?php echo form_error('first_name'); ?>
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
    <div class="row">
        <?php if($this->session->flashdata('success-message')){?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('success-message');?>
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
                        <a href="<?php echo base_url('school/courses/add');?>"><button type="button" class="btn btn-outline btn-primary dim ">New Course</button></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Name</th>
                                    <th>Opening Time</th>
                                    <th>Closing Time</th>
                                    <th>Slot Interval</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $srno = 1; foreach($allCourts as $tempCourts):?>
                                <tr class="gradeX" id="<?php echo $tempCourts['court_id'];?>">
                                    <td><?php echo $srno;?></td>
                                    <td><?php echo ucwords($tempCourts['name']);?></td>
                                    <td><?php echo ucwords($tempCourts['opening_time']);?></td>
                                    <td><?php echo ucfirst($tempCourts['closing_time']);?></td>
                                    <td><?php echo ucfirst($tempCourts['slot_interval']). " Hours";?></td>
                                    <td>
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                        <p>
                                            <a href="<?php echo base_url('admin/court/edit').'/'.$tempCourts['court_id'];?>">
                                                <button type="button" class="btn btn-outline btn-warning">
                                                   Edit
                                                </button>
                                            </a>
                                            <a href="<?php echo base_url('admin/court/delete').'/'.$tempCourts['court_id'];?>">
                                                <button type="button" class="btn btn-outline btn-warning">
                                                    Delete
                                                </button>
                                            </a>
                                            <?php if($tempCourts['status'] == 1){?>
                                            <button type="button" class="btn btn-outline btn-warning inactivate_course">
                                                Inactivate
                                            </button>
                                            <?php } else{?>
                                            <button type="button" class="btn btn-outline btn-warning activate_course">
                                                Activate
                                            </button>
                                            <?php }?>
                                            <!-- <button type="button" class="btn btn-outline btn-danger dim delete_course">
                                                Delete
                                            </button> -->
                                            
                                        </p>
                                    </td>
                                </tr>
                                <?php $srno++;endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
