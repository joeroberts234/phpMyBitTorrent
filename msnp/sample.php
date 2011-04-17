<?php
	ob_implicit_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>MSN Protocol 9 Class Example Usage</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript"></script>
    <style type="text/css" media="screen" title="default">
	body {
		font: 76%/1.4 tahoma, verdana, arial, helvetica, sans-serif;
	}
	.r {
		color: red;
	}
	.g {
		color: green;
	}
    </style>
  </head>
  <body>



<?php


	include('msnp9.class.php');
	include('msn_sb.class.php');

	$msn = new msn;

	if ($msn->connect('joeroberts234@hotmail.com', 'LESLIE30'))
	{
		// we're connected
		// run rx_data function to 'idle' on the network
		// rx_state will loop until the connection is dropped

		$msn->rx_data();

		echo '<p>Connection dropped</p>';
	}
	else
	{
		// wrong username and password?
		echo '<p>Error Connecting to the MSN Network</p>';
	}


?>



  </body>
</html>
