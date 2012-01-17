<p> &Colon; Mail settings </p>
<script type="text/javascript">
    function simpan_alamat_email(){
        send_form(document.alamat_email,"_admin/mail_settings/simpan_alamat_email",'#info-saving');
        jQuery('#info-saving').addClass('update-nag');
    }
</script>
<form name="alamat_email">
    <table>
        <tr>
            <td>Mega Travel Insurance :</td>
            <td>
                <input type="text" name="mega" value="<?php echo $email[1]['email']; ?>" />
                <input type="hidden" name="idmega" value="mega" />
            </td>
        </tr>
        <tr>
            <td>Golden VIP :</td>
            <td>
                <input type="text" name="golden" value="<?php echo $email[0]['email']; ?>" />
                <input type="hidden" name="id" value="golden"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="button" value="Save" class="button" onclick="simpan_alamat_email()"  />
            </td>
        </tr>
    </table>
</form>
