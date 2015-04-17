<?php

// https://aviationweather.gov/adds/dataserver
// http://weather.aero/tools/dataservices/textdataserver

if ( $argc === 1 ) {
        die( "php $argv[0] <Departure Airport> <Destination Airport> [<Alternate>]\n" );
}
//var_dump( $argv ); die ();
echo "Metar/Atis Departure Airport: " . doRequest( "metar", $argv[1] ) . PHP_EOL;
echo "TAF at Destination: " . doRequest( "taf", $argv[2] ) . PHP_EOL;
if ( isset( $argv[3] ) ) {
        echo "TAF at Alternate: " . doRequest( "taf", $argv[3] ) . PHP_EOL;
}

echo "Current Area Analysis/Synopsis: ";
echo "Prognosis for next few hours ";
echo "Sigmets, Airmets and Convective Sigmets:";
echo "Pireps";
echo "Winds, Temps & Freezing Level:";
echo "Notams and TFR:";


function doRequest( $type, $station, $additional = '' ) {
// Use mostrecent
        $url = "https://aviationweather.gov/adds/dataserver_current/httpparam?dataSource={$type}s&requestType=retrieve&format=xml&stationString=$station&hoursBeforeNow=1";
        if ( $additional ) {
                $url .= "&" . $additional
        }
        $item = file_get_contents( $url );

        $matches = array();
        preg_match( "/\<raw_text\>(.*?)\<\/raw_text\>/im", $item, $matches );
        return $matches[1];
}
