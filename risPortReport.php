<html>
<head>
<title>Risport Report</title>
</head>
<body>
<?php
$client = new SoapClient('includes/Cucm85RIS.wsdl',
			 array('trace'=>true,
			       'exceptions'=>true,
			       'location'=>'https://192.168.1.120:8443/realtimeservice/services/RisPort',
			       'login'=>'admin',
			       'password'=>'ci5co123',
			       ));

$SelectItems = array(array('Item'=>'*')); //select devices with any name, wildcard '*'
// to select multiple items, add additional array elements as below
//$SelectItems = array(array('Item'=>'SEPD0574C6B4EC2'),array('Item'=>'SEPD0574CF73FC0'),array('Item'=>'SEP503DE57D5583'),array('Item'=>'SEP002699EDFD02'));

$CmSelectionCriteria = array('MaxReturnedDevices'=>'1000',
			     'Class'=>'Phone',
			     'Model'=>'255',
			     'Status'=>'Any',
			     'NodeName'=>'',
			     'SelectBy'=>'Name',
			     'SelectItems'=>$SelectItems); //note hardcoded limit of 50 returns, max of 1000 allowed

try {
  $response = $client->SelectCmDevice('',$CmSelectionCriteria); //execute the request;
} catch (Exception $e) {
  echo 'Caught exception: '.$e->getMessage()."\n";
  }

$SelectCmDeviceResult=$response["SelectCmDeviceResult"];//the response is a two element array, we want the element called SelectCmDeviceResult

//uncomment the following lines to dump the actual XML of the request/response
//var_dump($client->__getLastRequest());
//var_dump($client->__getLastResponse());

if ($SelectCmDeviceResult->TotalDevicesFound!=0) {
  echo "Total devices found: ".$SelectCmDeviceResult->TotalDevicesFound;
?>
<table border='1' style='width: 100%'>
<col />
<col />
<col />
<col />
<tbody>
<?php
   foreach ($SelectCmDeviceResult->CmNodes as $node) {
    echo "<tr><td colspan='4' style='background-color:#BFBFBF'>Node: ".$node->Name."</td></tr>";
?>
<tr>
<td style='background-color:#E6E6FA'>Device Name</td>
<td style='background-color:#E6E6FA'>Model</td>
<td style='background-color:#E6E6FA'>Status</td>
<td style='background-color:#E6E6FA'>IP Address</td>
</tr>
<?php
    foreach ($node->CmDevices as $CmDevice) {
      echo "<tr><td>".$CmDevice->Name."</td><td>".$CmDevice->Model."</td><td>".$CmDevice->Status."</td><td>".$CmDevice->IpAddress."</td></tr>";
    }
  }
  echo "</tbody></table>";
} else echo "No devices found";
?>
</body>
</html> 
