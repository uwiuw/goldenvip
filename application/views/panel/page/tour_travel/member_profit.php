<script type="text/javascript">
    function show_member_profit()
    {
        selected_val = jQuery("#package").val();
        send_form(document.selected_package,"_admin/tour_travel/selected_profit_member", "#view-data");
    }
</script>
<style>
    #member-profit{
        border: 1px solid #CCCCCC;
        margin-top: 20px;
        margin-bottom: 20px;
        padding: 10px;
    }
</style>
<div id="member-profit">
    <strong>Member Profit</strong>
    <form name="selected_package">
    <table cellspacing="1" cellpadding="0">
            <tbody>
            <tr class="odd">
                    <td>Select Member Profit from Package :</td>
                <td>
                    <?php
                        $id = "id='package'";
                        $data = array(""=>"-- Selected --","1"=>"Travel","2"=>"VIP");
                        echo form_dropdown('package',$data,'',$id);
                    ?>
                    <input type="button" onclick="show_member_profit();" value="Show">
                </td>
            </tr>
            </tbody>
    </table> 
    <input type="hidden" value="1" name="vip">
    <input type="hidden" value="3" name="cat">
    
    </form>
</div>

<div id="view-data"></div>