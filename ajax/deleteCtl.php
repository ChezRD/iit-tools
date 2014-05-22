<?php

error_reporting(E_ERROR);

require_once "../includes/functions.php";
require_once "../includes/IpPhoneApi.php";
require_once "../includes/AxlRisApi.php";
require_once "../includes/mySqlDb.php";
require_once "../includes/KLogger.php";


//$_REQUEST['phone'] = "SEP0026CBBEAF4D"; // Home Lab 7965
//$_REQUEST['phone'] = "SEP0026CB3B90C9"; // My AO 7975
$_REQUEST['phone'] = "SEP00260BD92402"; // Mindy's AO 7975

if (isset($_REQUEST['phone']))
{
    /*
     * Sanitize data
     */
    $phone = clean($_REQUEST['phone']);

    /*
     * Instantiate Objects
     */
    $risClient = new AxlRisApi('ao-ucmpub.usc.ao.dcn');
    $klogger = new KLogger("../Logs/CTL/$phone",KLogger::DEBUG);
    $mySql = database::MySqlConnection();

    /*
     * Get the IP of the phone we're going to dial
     */
    $ip = $risClient->getDeviceIp($phone);
    $klogger->logInfo("IP for $phone", $ip);

    /*
     * Set keys to delete CTL (7975)
     */

    $url = [

        'Key:Services',
        'Key:Settings',
        'Key:KeyPad4',
        'Key:KeyPad5',
        'Key:KeyPad1',
        'Key:Soft5',
        'Key:KeyPadStar',
        'Key:KeyPadStar',
        'Key:KeyPadPound',
        'Key:Soft5',
        'Init:Services'
    ];

    /*
     * Press keys
     */
    foreach ($url as $k)
    {

        $res = IpPhoneApi::keyPress($ip,$k);
        $klogger->logInfo("Result", $res);

        $k == "Key:KeyPadPound" ? sleep(2) : '';

    }
}