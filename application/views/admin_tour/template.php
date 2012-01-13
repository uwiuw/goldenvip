<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/admin-hotel.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/wp/public.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/old-site/js/jquery-1.4.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/old-site/js/ajaxupload.3.5.js"></script>
        <link type="text/css" href="<?php echo base_url(); ?>asset/admin_hotel/styleTableSorter1.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/tablesorter/blue.css" type="text/css"/>
        <script src="<?php echo base_url(); ?>asset/js/plugin/jquery.tablesorter.min.js"></script>
        <link type="text/css" href="<?php echo base_url(); ?>asset/admin_hotel/style.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url(); ?>asset/admin_hotel/form.css" rel="stylesheet" />
        
        <script type="text/javascript" src="<?php echo base_url(); ?>asset/admin_hotel/jquery.js"></script>
        <script type="text/javascript">
            $(function() {
                jQuery("#myTable").tablesorter();
                jQuery('#myTable tbody tr:odd').addClass('odd');
            });
        </script>
    </head>
    <body>
        <?php 
            if($this->session->userdata('admin-tour')=='aktif'):
                $this->load->view('admin_tour/header');
            else:
                $this->load->view('public/old/header');
            endif;
        ?>
        <?php 
            $this->load->view('admin_tour/page/'.$page);
            if($this->session->userdata('admin-tour')=='aktif'):
                echo "  </div>
                        </div>
                        <div id=\"admin-hotel-bottom\"></div>
                        </div>
                        </div>";
            endif;
        ?>
        <?php $this->load->view('admin_tour/footer'); ?>
    </body>
    
</html>