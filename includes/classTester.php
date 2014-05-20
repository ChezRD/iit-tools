<?php

require_once "AxlClass.php";

$axl = new AxlClass('192.168.158.10','8443');

$results = $axl->getPhone('SEP123456789123');

//print_r("Request:\n");
//var_dump($axl->_client->__getLastRequest());
//print_r("Response:\n");
var_dump($results);