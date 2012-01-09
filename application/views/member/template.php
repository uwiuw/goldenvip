<!-- header -->
	<?php $this->load->view('member/header'); ?>
	<div id="halaman1" class="content display-none">
		<!-- page content -->
        <?php $this->load->view('member/'.$page); ?>
	</div>
        <div id="halaman2" class="content">
            <?php $this->load->view('member/enablejavascript'); ?>
        </div>
	<div class="clear"></div>
	<div id="footer">
		<!-- footer area -->
        <?php $this->load->view('member/footer'); ?>
	</div>
    <!-- authentikasi pengguna -->
    <script type="text/javascript">
		jQuery(function(){
				jQuery('#autho').click(
					function(){alert('tesst');});
			});
    </script>
        
</body>
</html>
