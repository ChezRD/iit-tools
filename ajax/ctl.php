<?php

error_reporting(E_ERROR);

require_once "../includes/functions.php";
require_once "../includes/IpPhoneApi.php";
require_once "../includes/AxlRisApi.php";
require_once "../includes/AxlClass.php";
require_once "../includes/mySqlDb.php";
require_once "../includes/KLogger.php";


//$_REQUEST['deviceName'] = "SEP0026CB3B90C9"; // My NIPT 7975

$martyAxl = 'martin sloan';  //My CUCM AXL Account

if (isset($_REQUEST['deviceName']))
{
    /*
     * Sanitize data
     */
    $phone = clean($_REQUEST['deviceName']);

    /*
     * Instantiate Objects
     */
    $axl = new AxlClass('10.179.168.10','8443');
    $risClient = new AxlRisApi('10.179.168.10');
    $klogger = new KLogger("../Logs/CTL/$phone",KLogger::DEBUG);
    $mySql = database::MySqlConnection();

    /*
     * Associate phone to the AXL App user to control
     */
    $response = updateUserDevAssoc($martyAxl,$phone,$axl,$klogger);

    if (is_array($response))
    {
        $klogger->logInfo('There was an error updating the user/device association',$response);
        echo json_encode(array('success' => false,'message' => 'There was an error updating the user/device association', 'code' => '500 Server Error'));
        exit;

    } else { $klogger->logInfo("Updated end user/device association for user '$martyAxl' and device $phone"); }

    /*
     * Get the IP of the phone we're going to dial
     */
    $ip = getDeviceIp($phone,$risClient,$klogger);

    if (is_array($ip))
    {
        $klogger->logInfo('There was an error gathering the device IP address',$ip);
        echo json_encode(array('success' => false,'message' => 'There was an error gathering the device IP address', 'code' => '500 Server Error'));
        exit;
    }
    $klogger->logInfo("Got IP for $phone", $ip);

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
    echo json_encode(array('success' => true,'message' => 'CTL Process Sent', 'code' => '200 OK'));
}