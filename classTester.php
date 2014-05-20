<?php

include 'includes/AxlClass.php';


/*
 * Axl Tests
 */

$axl = new AxlClass('192.168.158.10','8443');

$response = $axl->getPhone('SEP019283746574');
//$response = $axl->removeDevice('CUPC387653');

var_dump($response);