<?php
session_start();
header("Cache-control: private");
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();
	
//date_default_timezone_set('UTC');

$current_time = date('l dS \of F Y h:i:s A');
$http_passin_param1	= $_GET['company_code'];
$http_passin_param2 = $_GET['job_code'];
$http_passin_param3	= "12000";
$http_passin_param4 = "'".$_GET['info1']."'"; 
$http_passin_param5 = "'".$_GET['info2']."'"; 
$http_passin_param6 = "'".$_GET['info3']."'"; 
$http_passin_param7 = "'".$_GET['info4']."'"; 
$http_passin_param8 = "'".$_GET['info5']."'"; 
$http_passin_param9 = $_SERVER['REMOTE_ADDR'];

$address = '127.0.0.1';
//$port = 12000;


//alter header for XML output
header("Content-Type: text/xml");

// begin XML root tag
echo("<root>");

/*
if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} 

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
} 

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
} 
*/


/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '127.0.0.1';

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "<br>";
}

if (socket_bind($sock, $address) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "<br>";
}

if (socket_getsockname($sock, $host, $port) === false) {
    echo "socket_getsockname() failed: reason: " . socket_strerror(socket_last_error($sock)) . "<br>";
}
if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "<br>";
}

echo("<port>");
echo ($port);
echo ("</port>");
$system_param = 'web_portal'.' '.$http_passin_param1.' '.$http_passin_param2.' '.$port.' '.$http_passin_param4.' '
				.$http_passin_param5.' '.$http_passin_param6.' '.$http_passin_param7.' '.$http_passin_param8.' '.$http_passin_param9;
				
if (false === ($rst = system($system_param, $retval))) {
	echo "Fail to excute PRO5 test".$retval;
}


do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }

    do {
        if (false === ($buf = socket_read($msgsock, 4096, PHP_NORMAL_READ))) {
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == 'quit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            break 2;
        }
        echo "$buf\r\n";       
       
    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);

$current_time = date('l dS \of F Y h:i:s A');

// close root tag of XML
echo ("</root>");
?>

