<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Date Range Picker</title>
</head>
<?php $temroot = base_url()."asset/style/daterangepicker/"; ?>
<script src="<?php echo $temroot; ?>js/testUserDevice.js" type="text/javascript"></script>
<script src="<?php echo $temroot; ?>js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $temroot; ?>js/ui.datepicker.js"></script>

<link href="<?php echo $temroot; ?>css/demoPages.css" media="screen" rel="Stylesheet" type="text/css" />
<link type="text/css" href="<?php echo $temroot; ?>css/screen.css" media="screen" rel="Stylesheet" />
<!-- the following 2 links are for running this demo page -->
<script type="text/javascript" src="<?php echo $temroot; ?>js/demoScripts.js"></script>
<style type="text/css">
	div.rangePicker { width: 250px; margin: .5em 0;}
	
		.toggleRPpos {
			display: block;
			margin: 20px 0;
		}
		form, fieldset {
		border: 0;
		outline: 0;
		margin: 0;
		padding: 0;
		}
		h3 {
		font-size: 1.3em;
		}
		label, input {
		display: block;
		font-size: 1.2em;
		margin: .2em 0;
		}
		input {
		margin-bottom: 1em;
		}
	</style>
<body>
<form action="#" id="pickerDemoForm">
    <fieldset>
        <h3>Choose A Date Range:</h3>
        <div class="rangePicker futureRange">
            <label for="range1">From:</label>
            <input type="text" name="range1" id="range1" value="mm/dd/yyyy" />
            <label for="range1">To:</label>
            <input type="text" name="range2" name="range2" value="mm/dd/yyyy" />
        </div>
    </fieldset>
</form>
</body>
</html>