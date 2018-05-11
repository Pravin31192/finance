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
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Loan Number</th>
                                    <th>Customer Name</th>
                                    <th>Loan Amount</th>
                                    <th>Interest</th>
                                    <th>Monthly Pay</th>
                                    <th>No of Months</th>
                                    <th>Total To Pay</th>
                                    <th>Months Paid</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $srno = 1; foreach($loanList as $temp):?>
                                <tr class="gradeX" id="<?php echo $temp['id'];?>">
                                    <td><?php echo $srno;?></td>
                                    <td><?php echo $temp['loan_no'];?></td>
                                    <td><?php echo ucwords($temp['customer_name']);?></td>
                                    <td><?php echo ucwords($temp['loan_value']);?></td>
                                    <td><?php echo ucfirst($temp['interest_percentage']);?></td>
                                    <td><?php echo ucfirst($temp['installment_amount']);?></td>
                                    <td><?php echo ucfirst($temp['no_of_installments']);?></td>
                                    <td><?php echo ucfirst($temp['total_to_pay']);?></td>
                                    <td><?php echo ucfirst($temp['installments_paid']);?></td>
                                    <td>
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                        <p>
                                            <a href="<?php echo base_url('admin/loan/view').'/'.$temp['id'];?>">
                                                <button type="button" class="btn btn-primary">
                                                   View
                                                </button>
                                            </a>
                                            <a href="<?php echo base_url('admin/loan/close').'/'.$temp['id'];?>">
                                                <button type="button" class="btn btn-warning">
                                                    Close
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

    