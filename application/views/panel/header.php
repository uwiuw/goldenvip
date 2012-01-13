<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/wp/load-styles.css" type="text/css" media="all">
<link rel="stylesheet" id="colors-css" href="<?php echo base_url(); ?>asset/theme/wp/colors-fresh.css" type="text/css" media="all">

<script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/wp/l10n.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/wp/load-scripts_002.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/wp/admin_post.css" type="text/css" media="screen">
<script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/wp/load-scripts.js"></script>
<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>

<!-- home cms -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/lib/jquery-1.6.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/plugin/jquery.elastic.source.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/application.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/ui-lightness/base/jquery.ui.all.css" type="text/css" media="screen"> 
<script src="<?php echo base_url(); ?>asset/js/lib/jquery-ui-1.8.16.custom.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.dialog.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/style/tablesorter/blue.css" type="text/css">
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.tablesorter.min.js"></script>

<script type="text/javascript">
    jQuery(function(){
        jQuery('ul#adminmenu li').click(function(){
            id = jQuery(this).attr('id');
            jQuery('ul#adminmenu li').removeClass('wp-menu-open');
            jQuery('ul#adminmenu li').addClass('wp-menu-close');
            id = 'ul#adminmenu li#'+id;
            jQuery(id).removeClass('wp-menu-close');
            jQuery(id).addClass('wp-menu-open');
        });
    });
    var site = '<?php echo site_url(); ?>';
    var image = "<?php echo base_url(); ?>asset/images/loading.gif";
</script>

