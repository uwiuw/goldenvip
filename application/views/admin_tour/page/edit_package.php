<script type="text/javascript">
    jQuery(function(){
        // start upload
        var btnUpload=$('#upload');
        var status=$('#erroritienary');
        new AjaxUpload(btnUpload, {
                action: '<?php echo site_url('admin-tour/package-management/do-upload-file'); ?>',
                name: 'uploadfile',
                onSubmit: function(file, ext){
                         if (! (ext && /^(pdf|jpg|png|jpeg|gif|doc|docx|zip|rar)$/.test(ext))){ 
            // extension is not allowed 
                                status.text('Only PDF, ZIP, RAR, Doc, Docx, JPG, PNG or GIF files are allowed');
                                return false;
                        }
                        status.text('Please wait for the file being uploaded');
                        document.edit_data_package.submit_photo.disabled = true;
                },
                onComplete: function(file, response){
                        //On completion clear the status
                        //Add uploaded file to list
                       
                        if(response==="success"){
                                document.edit_data_package.submit_photo.disabled = false;
                                jQuery('#filename').val(file);
                                status.text('file has been successfully upload, click btn save to saved itienary changed.');
                        } else{
                                jQuery('#erroritienary').text('file is to large or file is crash');
                        }
                }
        });
        // end upload

    });
    
    function validate_rate()
    {
        rate = document.getElementById('published_rate').value;
        if(isNaN(rate))
        {
            alert('Published rate is not a number!');
        }
        rate = document.getElementById('retail_rate').value;
        if(isNaN(rate))
        {
            alert('Retail rate is not a number!');
        }
    }
</script>
<div class="content-admin-right">
    <div class="tx-rwadminhotelmlm-pi1 isi-content-admin-tour">
        <?php if(isset($info))echo "<div class=\"error\">".$info."</div>" ?>
        
        <form action="<?php echo site_url('admin-tour/update_data_package'); ?>" method="POST" name="edit_data_package" id="edit_data_package"  enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="0" border="0" class="tablesorter" id="tablesorter-demo">
                <tbody>
                    <tr class="even">
                        <td>Package</td>
                        <td>
                            <input type="text" id="package" value="<?php echo $package['nama']; ?>" name="package">
                            <input type="hidden" name="uid" value="<?php echo $package['uid']; ?>" />
                            <input type="hidden" name="p" value="<?php echo $p; ?>" />
                        </td>
                        <td>
                            <div style="color: red;" id="errorCat"></div>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>Published Rate</td>
                        <td><input type="text" name="published_rate" id="published_rate" value="<?php echo $package['harga']; ?>" onchange="validate_rate();">&nbsp;USD (Just Number)</td>
                        <td>
                            <div style="color: red;" id="errorRate"></div>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>Retail Rate</td>
                        <td><input type="text" name="retail_rate" id="retail_rate" value="<?php echo $package['retail_rate']; ?>" onchange="validate_rate();" readonly="readonly" />&nbsp;USD (Just Number)</td>
                        <td>
                            <div style="color: red;" id="errorRate"></div>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>Destination</td>
                        <td>
                            <?php echo form_dropdown('destination',$destination,$package['destination']); ?>
                        </td>
                        <td>
                            <div style="color: red;" id="errorstok"></div>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>Description</td>
                        <td>
                            <textarea id="description" rows="10" cols="40" name="description"><?php echo $package['deskripsi']; ?></textarea>
                        </td>
                        <td>
                            <div style="color: red;" id="errorFacilities"></div>
                        </td>
                    </tr>
                 <tr class="old">
                    <td>Itienary</td>
                    <td>
                        <input type="button" value="Browse file for itienary this package" id="upload">
                        <input type="hidden" id="filename" name="filename">
                    </td>
                    <td>
                        <div style="color: red;" id="erroritienary">
                            File : <a href="<?php echo base_url()."upload/itienary/".$this->session->userdata('id_agen')."/".$package['file'];?>" target="_blank"> <?php echo $package['file'] ; ?> </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <input type="submit" class="et-form-btn" id="submit_photo" name="submit" value="Save" onclick="check_validation();">
            <input type="button" onclick="history.go(-1);" value="Back">
        </form>
    </div>
</div>