<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>

<?php

//Add Api Token here

$apitoken = "";

$url = 'https://api.hetzner.cloud/v1/servers/';
$options = array('http' => array(
    'method'  => 'GET',
    'header' => 'Authorization: Bearer '.$apitoken
));
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);


$json = json_decode($response);

//echo $response;

$serversarray = $json->{'servers'};

echo "<table>
  <tr>
    <th>Name</th>
    <th>Status</th>
	<th>IPv4</th>
	<th>IPv6</th>
	<th>Created</th>
	<th>Cores</th>
	<th>Memory</th>
	<th>Private IP</th>
	<th>Datacenter</th>
	<th>Datacenter City</th>
	<th>Network zone</th>
	<th>OS</th>
  </tr>";

foreach ($serversarray as &$value) {
	
	
		
    echo "  <tr>
    <td>" . $value->{'name'} . "</td> //VServer Name
    <td>" . $value->{'status'} . "</td> //VServer Status
	<td>" . $value->{'public_net'}->{'ipv4'}->{'ip'} . "</td> //IPv4 Address
 	<td>" . $value->{'public_net'}->{'ipv6'}->{'ip'} . "</td> //IPv6 Address
	<td>" . $value->{'created'} . "</td> //Creation Date
	<td>" . strval($value->{'server_type'}->{'cores'}) . "</td> //VServer Cores
	<td>" . strval($value->{'server_type'}->{'memory'}) . " GB</td> //VServer Memory
	<td>" . $value->{'private_net'}[0]->{'ip'} . "</td> //Private Network IP
	<td>" . $value->{'datacenter'}->{'description'} . "</td> //Datacenter Description
	<td>" . $value->{'datacenter'}->{'location'}->{'city'} . "</td> //Datacenter City
	<td>" . $value->{'datacenter'}->{'location'}->{'network_zone'} . "</td> //Datacenter network zone
	<td>" . $value->{'image'}->{'description'} . "</td> //OS Name
  </tr>";
	
}

echo "</table>";
?>
