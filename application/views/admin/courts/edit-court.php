
<div class="row border-bottom white-bg">
                <div class="col-sm-12">
                    <h2>We can display the breadcrumbs over here</h2>
                </div>
            </div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <?php if($this->session->flashdata('success-message')){?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('success-message');?>
        </div>
    <?php }?>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Courts</h5>
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
                                class="form-control" value="<?php echo set_value('court_name', $allCourts['name']);?>">
                                <?php echo form_error('court_name'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Slot Interval</label>
                                <input type="text" name="slot_interval" placeholder="Enter in Hours" 
                                class="form-control" value="<?php echo set_value('slot_interval', $allCourts['slot_interval']);?>">
                                <?php echo form_error('slot_interval'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Opening Time</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="opening_time" placeholder="Select Time"
                                        value="<?php echo set_value('opening_time', $allCourts['opening_time']);?>">
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                </div>
                                <?php echo form_error('opening_time'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Closing Time</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="closing_time" placeholder="Select Time"
                                        value="<?php echo set_value('closing_time', $allCourts['closing_time']);?>">
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                </div>
                                <?php echo form_error('closing_time'); ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Price</label>
                                <input type="text" name="price" placeholder="Enter Price" 
                                class="form-control" value="<?php echo set_value('price',$allCourts['price']);?>">
                                <?php echo form_error('price'); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Description</label>
                                <textarea placeholder="A small description" name="description" 
                                    class="form-control">
                                    <?php echo set_value('description',$allCourts['description']);?>
                                </textarea>
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
</div>

    
    
    <script>
        $(document).ready(function(){
            $('.clockpicker').clockpicker();
        });

    </script>