<?php

error_reporting(E_ERROR);

require_once "../includes/functions.php";
require_once "../includes/IpPhoneApi.php";
require_once "../includes/AxlRisApi.php";
require_once "../includes/mySqlDb.php";
require_once "../includes/KLogger.php";
require_once "../includes/AoCucmAxl.php";
require '../vendor/autoload.php';

use Guzzle\Http\Client;


/*
 * Instantiate Objects
 */
$axl = new AoCucmAxl('192.168.158.10','8443');
$risClient = new AxlRisApi('ao-ucmpub.usc.ao.dcn');
$mySql = database::MySqlConnection();
$guzzle = new Client();

$results = $axl->executeSql('query','SELECT first 2000 name FROM device WHERE tkmodel = 437 AND name LIKE "SEP%"');

$count = 1;
foreach ($results->return->row as $i)
{
    $phoneList[] = $i;
}

foreach ((array_chunk($phoneList,1000)) as $k => $v)
{
    foreach ($v as $l => $m)
    {
        var_dump($m->name); print_r($count);
        $count++;
    }
}

/*
foreach ($phoneList as $phone)
{
    $klogger = new KLogger("../Logs/Firmware",KLogger::DEBUG);

    /*
     * Get the IP of the phone we're going to dial
     */
    /*
    $ip = $risClient->getDeviceIp($phone->name);

    if ($ip)
    {
        print_r($phone->name);
        var_dump($ip);
    }

    //$klogger->logInfo("IP for $phone", $ip);

}
*/