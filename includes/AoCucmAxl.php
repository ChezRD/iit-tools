<?php
/**
 * Created by PhpStorm.
 * User: sloan58
 * Date: 5/22/14
 * Time: 1:05 PM
 */

class AoCucmAxl {

    public  $_client;

    /**
     * @var type $_client The SoapClient Object created with the CUCM AXL WSDL
     */
    public function __construct()
    {
        $this->_client = new SoapClient("../includes/7.0/AXLAPI.wsdl",
            array(
                'trace'=>1,
                'exceptions'=>true,
                //'cache_wsdl' => WSDL_CACHE_NONE,
                'location'=>"https://10.132.10.10:8443/axl/",
                'login'=>'sloanma',
                'password'=>'$l0whanD58',
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

    public function executeSql($type,$statement)
    {

        $type = 'executeSQL' . $type;

        try {
            return $this->_client->$type(array('sql' => $statement));

        } catch (SoapFault $E) { return $this->SoapError($E); }

    }
}

