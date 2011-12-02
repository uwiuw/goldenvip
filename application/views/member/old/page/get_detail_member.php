<div class="container">
  <div id="show-ctn-member">
    <div class="tx-rwmembermlm-pi1">
        <div id="home-office" class="sponsor">
            <div id="home-top">
                <h2>Members Request</h2>
            </div>
            <div id="home-bottom">
                <div class="csc-textpic-text">
               
                        <table class="tablesorter" id="tablesorter" border="0" cellpadding="0" cellspacing="1">
                            <tbody>
                                <tr class="even">
                                    <td width="200px"><strong>Create Date</strong></td>
                                    <td><strong><?php echo date('Y-m-d H:i:s',$member['crdate']); ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Package</strong></td>
                                    <td><strong><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','package',$member['package'],'uid'); echo $d['package']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>First Name</strong></td>
                                    <td><strong><?php echo $member['firstname']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Last Name</strong></td>
                                    <td><strong><?php echo $member['lastname']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>DOB</strong></td>
                                    <td><strong><?php echo $member['dob']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Email</strong></td>
                                    <td><strong><?php echo $member['email']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>Username</strong></td>
                                    <td><strong><?php echo $member['username']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Country</strong></td>
                                    <td><strong><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_phonecountrycode','country',$member['country'],'uid'); echo $d['country']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>Home/Office Phone</strong></td>
                                    <td><strong><?php echo $member['homephone']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Mobile/Cellular Phone</strong></td>
                                    <td><strong><?php echo $member['mobilephone']; ?></strong></td>
                                </tr>
                                <tr id="disp_province" class="even">
                                    <td width="200px"><strong>State/Province</strong></td>
                                    <td id="disp_option1"><strong><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_province','province',$member['province'],'uid'); echo $d['province']; ?></strong></td>
                                </tr>
                                <tr id="disp_city" class="odd">
                                    <td width="200px"><strong>City</strong></td>
                                    <td><strong><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$member['city'],'uid'); echo $d['city']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>Street Address</strong></td>
                                    <td><strong><?php echo $member['address']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Regional</strong></td>
                                    <td><strong><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$member['regional'],'uid'); echo $d['city']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>Bank Account Number</strong></td>
                                    <td><strong><?php echo $member['bank_account_number']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Bank Name</strong></td>
                                    <td><strong><?php echo $member['bank_name']; ?></strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="200px"><strong>Name On Bank Account</strong></td>
                                    <td><strong><?php echo $member['name_on_bank_account']; ?></strong></td>
                                </tr>
                                <tr class="odd">
                                    <td width="200px"><strong>Voucher Code</strong></td>
                                    <td><strong><?php echo $member['voucher_code']; ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="clear"></div>
    </div>