jQuery(document).ready(function(){    
    jQuery("textarea#address").focus(function(){
        var val = jQuery("#address").val();
        
        if(val=='Completely your address') {jQuery("#address").val('')};
    });
    jQuery("textarea#address").blur(function(){
        var val = jQuery("#address").val();
        if( val=='' ) {jQuery("#address").val('Completely your address')};
    });    
    
    //TOOL TIPS
    jQuery("p[name^=tips]").hover(function(){
        var el_id = jQuery(this).attr('id').substring(5,jQuery(this).attr('id').length);
        var ctn = jQuery("#ctn_" +  el_id).html();        
        jQuery("#tips_" + el_id).simpletip({
            content : ctn,
            position: 'bottom'                        
        });    
        
    });
    
    //jQuery("#tips_1").simpletip();
    
   /* jQuery("#myTable").tablesorter({                     
        useUI: true,
        widgets: ['zebra']                                                              
    }); */
    
    function clearLabelError(){
        jQuery("#error_firstname").text("")
        jQuery("#error_lastname").text("");
        jQuery("#error_dob").text("");
        jQuery("#error_email").text("");
        jQuery("#error_username").text("");
        jQuery("#error_password1").text("");
        jQuery("#error_password2").text("");
        jQuery("#error_country").text("");
        jQuery("#error_homephone").text("");
        jQuery("#error_mobilephone").text("");
        jQuery("#error_province").text("");
        jQuery("#error_city").text("");
        jQuery("#error_address").text("");
        jQuery("#error_regional").text("");
        jQuery("#error_pack").text(""); 
        jQuery("#error_bank_account_number").text("");
        jQuery("#error_bank_name").text("");
        jQuery("#error_name_on_bank_account").text("");
		jQuery("#error_distributor").text("");
		jQuery("#error_voucher").text("");
		jQuery("#error_placement").text("");
    }    
    
    //ALPHANUMERIC VALIDATION
    //jQuery("#username").alphanumeric();
    
    //SUBMIT REGISTRATION FORM 1            
    jQuery("#submitreg1").click(function(){
        var pid = jQuery("#pid").val(); 
        var firstname = jQuery.trim(jQuery("#firstname").val());
        var lastname = jQuery.trim(jQuery("#lastname").val());
        var d = jQuery("#d option:selected").val();
        var m = jQuery("#m option:selected").val();
        var y = jQuery("#y option:selected").val();
        var email = jQuery("#email").val();
        var username = jQuery("#username").val();
        var password1 = jQuery("#password1").val();
        var password2 = jQuery("#password2").val();
        var country = jQuery("#country option:selected").val();
        var homephone = jQuery("#homephone").val();
        var mobilephone = jQuery("#mobilephone").val();
        var province = jQuery("#province option:selected").val();
        var city = jQuery("#city option:selected").val();
        var address = jQuery("#address").val();
        var regional = jQuery("#regional option:selected").val();
		var distributor = jQuery("#distributor option:selected").val();
        var pack =   jQuery("#package option:selected").val();
		var voucher = jQuery("#voucher").val();
		var placement = jQuery("#placement option:selected").val();
		
        //INFORMATION BANK        
        var bank_account_number = jQuery("#bank_account_number").val();   
        //var bank_name = jQuery.trim(jQuery("#bank_name").val());
        var bank_name = jQuery("#bank_name option:selected").val();
        var name_on_bank_account = jQuery("#name_on_bank_account").val();
                
        //alert(!jQuery("#agree").is(':checked'));
                                
        //START VALIDATION 
        clearLabelError();                
       
        if(!firstname){        
            jQuery("#error_firstname").text("can't be empty");
            return false;
        }
        if(!lastname){        
            jQuery("#error_lastname").text("can't be empty");
            return false;
        }
        if(!d || !m || !y){
            jQuery("#error_dob").text("not valid");
            return false;
        }
		
        var emailFilter=/^.+@.+\..{2,3}$/;
        if(!(emailFilter.test(email))){
            jQuery("#error_email").text("not valid");
            return false;
        }
		
        
        if(!username){        
            jQuery("#error_username").text("can't be empty");
            return false;
        }
        if(username.length < 4){        
            jQuery("#error_username").text("length > 3 caracters");
            return false;
        }  
        if(!password1){        
            jQuery("#error_password1").text("can't be empty");
            return false;
        }
        if(password1.length < 6){
            jQuery("#error_password1").text("length > 5 caracters");
            return false;
        }
        if(!password2){        
            jQuery("#error_password2").text("can't be empty");
            return false;
        }
        if(password1 != password2){        
            jQuery("#error_password2").text("not valid");
            return false;
        }
        if(!country){
            jQuery("#error_country").text("can't be empty");
            return false;
        }
        if(!mobilephone){
            jQuery("#error_mobilephone").text("can't be empty");
            return false;
        }
        if(!province){
            jQuery("#error_province").text("can't be empty");
            return false;
        }
        if(!city){
            jQuery("#error_city").text("can't be empty");
            return false;
        }        
        if(!address){
            jQuery("#error_address").text("can't be empty");
            return false;
        }
        if(!regional){
            jQuery("#error_regional").text("can't be empty");
            return false;
        }
		 
		
		if(!voucher)
		{
			jQuery("#error_voucher").text("can't be empty");
            return false;
		}
		
        if(!pack){
            jQuery("#error_pack").text("can't be empty");
            return false;
        }
		
		 if(!placement){
            jQuery("#error_placement").text("can't be empty");
            return false;
        }
        //INFORMATION OF BANK
		
		if(!bank_name){
            jQuery("#error_bank_name").text("can't be empty");
            return false;
        }
		
        if(!bank_account_number){
            jQuery("#error_bank_account_number").text("can't be empty");
            return false;
        }
        
        if(!name_on_bank_account){
            jQuery("#error_name_on_bank_account").text("can't be empty");
            return false;
        } 
        
        if(!jQuery("#agree").is(':checked')){
            jQuery("#error_agree").text("Please agree term & conditions");
            return false;
        }
       
        //END VALIDATION   
		return true;            
    });    
})