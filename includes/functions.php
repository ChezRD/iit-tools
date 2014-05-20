<?php

//ini_set('display_errors', 'On');
require_once "mySqlDb.php";

function addAdmin($userName,$firstName,$lastName,$role){

    $pass = genPassword(5);

    $connection = database::MySqlConnection();

    if(!$connection->query("INSERT INTO user (username,firstname,lastname,password,fk_role) "
        . "VALUES (\"$userName\",\"$firstName\",\"$lastName\",\"" .md5($pass) . "\",\"" . $role . "\")"))
    {
        //var_dump($connection->error);
    } else { print "<b class=\"text-success\"> Successfully added user: $userName</b></br>"
        . "Their temporary password is: $pass<br/>"
        . "This can be changed under user options.<hr>"; }
}


function updateAdmin($userName,$oldPass,$newPass,$confirmPass){

    if ($newPass != $confirmPass) {
        print '<b class=\"text-error\">The passwords do not match.</b>'
            . '<a href="userOptions.php?username=' . $userName . '"><span class="glyphicon"></span>Try again</a><hr>';
        exit;
    }
    $connection = database::MySqlConnection();

    if(!$connection->query('UPDATE user SET password = "' .md5($newPass) . '" WHERE username = "' . $userName . '"'))
    {
        var_dump($connection->error);

    } else { print "<b class=\"text-success\"> Successfully updated your password</b></br>";}
}

function genPassword ($length = 8)
{
  // given a string length, returns a random password of that length
  $password = "";
  // define possible characters
  $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $i = 0;
  // add random characters to $password until $length is reached
  while ($i < $length) {
    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) {
      $password .= $char;
      $i++;
    }
  }
  return $password;
}

function clean($str, $encode_ent = false) {
    $str = @trim($str);

    if($encode_ent) {
        $str = htmlentities($str);
    }

    if(version_compare(phpversion(),'4.3.0') >= 0) {
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }

        if(@mysql_ping()) {
            $str = mysql_real_escape_string($str);
        } else {
            $str = addslashes($str);
        }
    } else {
        if(!get_magic_quotes_gpc()) {
            $str = addslashes($str);
        }
    }

    return $str;
}

function processCsv($file)
{

    $file['name'] = "csvFiles/" . $file['file']['name'];
    $file['tempName'] = $file['file']['tmp_name'];
    $file['type'] = $file['file']['type'];
    $file['size'] = $file['file']['size'];

    if (validateFile($file)) {

        return  openFile($file['name']);
    }

}

function openFile($file){

    $csv = array();
    $file_handle = fopen($file,'r');

    $count = 0;
    while (!feof($file_handle) ) {
        $row = fgetcsv($file_handle);
        if ($count == 0) {
            $count++;
            continue;
        }
        $csv[] = $row;
    }
    return $csv;
}

function validateFile($file){

    $allowedExts = array("csv");
    $temp = explode(".", $file['name']);
    $extension = end($temp);
    if (((($file["file"]["type"] == "text/csv" || $file["file"]["type"] == "application/octet-stream") )) && in_array($extension, $allowedExts))
    {
        if(move_uploaded_file($file['tempName'],$file['name']))
        {
            return TRUE;
        }
    } else {
        return FALSE;
    }
}

/*
 * Provisioning Functions
 */
function errorResponse($upi,$device,$cluster,$message,$code,$pass_fail,$mySql,$process)
{

    $pass_fail->logInfo("FAIL: UPI $upi - MESSAGE: $message - CODE: $code");
    $mySql->query("INSERT INTO " . $process . "_results (upi,device,cluster,code,message,status,last_updated) VALUES ('$upi','$device','$cluster','$code','$message','FAIL',NOW()) ON DUPLICATE KEY UPDATE device = '$device', cluster = '$cluster', code = '$code', message = '$message', status = 'FAIL', last_updated = NOW()");

    echo json_encode(array('success' => FALSE,'message' => $message, 'code' => $code));
    exit;
}

function validateUpi($upi)
{
    if (!(preg_match('/[0-9]{3,11}/',$upi))){
        return FALSE;
    }
    return TRUE;
}

function getEndUser($upi,$axl,$klogger)
{

    $response = $axl->getUser($upi);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;

}

function getPhone($device,$axl,$klogger)
{

    $response = $axl->getPhone($device);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    if ($response->return->phone)
    {
        return $response->return->phone;
    }
    return FALSE;
}

