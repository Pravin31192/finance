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
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Create Slots</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url('school/courses/add');?>">
                                <div class="form-group">
                                    <label>Select Court</label>
                                    <!-- <input type="name" placeholder="Enter Court name" class="form-control"> -->
                                    <select name="streamName" class="form-control" onchange="getSlotTimes(this.value)">
                                        <option value="">Select Court</option>
                                        <?php foreach($courtsTable as $temp) {?>
                                            <option value="<?php echo $temp->court_id;?>">
                                                <?php echo ucwords($temp->name)?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Available Slots</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal" method="post" 
                                action="<?php echo base_url('slots/edit');?>">

                                <div class="row" id="slot-container">
                                    <div class="text-center">Select a Court from the Dropdown to edit the slots</div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit">
                                        <strong>Save</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

function getSlotTimes(selectedCourt)
{
    console.log("Print");
    $.ajax({
        type : "POST",
        url : "<?php echo base_url("slots/getSlots");?>",
        data : {courtId : selectedCourt},
        success : function(result){
            var res = JSON.parse(result);
            var container = document.getElementById("slot-container");
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for(var i=0; i<res.length; i++) {
                
                //container.appendChild(document.createTextNode("Member " + (i+1)));
                var divFirstColumn = document.createElement("div");
                divFirstColumn.className = "col-sm-4 afterDelete"+res[i].slot_id;
                divFirstColumn.appendChild(document.createTextNode((i+1)+" ) "+res[i].slot_timing));

                var divSecondColumn = document.createElement("div");
                divSecondColumn.className = "col-sm-7 afterDelete"+res[i].slot_id;
                var input = document.createElement("input");
                input.type = "text";
                input.value = res[i].price;
                input.name = 'slot-'+res[i].slot_id;
                input.className = "form-control";

                var spanTag = document.createElement("span");
                spanTag.className = "afterDelete"+res[i].slot_id;

                var deleteIcon = document.createElement("i");
                deleteIcon.className = "fa fa-trash col-sm-1";
                deleteIcon.id = res[i].slot_id;
                deleteIcon.setAttribute("onclick","deleteSlot(this)");
                var hr = document.createElement("hr");

                container.appendChild(divFirstColumn);
                container.appendChild(divSecondColumn);
                container.appendChild(spanTag);
                divSecondColumn.appendChild(input)
                spanTag.appendChild(deleteIcon);
                divSecondColumn.appendChild(hr);
                //container.appendChild(document.createElement("br"));
                //container.appendChild(document.createElement("hr"));

            }
        },
        error : function(error){
            alert("error");
        }
    });
}

function deleteSlot(a)
{

    var r = confirm("Are you sure about deleting this ?");
    if (r == true) {
        var id = a.id;
        $.ajax({
            url : '<?php echo base_url('admin/delete-slot');?>',
            type : 'POST',
            data : {id : a.id},
            success : function(result){
                
                var res = $.parseJSON(result);
                if (res == true) {
                    $('.afterDelete'+id).hide();
                } else {
                    alert("Unable to delete. Please contact the support");
                }
            }, error : function (error){
                alert("Error");
            }
        });    
    } else {
        //alert("Cancelled");return;
    }
}   

</script>
