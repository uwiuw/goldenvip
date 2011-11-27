<?php $this->load->view('public/header'); ?>
<div id="content">
	<?php  $this->load->view('public/page/'.$page); ?>
</div>

<div id="foot">
	<?php if($nav=='homepage') { ?>
	<div id="testimonial-user">
		<?php $this->load->view('public/page/testimonial-user'); ?>
    </div>
    <?php } ?>
	<?php $this->load->view('public/footer'); ?>
</div>

</body>
</html>
