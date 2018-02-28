<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('resources/includes/headerlinks.php'); ?>
</head>

<body>
    <?php require('resources/includes/header.php'); ?>
        <section>
            <div class="about-us block aboutbanner backgroundImg text-center">
            
                <div class="about-heading block">
                    <div class="container">
                   <h3>Gallery</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                </div>
                    
                </div>
            </div>         
        </section>
    <section>
        <div class="about-descption block whitebg padding60">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery1.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery1.jpg" data-fancybox-group="gallery">
                    </div>
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery2.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery2.jpg" data-fancybox-group="gallery">
                    </div>
                    <div class="col-sm-4">
                            <img src="<?php echo base_url('assets/frontend');?>/images/gallery3.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery3.jpg" data-fancybox-group="gallery">
                        </div>
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery4.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery4.jpg" data-fancybox-group="gallery">
                    </div>
                     <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery5.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery5.jpg" data-fancybox-group="gallery">
                    </div>
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery6.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery6.jpg" data-fancybox-group="gallery">
                    </div>
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery7.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery7.jpg" data-fancybox-group="gallery">
                    </div>
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('assets/frontend');?>/images/gallery8.jpg" class="gallery fancybox" href="<?php echo base_url('assets/frontend');?>/images/gallery8.jpg" data-fancybox-group="gallery">
                    </div>
                        
                </div>
            </div>
        </div>
    </section>

    <?php require('resources/includes/footer.php'); ?>

    <script type="text/javascript" src="<?php echo base_url('assets/frontend');?>/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/frontend');?>/js/fancybox/source/jquery.fancybox.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend');?>/js/fancybox/source/jquery.fancybox.css" media="screen" />
    <script>
        $(document).ready(function(){
               $('.fancybox').fancybox({
                    padding: 0
                    , openEffect: 'elastic'
                    , openSpeed: 150
                    , closeEffect: 'elastic'
                    , closeSpeed: 150
                    , closeClick: true
                    , helpers: {
                        overlay: null
                    }
                });
        });
    </script>
</body>

</html>