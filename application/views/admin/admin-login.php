<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | SPUNK</title>

    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet"> -->

    <link href="<?php echo base_url('assets/css/animate.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">SP</h1>

            </div>
            <h3>Welcome to Admin Panel</h3>
            <h3><strong>Sign In</strong></h3>
            <?php if($this->session->flashdata('password')){?>
                    <div class="alert alert-warning alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                        <?php echo $this->session->flashdata('password');?>
                    </div>
                <?php }?>
                <?php if($this->session->flashdata('nomail')){?>
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                        <?php echo $this->session->flashdata('nomail');?>
                    </div>
                <?php }?>
            <form class="m-t" role="form" action="<?php echo base_url('admin/login');?>" method="post">
                <div class="form-group">

                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <input type="text" class="form-control" name="username" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                </div>
                <input type="submit" name="btn_login" value="Login" class="btn btn-primary block full-width m-b">
            </form>

            <a class="text-center" href="<?php //echo base_url('admin/forgotPassword');?>">Forgot Password ?</a>

            <p class="m-t"> <small>Spunk &copy; <?php echo date("Y");?></small> </p>
        </div>
    </div>
</body>

</html>
