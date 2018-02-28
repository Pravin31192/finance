<header id="header" class="header block">
    <div class="row">
        <div class="col-sm-3 nopadding hidden-xs skew whitebg relative2">
            <div class="logo-section block anti-skew">
                <a href="<?php echo base_url('home');?>">
                    
                    <img src="<?php echo base_url('assets/frontend/');?>images/logo.png" alt="Logo"></a>
            </div>
        </div>
        <?php //$this->session->unset_userdata('username');?>
        <div class="col-sm-6 nopadding  ">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header ">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> <a class="hidden-sm hidden-md hidden-lg loginBtn mobilLogin">
                 Login </a>
                    <a class="navbar-brand hidden-sm hidden-md hidden-lg" href="<?=base_url?>index.php">
                        <img src="<?php echo base_url('assets/frontend/');?>/images/logo.png" alt="Logo"></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo base_url();?>" class="active"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('aboutUs')?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('courtBooking')?>"><i class="fa fa-object-group" aria-hidden="true"></i>
                                Courts
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('gallery')?>"><i class="fa fa-picture-o" aria-hidden="true"></i>
                                Gallery
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('contactUs')?>"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-sm-3 hidden-xs nopadding ">
            <div class="booknow block">
                <ul class="relative">
                    <li class="book-icon">
                        <a href="court-booking.php" data-lity="">
                            <!-- <i class="fa fa-calendar" aria-hidden="true"></i>
                            <span>Book Now</span> -->
                        </a>
                    </li>
                    <li class="loginBtn header-call skew">
                        <a class="callto anti-skew block">
                        <?php if($this->session->has_userdata('username')) { ?>
                            <span class="afterLogin">
                                <i class="fa fa-user-circle-o header-call-icon" aria-hidden="true"></i>
                                <span class="contact-text">
                                    <?php echo $this->session->userdata('firstname');?>
                                </span>
                            </span>
                        <?php } else {?>
                            <span class="beforeLogin">
                                <i class="fa fa-sign-in header-call-icon" aria-hidden="true"></i>
                                <span class="contact-text">
                                    Login
                                </span>
                            </span>
                        <?php }?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<section class="block">
    <div class="bodyBlur"> </div>
    <div class="login-container col-md-3 col-sm-5 col-xs-10">
        
        <?php if($this->session->has_userdata('username')) {?>
        <div class="account-details block centered">
        <ul>
            <li>First Name : <span class="userFName"><?php echo $this->session->userdata('firstname')?></span></li>
            <li>Last Name : <span class="userLName"><?php echo $this->session->userdata('lastname')?></span></li>
            <li>Email : <span class="userEmail"><?php echo $this->session->userdata('username')?></span></li>
            <!-- <li>phone : <span class="userAddress">9035414369</span></li>
            <li>Address : <span class="userPhone">Bangalore</span></li>  -->  
            </ul>
        </div>
        <?php } else { ?>
            <h4>
                Signin / Signup 
                <img src="<?php echo base_url('assets/frontend/');?>/images/error.png" class="loginclose pull-right" alt="Close">
            </h4>
            <div class="login-form margin20TB block">
                <form id="login_form" method="post" >

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="username" class="form-control" id="email">
                        <small class="error no-email" style="display:none;">This email is not registered</small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <small class="error didnotmatch" style="display:none;">* Email and Password are Incorrect !!</small>
                    <small class="error non-empty" style="display:none;">* Email and Password should not be empty</small>
                    <button id="login" type="button" onclick="checkLogin()" class="signin signBtn">Login</button>

                    <!-- <a href="<?php echo base_url('signup');?>" class="signout signBtn">Signup</a> --> 
                </form>
            <a href="<?php echo base_url('signup');?>" class="signout signBtn">Signup</a> 
        </div>
        <?php }?>

        <div class="loginbottomList">
            <ul>
                <li><a href="#">Q&A</a></li>
                <li><a href="#">Terms & Privacy</a></li>
                <?php if($this->session->has_userdata('username')) {?>
                <li><a href="<?php echo base_url('logout');?>">Logout</a></li>
                <?php }?>
            </ul>
        </div>
    </div>
</section>

<script>

function checkLogin()
{
    var username = $("#email").val();
    var password = $("#password").val();
    
    if(username != '' && password != '') {
        $(".didnotmatch").hide();
        $(".non-empty").hide();
        $(".no-email").hide();
        $.ajax({
            type: "POST",
            data : $("#login_form").serialize(),
            url: "<?php echo base_url('login');?>",
            success : function(output) {
                //alert(output);
                if(output == 0) {
                    $(".no-email").show();
                    $(".non-empty").hide();
                    $(".didnotmatch").hide();
                } else if (output == 1) {
                    $(".didnotmatch").show();
                    $(".non-empty").hide();
                } else {
                    $(".no-email").hide();
                    $(".didnotmatch").hide();
                    location.reload();
                }        
            },
            error : function(error) {
                console.log(error);
            } // Success function
        }); // End of Ajax.

    } else { // End of username password not null check.
        //$(".error").show();
        $(".non-empty").show();
    }
}
</script>