<?php

$station = $argv[1];

$taf = file_get_contents( "https://aviationweather.gov/adds/dataserver_current/httpparam?dataSource=tafs&requestType=retrieve&format=xml&stationString=$station&hoursBeforeNow=1" );
$matches = array();
$res = preg_match( "/\<raw_text\>(.*?)\<\/raw_text\>/im", $taf, $matches );
var_dump( $matches[1] );
