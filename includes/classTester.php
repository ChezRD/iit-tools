<?php

require_once "AoCucmAxl.php";

$axl = new AoCucmAxl('192.168.158.10','8443');

$results = $axl->executeSql('query','SELECT name FROM device WHERE tkmodel = 437');

//print_r("Request:\n");
//var_dump($axl->_client->__getLastRequest());
//print_r("Response:\n");
var_dump($results);