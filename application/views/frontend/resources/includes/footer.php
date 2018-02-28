<section>
    <div class="newsletter-section block">
        <div class="container-fluid">
            <div class="inner-padding block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="newsletter-left newsletter block ">
                            <h3>Newsletter</h3>
                            <p>Sign up to receive the latest news by email.</p>
                            <form action="<?php echo base_url('newsletter');?>" method="POST">
                                <div class="row">
                                    <div class="form-group col-xs-8">
                                        <input class="form-control inputclass" name="email" placeholder="Enter your email" required="" type="email"> </div>
                                    <input class="link-cls " value="Submit" type="submit"> </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="newsletter-right newsletter block">
                            <h3>Refer a friend</h3>
                            <p>Invite your friends and earn 30% for each referral* ... You'll get paid for every new friend that signs up with us.</p>
                            <div class="refer-triangle"> 30%</div>
                            <div class="activities-book block"> 
                                <a data-toggle="modal" data-target="#myModal">
                                    Refer Now
                                    <span class="bdr1"></span>
                                    <span class="bdr2"></span>
                                    <span class="bdr3"></span>
                                    <span class="bdr4"></span>
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div id="myModal" class="modal fade refer-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Refer a friend</h4> </div>
                <div class="modal-body">
                    <p>Invite your friends and earn 30% for each referral* ... You'll get paid for every new friend that signs up with us.</p>
                    <!-- action="refer-friend.php" -->
                    <form  action="referFirend" method="POST" onsubmit="return validateform();">
                        <div class="form-group">
                            <input class="form-control inputclass" name="name" placeholder="Name" required="" type="text"> </div>
                        <div class="form-group">
                            <input class="form-control inputclass" name="email" placeholder="Email" required="" type="email"> </div>
                        <div class="form-group">
                            <input class="form-control inputclass" name="location" placeholder="Location" required="" type="text"> </div>
                        <div class="form-group">
                            <input class="form-control inputclass" name="contactnumber" placeholder="Contact Number" type="number"> </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Message" class="form-control textareaclass" rows="3" cols="113"></textarea>
                        </div>
                        <input class="link-cls margin20" value="Submit" type="submit"> </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="gallery-section block">
        <div class="container">
            <div class="inner-padding block">
                <div class="gallery-head block">Gallery</div>
                <div class="gal1  block">
                    <ul>
                        <li>
                            <a>
                                <img src="<?php echo base_url('assets/frontend/');?>/images/homegal1.png" alt="Gallery Images">
                            </a>
                        </li>
                        <li>
                            <a>
                                <img src="<?php echo base_url('assets/frontend/');?>/images/homegal2.png" alt="Gallery Images">
                            </a>
                        </li>
                        <li>
                            <a>
                                <img src="<?php echo base_url('assets/frontend/');?>/images/homegal3.png" alt="Gallery Images">
                            </a>
                        </li>
                        <li>
                            <a>
                                <img src="<?php echo base_url('assets/frontend/');?>/images/homegal4.png" alt="Gallery Images">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="gal2 block">
                    <ul>
                        <li>
                            <a>
                                <img src="<?php echo base_url('assets/frontend/');?>/images/homegal6.png" alt="Gallery Images">
                            </a>
                        </li>
                        <li>
                            <a>
                                <img src="<?php echo base_url('assets/frontend/');?>/images/homegal7.png" alt="Gallery Images">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section >
    <div class="contact-section block">
        <div class="footer-head block">Spunk Sports club </div>
        <div class="footer-arrow block">
            <div class="inner-arrow "><a href="#">+ </a> </div>
        </div>
        <div class="footer-links block">
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="<?php echo base_url('contactUs'); ?>">Contact</a></li>
                <li><a href="#" target="blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#" target="blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="design-develop block">
            <a href="http://www.bigappcompany.com" target="_blank">Made with 
                <i class="fa fa-heart" aria-hidden="true"></i>
                 by BigAppCompany
            </a>
        </div>
    </div>
</section>

<script src="<?php echo base_url('assets/frontend');?>/js/spunk.js" type="text/javascript"></script>
    