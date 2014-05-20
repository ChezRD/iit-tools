<?php

error_reporting(E_ERROR);

require_once "../includes/functions.php";
require_once "../includes/IpPhoneApi.php";
require_once "../includes/AxlRisApi.php";

$_REQUEST['phone'] = "SEP0026CBBEAF4D";

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
    $mySql = database::MySqlConnection();


    $ip = $risClient->getDeviceIp($phone);

    $res = $mySql->query('SELECT pattern FROM test_plan WHERE id = 2');

    if ($res->num_rows)
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $testPlan[] = $row;
        }
    }

    $res = IpPhoneApi::keyPress($ip,"Speaker");

    foreach ($testPlan as $pattern)
    {
        for ($i=0; $i<strlen($pattern['pattern']); $i++) {

            $res = IpPhoneApi::keyPress($ip,'KeyPad' . $pattern['pattern'][$i]);

        }
    }

    sleep(5);

    $res = IpPhoneApi::keyPress($ip,"Speaker");
}