function addJabber($upi,$primaryDevice,$primaryDeviceObj,$line1,$axl,$klogger)
{

    $description = $primaryDeviceObj->description;
    $location = $primaryDeviceObj->locationName;
    $devicePool = $primaryDeviceObj->devicePoolName->_;
    $callingSearchSpace = $primaryDeviceObj->callingSearchSpaceName->_;
    $presenceGroup = $primaryDeviceObj->presenceGroupName->_;
    $subscribeCss = $primaryDeviceObj->subscribeCallingSearchSpaceName->_;
    $reroutingCss = "GLB-PRESENCE_SUBSCRIBE-CSS";

    $line1->associatedEndusers->enduser->userId = $upi;

    $response =  $axl->addPhone($upi,'CUPC' . $upi,$primaryDevice,$description,$location,$devicePool,$callingSearchSpace,$presenceGroup,$subscribeCss,$reroutingCss,$line1);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;
}

function disableVideoHP($device,$xml,$axl,$klogger)
{

    $response = $axl->disableVideo($device,$xml);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;
}
function updateUserDevAssoc($userId,$jabber,$userObj,$axl,$klogger)
{

    if (!($userObj->return->user->associatedDevices->device))
    {
        $devices[] = $jabber;

    } elseif (is_array($userObj->return->user->associatedDevices->device)) {

        $devices = $userObj->return->user->associatedDevices->device;
        $devices[count($devices)] = $jabber;

    } else {
        $devices[] = $userObj->return->user->associatedDevices->device;
        $devices[count($devices)] = $jabber;
    }

    foreach ($devices as $key => $value){
        if ($value == 'SEP' . $userId) {
            unset($devices[$key]);
        }
    }

    $devices = array_values($devices);

    $response = $axl->updateUserDevAssoc($userId,$devices);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;
}
function updatePrimaryExtension($userId,$primaryExtension,$axl,$klogger)
{

    $response =  $axl->updatePrimaryExtension($userId,$primaryExtension);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;

}
function updateUserLicense($upi,$ups,$upc,$axl,$klogger)
{

    $response =  $axl->updateLicense($upi,$ups,$upc);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;

}

function updateUserGroup($upi,$axl,$klogger)
{

    foreach (array('Standard CTI Allow Control of Phones supporting Rollover Mode','Standard CTI Allow Control of Phones supporting Connected Xfer and conf','Standard CCM End Users','Standard CTI Enabled') as $i)
    {
        $response = $axl->udpateUserGroups($upi,$i);

        $klogger->logInfo("Request",$axl->_client->__getLastRequest());
        $klogger->logInfo("Response",$axl->_client->__getLastResponse());
        $klogger->logInfo("Setting user role $i for $upi");

        if (is_array($response))
        {
            $return[] = $response;
        }
    }
    if (is_array($return))
    {
        return $return;
    }
    return 'No fails';
}

function updateBfcp($deviceName,$axl,$klogger)
{

    $response = $axl->executeSql('update',"UPDATE device SET enablebfcp = 't' WHERE name = '$deviceName'");

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;
}

function removeCipc($device,$axl,$klogger)
{

    $response = $axl->removeDevice($device);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;
}

function checkMAC($primaryDevice)
{

    if (preg_match('/^SEP[0-9a-fA-F]{12}$/', $primaryDevice)){
        return $primaryDevice;

    }

    return '';
}

function setCluster($cluster,$env)
{
    switch(strtoupper($env)) {
        case 'PROD':
            switch (strtoupper($cluster)) {
                case 'WAS':
                    $clusterIps = array('10.178.8.1','127.0.0.1','127.0.0.1');
                    $ports = array('8443','9110','9111');
                    return array($clusterIps,$ports);
                case 'CDG':  //10.138.184.1
                    $clusterIps = array('127.0.0.1','127.0.0.1','10.178.8.1');
                    $ports = array('9110','9111','8443');
                    return array($clusterIps,$ports);
                case 'MAA':  //10.138.200.1
                    $clusterIps = array('127.0.0.1','127.0.0.1','10.178.8.1');
                    $ports = array('9111','9110','8443');
                    return array($clusterIps,$ports);
                default:
                    return false;
            }
            break;
        case 'DEV':
            switch (strtoupper($cluster)) {
                case 'WAS':
                    $clusterIps = array('192.168.158.10','192.168.1.120');
                    $ports = array('8443','8443');
                    return array($clusterIps,$ports);
                    break;
                case 'CDG':
                    $clusterIps = array('192.168.1.120','192.168.158.10');
                    $ports = array('8443','8443');
                    return array($clusterIps,$ports);
                    break;
                default:
                    echo json_encode(array('success' => false,'message' => 'Cluster ID is Invalid'));
            }
        default:
            return false;
    }

}

function updateDescription($device,$description,$axl,$klogger)
{

    $response = $axl->updateDeviceDescription($device,$description);

    $klogger->logInfo("Request",$axl->_client->__getLastRequest());
    $klogger->logInfo("Response",$axl->_client->__getLastResponse());

    return $response;
}
function clearMySqlTable($table)
{
    $connection = database::MySqlConnection();
    $connection->query("TRUNCATE TABLE $table");
}



