<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('resources/includes/headerlinks.php'); ?>
</head>
<body>
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend');?>/js/calender/foundation-datepicker.min.css" />
    
    <?php require('resources/includes/header.php'); ?>
        <section>
            <div class="block courtbanner backgroundImg text-center">
                <div class="about-heading block">
                    <div class="container">
                        <h3>Book your court</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="courtbooking-container block padding60">
                <div class="container">
                    <div class="courtbooking-inner block">
                        <div class="bookingdate-container boxshadow block whitebg">
                        
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="booking-date block">
                                        <input type="text" placeholder="Choose Your Date" class="form-control
                                            bookingdate-field" id="startdate" onchange="checkBookings(value)" 
                                        />
                                        <i class="fa fa-calendar" aria-hidden="true"></i> 
                                    </div>
                                </div>
                                <div class="col-sm-offset-4  col-xs-6 col-sm-2 nopadRight ">
                                    <div class="booking-price block" value="0" >0</div>
                                </div>
                                <div class="col-sm-2 col-xs-6 nopadLeft">
                                    <div class="checkout block"> 
                                        <a href="<?php echo base_url("courtCheckOut");?>" class="mybtn">Confirm & Book</a> 
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        
                        <!-- <div id="sampleplan" class="courtsBlock courts boxshadow block margin20TB whitebg padding10" style="display: none">
                            <div class="courtnumber block"></div>
                            <div class="courtSlots block">
                            
                                <ul class="nav-justified">
                                    <li class="" id="liforSlots"></li>            
                                </ul>
                            </div>
                        </div> -->

                        <div id="parent"></div>
                    </div>
                </div>
            </div>
        </section>
    
    
    
        
        <?php require('resources/includes/footer.php'); ?>
        
    <script type="text/javascript" src="<?php echo base_url('assets/frontend');?>/js/calender/foundation-datepicker.min.js"></script>
    <script>
        
        this.dateValidation();
        function dateValidation()
        {
            var selectedDate = $("#startdate").val();
            if (selectedDate == '' || selectedDate == undefined) {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10) {
                    dd = '0'+dd
                } 
                if(mm<10) {
                    mm = '0'+mm
                } 
                today = dd + '-' + mm + '-' + yyyy;
                $("#startdate").val(today);
                this.checkBookings(today);
            }
        }

        $('#startdate').fdatepicker({
            closeButton: true
        });


        var selectedSlotsArray = [];
        //var totalPrice = 0;
        /**
        * Name : selectedSlots
        * Purpose : To show the available slots for the selected date.
        * @param a object of the DOM.
        */
        function selectedSlots(a) {

            var appliedClass = a.className;
            var slotId = a.id; // Selected Slot
            var totalPrice = $(".booking-price").text();
            var price = slotId.split("-");
            
            // Selecting the slot
            if (appliedClass == 'notactive') {
                $(a).toggleClass("active");
                $(a).removeClass("notactive");
                selectedSlotsArray.push(a.id);
                // After selecting the slots the price has to be calculated.
                // The price for each slot is been concatinated in the id
                totalPrice = parseInt(totalPrice) + parseInt(price[1]);
                $('.booking-price').text(totalPrice);

            } else { // Unselecting the Slot
                $(a).toggleClass("notactive");
                $(a).removeClass("active");
                //var selectedId = a.id;
                var index = selectedSlotsArray.indexOf(a.id);
                if (index > -1) {
                    selectedSlotsArray.splice(index, 1);
                }
                totalPrice = parseInt(totalPrice) - parseInt(price[1]);
                $('.booking-price').text(totalPrice);
            }
            
            //console.log(selectedSlotsArray);
            var selectedSlotsInString = selectedSlotsArray.toString();
            // To save these values in the CodeIgniter Session using Ajax
            this.saveSelectedSlotsInSession(selectedSlotsInString);
        }

        function saveSelectedSlotsInSession(selectedSlotsInString)
        {
            $.ajax({
                type : 'POST',
                url : '<?php echo base_url("saveSession")?>',
                data : {selectedSlots : selectedSlotsInString},
                success : function(result) {
                    console.log("Success");
                    console.log(result);
                    //var sessionValue = "<?php echo $this->session->userdata('userSelectedSlots');?>";
                    //console.log(sessionValue);
                }, error : function (error) {
                    console.log("Error");
                }
            });
        }

        /**
        * Name : checkBookings
        * Purpose : on selecting the date we can check the booking table and 
        * check the available courts and their slots.
        */
        function checkBookings(date)
        {
            $.ajax({
                url  : "<?php echo base_url('checkBookings')?>",
                type :"POST",
                data : {date : date},
                success : function(result) {
                    console.log("Succces");
                    console.log(result);
                    var res = $.parseJSON(result);

                    var container = document.getElementById("width100");
                    while (container.hasChildNodes()) {
                        container.removeChild(container.lastChild);
                    }
                    for(var i=0; i<res.length; i++) {
                        //alert(res[i].name);
                        var courtsBlockDiv = document.createElement("div");
                        courtsBlockDiv.id = i;
                        courtsBlockDiv.className = "courtsBlock courts boxshadow block margin20TB whitebg padding10";

                        // Creating Second Div with class "courtnumber block"
                        var courtNumberDiv = document.createElement("div");
                        courtNumberDiv.className = "courtnumber block";
                        courtNumberDiv.text = "Sample";
                        courtNumberDiv.appendChild(document.createTextNode(res[i].name));

                        // Creating "courtSlots block" div child of courtsBlock
                        var courtSlotsDiv = document.createElement("div");
                        courtSlotsDiv.className = "courtSlots block";

                        //Creating ul tag with class "nav-justified"
                        var ultag = document.createElement("ul");
                        ultag.className = "nav-justified";
                        
                        // To be added in the last.
                        container.appendChild(courtsBlockDiv);
                        courtsBlockDiv.appendChild(courtNumberDiv);
                        courtsBlockDiv.appendChild(courtSlotsDiv);
                        courtSlotsDiv.appendChild(ultag);

                        for(var j=0; j < res[i].bookingSlots.length ; j++) {
                            var liTag = document.createElement("li");                    
                            liTag.appendChild(document.createTextNode(res[i].bookingSlots[j].slotDetails['slot_timing']));
                            liTag.id = res[i].bookingSlots[j].bookings_id +'-'+res[i].bookingSlots[j].slotDetails['price'];
                            liTag.setAttribute("onclick","selectedSlots(this)");
                            liTag.className = "notactive";
                            if (res[i].bookingSlots[j].status != 0) {
                                liTag.style = "pointer-events : none";
                                liTag.setAttribute("title","Slot not available");
                                liTag.className = "not-available";
                            }
                            //liTag.className = "Pravin";
                            ultag.appendChild(liTag);
                        }

                    }
                }, // End of Ajax Success function
                error: function(error) {
                    alert("Error");
                },
            });
        } // End of checkBookings function.


                    /*var samplePlan = $("#sampleplan");
                    var liForSlots = $("#liforSlots");
                    
                    $('.old_data').remove();
                    $.each(res, function(index) 
                    {
                        var liForSlotsDuplicate;
                        var subplan_real = samplePlan.clone(false); 
                        subplan_real.css('display','block');
                        subplan_real.attr('id', index);
                        subplan_real.find('.courtnumber').text(res[index].name);
                        // Running the second loop for the bookingslots
                        $.each(res[index].bookingSlots, function(bookingIndex) {
                            //console.log(res[index].bookingSlots[bookingIndex].date);
                            liForSlotsDuplicate = liForSlots.clone(false);
                            liForSlotsDuplicate.attr('id', res[index].bookingSlots[bookingIndex].bookings_id);
                            liForSlotsDuplicate.text(res[index].bookingSlots[bookingIndex].bookings_id);
                            $('.nav-justified').append(liForSlotsDuplicate);
                        }) // Second Loop
                       $('.parent').append(subplan_real);
                    }) // First loop*/
                    //subplan_real.find('.jobs-desc').text(coupons[index].CouponID);
                   // console.log(res);

    </script>
    <style>
    .not-available {
        background-color: #f68403;
    }
    </style>
</body>

</html>
