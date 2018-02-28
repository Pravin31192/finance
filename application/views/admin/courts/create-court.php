
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
                                <label>Court Name</label>
                                <input type="text" name="court_name" placeholder="Enter Court name" 
                                class="form-control" value="<?php echo set_value('court_name')?>">
                                <?php echo form_error('court_name'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Slot Interval</label>
                                <input type="text" name="slot_interval" placeholder="Enter in Hours" 
                                class="form-control" value="<?php echo set_value('slot_interval')?>">
                                <?php echo form_error('slot_interval'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Opening Time</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="opening_time" placeholder="Select Time">
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                </div>
                                <?php echo form_error('opening_time'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Closing Time</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="closing_time" placeholder="Select Time">
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                </div>
                                <?php echo form_error('closing_time'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Price</label>
                                <input type="text" name="price" placeholder="Enter Price" 
                                class="form-control" value="<?php echo set_value('price')?>">
                                <?php echo form_error('price'); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Description</label>
                                <textarea placeholder="A small description" name="description" 
                                    class="form-control"><?php echo set_value('description')?></textarea>
                                <?php echo form_error('description'); ?>
                            </div>

                            <div class="form-group col-md-8">
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

    
    
    <script>
        $(document).ready(function(){
            $('.clockpicker').clockpicker();
        });

    </script>