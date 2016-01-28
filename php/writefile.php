<?php
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();
	
$myFile = '../xml/'.$_GET['file_name'];
$fh = fopen($myFile, 'a+') or die("can't open file");
$stringData = $_GET['fld_name'] . '=' . $_GET['fld_value'] . "\r\n";
fwrite($fh, $stringData);
fclose($fh);



?>
