<?php

$client = new SoapClient('https://192.168.1.120:8443/CDRonDemandService/services/CDRonDemand?wsdl',
    array('trace'=>true,
        'exceptions'=>true,
        'location'=>'https://192.168.1.120:8443/CDRonDemandService/services/CDRonDemand',
        'login'=>'admin',
        'password'=>'ci5co123',
    ));

$res = $client->get_file_list('201405191800','201405191900',true);

print_r($client->__getLastRequest());

//print_r($client->__getFunctions());