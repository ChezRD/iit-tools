<?php
/**
 * Created by PhpStorm.
 * User: sloan58
 * Date: 5/19/14
 * Time: 8:11 PM
 */

class IpPhoneApi {

    public $ip;
    public $key;

    public function __construct()
    {

    }

    public static function keyPress($ip,$url)
    {
        $xml = 'XML=<CiscoIPPhoneExecute><ExecuteItem Priority="0" URL="' . $url . '"/></CiscoIPPhoneExecute>';

        $ch = curl_init('http://' . $ip . '/CGI/Execute');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        //curl_setopt($ch, CURLOPT_USERPWD, 'risadmin' . ":" . 'ci5co123');
        curl_setopt($ch, CURLOPT_USERPWD, 'sloanma' . ":" . '$l0whanD58');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public static function dial($ip,$pattern)
    {

        $xml = 'XML=<CiscoIPPhoneExecute><ExecuteItem URL="Dial:' . $pattern . '"/></CiscoIPPhoneExecute>';
        var_dump($xml);
        $ch = curl_init('http://' . $ip . '/CGI/Execute');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_USERPWD, 'risadmin' . ":" . 'ci5co123');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
} 