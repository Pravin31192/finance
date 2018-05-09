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
                    <h5>Collection List</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover " >
                            <thead>
                                <tr>
                                    <th>Installment Number</th>
                                    <th>Monthly Principle</th>
                                    <th>Monthly Interest</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $srno = 1; foreach($installmentList as $temp):?>
                                <tr class="gradeX" id="<?php echo $temp->id;?>">
                                    <td><?php echo $srno;?></td>
                                    <td><?php echo $temp->monthly_principle;?></td>
                                    <td><?php echo $temp->monthly_interest;?></td>
                                    <td>
                                        <?php 
                                            echo $temp->monthly_principle + $temp->monthly_interest;?>
                                    </td>
                                    <td><?php echo ($temp->status == 0) ? 'Not Paid' : 'Paid';?></td>
                                    <td>
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                        <p>
                                            <a href="<?php echo base_url('admin/loan/initiate').'/'.$temp->id;?>">
                                                <button type="button" class="btn btn-primary">
                                                   Pay
                                                </button>
                                            </a>
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
    <script src="<?php echo base_url("assets/");?>js/plugins/dataTables/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                   
                ]

            });

        });

    </script>

    