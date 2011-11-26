<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Production Engine For MLM Management</title>
</head>
<body>
<?php
	# get leaf left
	# get_leaf('106');
?>
<pre>
<?php
/*
	bedanya anatar upline ama sponsor :
	sponsor :
	a. dia bisa ad di sembarang titik
	upline	:
	a. upline selalu berada diatas downline
	b. jika upline tidak mempunyai downline maka ia akan menjadi titik terakhir dari daun.
*/
	#print_r($geneology);
	echo "Sponsor "; 
	$s = getMemberByUid($sponsor);
	print_r($s);
	echo "direct ";
	foreach($geneology['kanan'] as $row=>$key)
	{
		$member = getMemberByUid($key['uid']);
		print_r($member);
	}
	echo "<br />";
	foreach($geneology['kiri'] as $row=>$key)
	{
		$member = getMemberByUid($key['uid']);
		print_r($member);
	}
?>
</pre>
</body>
</html>