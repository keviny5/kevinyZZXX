<?php

/**
 * Configuration to access the database
 */
$host = 'htbdbl01.gain.tcprod.local';
$user = 'trafficdbuser';
$pass = '9$9c8DdE';
$name = 'htb_smartq';

/**
 * Open the connection so that we can query the database
 */
$conn = mysql_connect($host, $user, $pass);
$temp = mysql_select_db($name, $conn);