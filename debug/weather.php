<?php

// https://aviationweather.gov/adds/dataserver
// http://weather.aero/tools/dataservices/textdataserver

if ( $argc === 1 ) {
        die( "php $argv[0] <Departure Airport> <Destination Airport> [<Alternate>]\n" );
}
//var_dump( $argv ); die ();
echo "Metar/Atis Departure Airport: " . doMETAR( $argv[1] ) . PHP_EOL;
echo "TAF at Destination: " . doTAF( $argv[2] ) . PHP_EOL;
if ( isset( $argv[3] ) ) {
        echo "TAF at Alternate: " . doTAF( $argv[3] ) . PHP_EOL;
}

//echo "Current Area Analysis/Synopsis: " . PHP_EOL;
//echo "Prognosis for next few hours: " . PHP_EOL;
//echo "Sigmets, Airmets and Convective Sigmets: " . PHP_EOL;
echo "Pireps: " . PHP_EOL;
echo doPIREP( $argv[1], $argv[2] );
//echo "Winds, Temps & Freezing Level: " . PHP_EOL;
//echo "Notams and TFR: " . PHP_EOL;

function doTAF( $station ) {
        return doSimpleRequest( "taf", $station );
}

function doMETAR( $station ) {
        return doSimpleRequest( "metar", $station );
}

function doPIREP( $from, $to ) {
        $items = doRequest( "pirep", "flightPath=57.5;$from;$to" );
        preg_match_all( "/\<raw_text\>(.*?)\<\/raw_text\>/im", $items, $matches );
        $matches = array();
        $res = '';
        foreach ( $matches as $pirep ) {
                $res .= $pirep[1] . PHP_EOL;
        }
        return $res;
}


function doSimpleRequest( $type, $station ) {
        $item = doRequest( $type, "stationString=$station" );
        $matches = array();
        preg_match( "/\<raw_text\>(.*?)\<\/raw_text\>/im", $item, $matches );
        return $matches[1];
}

function doRequest( $type, $additional = '' ) {
        // Use mostrecent
        $url = "https://aviationweather.gov/adds/dataserver_current/httpparam?dataSource={$type}s&requestType=retrieve&format=xml&hoursBeforeNow=1&$additional";
        return file_get_contents( $url );
}
