<!-- header -->
	<?php $this->load->view('member/old/header'); ?>
	<div class="content">
		<!-- page content -->
        <?php $this->load->view('member/old/page/'.$page); ?>
	</div>
	<div class="clear"></div>
	<div id="footer">
		<!-- footer area -->
        <?php $this->load->view('member/old/footer'); ?>
	</div>
    <!-- authentikasi pengguna -->
    <script type="text/javascript">
		jQuery(function(){
				jQuery('#autho').click(
					function(){alert('tesst');});
			});
    </script>
        <div id="info" style="display:none;">
        	<table>
            	<tr>
                	<td colspan="2">Authorized User</td>
                </tr>
            	<tr>
                	<td>Username</td>
                    <td><input type="text" name="user" /></td>
                </tr>
                <tr>
                	<td>Password</td>
                    <td><input type="text" name="pwd" /></td>
                </tr>
                <tr>
                    <td colspan="2" height="40px" align="right"><input type="button" value="Submit" id="autho" /></td>
                </tr>
            </table>
        </div>
    <!-- end of authorized -->
</body>
</html>
