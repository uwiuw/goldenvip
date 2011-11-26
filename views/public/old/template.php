<!-- header -->
	<?php $this->load->view('public/old/header'); ?>
	<div class="content">
		<!-- page content -->
        <?php $this->load->view('public/old/page/'.$page); ?>
	</div>
	<div class="clear"></div>
	<div id="footer">
		<!-- footer area -->
        <?php $this->load->view('public/old/footer'); ?>
	</div>
</body>
</html>
