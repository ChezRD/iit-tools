<?php

error_reporting(E_ERROR);

require_once "../includes/functions.php";
require_once "../includes/IpPhoneApi.php";
require_once "../includes/AxlRisApi.php";
require_once "../includes/mySqlDb.php";
require_once "../includes/KLogger.php";


//$_REQUEST['phone'] = "SEP0026CBBEAF4D";
$_REQUEST['phone'] = "SEP0026CB3B90C9";

if (isset($_REQUEST['phone']))
{
    /*
     * Sanitize data
     */
    $phone = clean($_REQUEST['phone']);

    /*
     * Instantiate Objects
     */
    $risClient = new AxlRisApi('192.168.1.120');
    $klogger = new KLogger("../Logs/Dialer/$phone",KLogger::DEBUG);
    $mySql = database::MySqlConnection();

    /*
     * Get the IP of the phone we're going to dial
     */
    //$ip = $risClient->getDeviceIp($phone);
    $ip = "10.132.219.89";
    $klogger->logInfo("IP for $phone", $ip);

    /*
     * Gather patterns to dial
     *
     * Need to create relational table with 'dial-plan ID'
     * then use in the query 'where dialplanid = n
     */
    $res = $mySql->query('SELECT pattern FROM test_plan');

    if ($res->num_rows)
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $testPlan[] = $row;
        }
    }

    /*
     * Iterate patterns
     */
    /*
    foreach ($testPlan as $pattern)
    {
        $res = IpPhoneApi::dial($ip,$pattern['pattern']);
        $klogger->logInfo("Dial Results", $res);

        sleep(5);
        $res = IpPhoneApi::keyPress($ip,"Speaker");
        $klogger->logInfo("End Call Results", $res);
    }
    */

    foreach ($testPlan as $pattern)
    {
        $res = IpPhoneApi::keyPress($ip,"Key:Speaker");

        for ($i=0; $i<strlen($pattern['pattern']); $i++) {

            $res = IpPhoneApi::keyPress($ip,'Key:KeyPad' . $pattern['pattern'][$i]);

        }

        sleep(7);

        $res = IpPhoneApi::keyPress($ip,"Key:Speaker");
    }
}