<?php
/**
 * Created by PhpStorm.
 * User: sloan58
 * Date: 5/19/14
 * Time: 8:22 PM
 */

class AxlRisApi {

    public $_client;
    protected $E;

    public function __construct($ip)
    {
        $this->_client = new SoapClient('../includes/Cucm85RIS.wsdl',
            array('trace'=>true,
                'exceptions'=>true,
                'location'=>'https://' . $ip . ':8443/realtimeservice/services/RisPort',
                'login'=>'admin',
                'password'=>'ci5co123',
            ));
    }

    private function SoapError($E)
    {
        $error = array($E->faultstring, "\n",
            $this->_client->__getLastRequest(), "\n",
            $this->_client->__getLastResponse(), "\n");

        return $error;
    }

    public function getDeviceIp($phone)
    {
        $SelectItems = array(array('Item'=> $phone));

        $CmSelectionCriteria = array('MaxReturnedDevices'=>'1',
            'Class'=>'Phone',
            'Model'=>'255',
            'Status'=>'Registered',
            'NodeName'=>'',
            'SelectBy'=>'Name',
            'SelectItems'=> $SelectItems);

        try {

            $response = $this->_client->SelectCmDevice('',$CmSelectionCriteria);

        } catch (SoapFault $E) { return $this->SoapError($E); }

        $SelectCmDeviceResult = $response["SelectCmDeviceResult"];

        if ($SelectCmDeviceResult->TotalDevicesFound = 1) {

            return $SelectCmDeviceResult->CmNodes[0]->CmDevices[0]->IpAddress;

        } else { return false; }
    }
}