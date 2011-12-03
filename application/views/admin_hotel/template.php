<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
        <base href="<?php echo $asset_url; ?>/" />
        <script src="<?php echo $asset_url; ?>/js/javascript_b9328db19d.js?" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo $asset_url; ?>/style/admin-hotel.css" type="text/css">
    </head>
    <body>
        <?php $this->load->view('admin_hotel/header'); ?>
        <?php $this->load->view('admin_hotel/page/' . $page); ?>
        <?php $this->load->view('admin_hotel/footer'); ?>
    </body>
</html>