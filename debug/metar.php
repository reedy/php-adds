<?php

$station = $argv[1];

$metar = file_get_contents( "https://aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString=$station&hoursBeforeNow=1" );
$matches = array();
$res = preg_match( "/\<raw_text\>(.*?)\<\/raw_text\>/im", $metar, $matches );
var_dump( $matches[1] );
