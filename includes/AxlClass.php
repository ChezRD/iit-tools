<?php

require_once "KLogger.php";


/**
 * CustomAxl Class provides access to methods that implement the CUCM
 * AXL API while inserting customer specific business logic.
 * 
 * @author Martin Sloan
 * @copyright (c) 2013, Karma-Tek, LLC
 * @version 0.1
 */
class AxlClass {

    public $_client;
    /**
    * @var type $_client The SoapClient Object created with the CUCM AXL WSDL  
    */
    public function __construct($clusterIp,$port)
    {
    $this->_client = new SoapClient("/var/www/wbg-ipt/includes/AXLAPI.wsdl",
        array(
            'trace'=>1,
            'exceptions'=>true,
            'location'=>"https://$clusterIp:$port/axl/",
            'login'=>'PerlAXLUser',
            'password'=>'Icp7474202#',
        ));
    }
         
/**
 * 
 * @param string $E The SoapError returned from a previous call
 * @return array An array consisting of the SoapError fault string, the previous
 * soap call and the previous soap response.
 */ 
protected $E;
            
    private function SoapError($E) 
    {
        $error = array($E->faultstring, "\n",
            $this->_client->__getLastRequest(), "\n",
            $this->_client->__getLastResponse(), "\n");
        
        return $error;
    }

    public function getVersion()
    {

        try {
            return $this->_client->getCCMVersion();

        } catch (SoapFault $E) { return $this->SoapError($E); }

    }

    public function executeSql($type,$statement)
    {

        $type = 'executeSQL' . $type;

        try {
            return $this->_client->$type(array('sql' => $statement));

        } catch (SoapFault $E) { return $this->SoapError($E); }

    }

    public function getUser($userId)
    {
        try {
            return $this->_client->getUser(array("userid"=> $userId));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }

    public function getPhone($deviceName)
    {
        try {

            return $this->_client->getPhone(array("name"=>$deviceName));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }

    public function getLine($line)
    {
        try {

            return $this->_client->getLine(array('pattern' =>$line,
                'routePartitionName' => 'ALL-DN_pt'));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
    public function addPhone($upi,$deviceName,$primaryDevice,$description,$location,$devicePool,$callingSearchSpace,$presenceGroup,$subscribeCss,$reroutingCss,$line)
    {
        try {

            return $this->_client->addPhone(array('phone'=>array('name'=> $deviceName,
                'description' => $description,
                'product' => "Cisco Unified Client Services Framework",
                'model' => "Cisco Unified Client Services Framework",
                'class' => "Phone",
                'protocol' => "SIP",
                'protocolSide' => "User",
                'callingSearchSpaceName' => $callingSearchSpace,
                'devicePoolName' => $devicePool,
                'locationName' => $location,
                'mediaResourceListName' => '',
                'builtInBridgeStatus' => "Off",
                'packetCaptureMode' => "None",
                'certificateOperation' => "No Pending Operation",
                'deviceMobilityMode' => "Default",
                'useTrustedRelayPoint' => "Default",
                'rfc2833Disabled' => 'f',
                'Unattended Port' => 'f',
                'retryVideoCallAsAudio' => 't',
                'ignorePresentationIndicators' => 'f',
                'mlppIndicationStatus' => 'Off',
                'allowCtiControlFlag' => 't',
                'preemption' => 'Disabled',
                'unattendedPort' => 'f',
                'vendorConfig' => array(
                    'videoCapability' => 't'
                ),
                'requireDtmfReception' => 'f',

                'presenceGroupName' => array(
                    '_' => $presenceGroup
                ),
                'commonPhoneConfigName' => array(
                    '_' => "Standard Common Phone Profile"
                ),
                'phoneTemplateName'=> array(
                    'phoneTemplateName'=>"Standard Client Services Framework"
                ),
                'subscribeCallingSearchSpaceName' => array(
                    '_' => $subscribeCss
                ),
                'rerouteCallingSearchSpaceName' => array(
                    '_' => $reroutingCss
                ),
                'primaryPhoneName' => $primaryDevice,
                'enableExtensionMobility' => 't',
                'securityProfileName' => array(
                    '_' => "Cisco Unified Client Services Framework - Standard SIP Non-Secure"
                ),
                'sipProfileName' => array(
                    '_' => "Jabber SIP Profile"
                ),
                'ownerUserName' => array(
                    '_' => $upi
                ),
                'userlocale' => '',
                    'lines' => array(
		                'line' => $line
                )
            )));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }

    public function updateLicense($upi,$ups,$upc)
    {
        try {

            return $this->_client->updateLicenseCapabilities(array(
                'userid' => $upi,
                'enableUps' => $ups,
                'enableUpc' => $upc
            ));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }

    public function udpateUserGroups($upi,$group)
    {
        try {

            return $this->_client->updateUserGroup(array(
                'name' => $group,
                'addMembers' => array(
                    'member' => array(
                        'userId' => $upi
                    )
                )
            ));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
    public function updateUserDevAssoc($userId,$devices)
    {
        try {

            return $this->_client->updateUser(array(
            'userid' => $userId,
            'associatedDevices' => array(
                'device' => $devices
            ),
        ));
        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
    public function updatePrimaryExtension($userId,$primaryExtension)
    {
        try {

            return $this->_client->updateUser(array(
                'userid' => $userId,
                'primaryExtension' => array(
                    'pattern' => $primaryExtension,
                    'routePartitionName' => 'GLB-INT-PT'
                ),
            ));
        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
    public function disableVideo($device,$xml)
    {
        try {

            return $this->_client->updatePhone(array(
                'name' => $device,
                'vendorConfig' => $xml
            ));
        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
    public function removeDevice($device)
    {
        try {

            return $this->_client->removePhone(array('name' => $device));

        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
    public function updateDeviceDescription($device,$description)
    {
        try {

            return $this->_client->updatePhone(array(
                'name' => $device,
                'description' => $description
            ));
        } catch (SoapFault $E) { return $this->SoapError($E); }
    }
}

