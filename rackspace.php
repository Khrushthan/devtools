<?php

set_time_limit(0);

function curl_request($auth_url,$xml_post,$extra_header=array(),$extra_method=''){

	$header_array = array( 
		'Content-Type: application/xml',
		'Accept: application/json',
		'Content-Length: '.strlen($xml_post) 
	);
	
	$final_array = array_merge($header_array,$extra_header);

	
	
//	var_dump($final_array);
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$auth_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post);
	if($extra_method!=''){
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $extra_method);
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER,$final_array);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch);
	
	return $server_output;
}


$auth_url = 'https://lon.identity.api.rackspacecloud.com/v2.0/tokens';
$api_key='f03a31a39a263c1254506097040edd6b';
$api_login='icandeveloper';
$account_number='10040171';
//$service_url='https://lon.loadbalancers.api.rackspacecloud.com/v1.0/'.$account_number.'/';
$service_url='https://lon.loadbalancers.api.rackspacecloud.com/v1.0/'.$account_number.'/';


$zones_url[] = "http://www.ipdeny.com/ipblocks/data/countries/cn.zone";
// $zones_url[] = "http://www.ipdeny.com/ipblocks/data/countries/ua.zone";

echo "Start:<hr>";


$xml_post = '<?xml version="1.0" encoding="UTF-8"?>
<auth>
<apiKeyCredentials
xmlns="http://docs.rackspace.com/identity/api/ext/RAX-KSKEY/v1.0"
username="'.$api_login.'"
apiKey="'.$api_key.'"/>
</auth>';

$server_output = curl_request($auth_url,$xml_post);


$obj = json_decode($server_output);
$new_token  = $obj->access->token->id;

echo "GOT New Token:".$new_token."<br>";



$useful_keys = array('rax:autoscale','rax:monitor','rax:load-balancer','volume');
$useful_services = array();

$services=$obj->access->serviceCatalog;

foreach($services AS $service){

	if( in_array($service->type,$useful_keys) ){
		$useful_services[$service->name] = $service->endpoints[0]->publicURL;
	}

}
// print_r($useful_services);

foreach($useful_services AS $name => $url){
	echo "Service Name: ".$name." URL:[ ".$url."]<br/>\n";
}


echo "<hr/>ZONES DATA:<hr>";
foreach($zones_url AS $zone_url){
	echo "Getting: $zone_url <br/>";
	$content = file_get_contents($zone_url);
	echo "Got IT: $zone_url <br/>";
	// break into separate lines
	$lines = explode("\n",$content);
	echo "Total ".sizeof($lines)." Lines Received <br/>";
	$xml_deny='<accessList xmlns="http://docs.openstack.org/loadbalancers/api/v1.0">';
	foreach($lines AS $line){
		$kk++;
		if(!empty($line && $kk<50)){
			$xml_deny.='<networkItem address="'.$line.'" type="DENY" />';
		}
	}
	$xml_deny.='</accessList>';
}

// echo $xml_deny;

echo curl_request($service_url.'loadbalancers/106281/accesslist',$xml_deny,array('X-Auth-Token: '.$new_token, 'X-Auth-Project-Id: '.$account_number));

/*

echo "get Loadbalancers:<hr>";

$xml_post='';
echo curl_request($service_url.'loadbalancers/106281/accesslist','',array('X-Auth-Token: '.$new_token, 'X-Auth-Project-Id: '.$account_number));

*/
// /v1.0/{account}/loadbalancers


/*

curl -s https://lon.identity.api.rackspacecloud.com/v2.0/tokens \
 -X 'POST' \
 -d '{"auth":{"RAX-KSKEY:apiKeyCredentials":{"username":"icandeveloper", "apiKey":"f03a31a39a263c1254506097040edd6b"}}}' \
 -H "Content-Type: application/json" | python -m json.tool


curl -s https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171/loadbalancers \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a"  | python -m json.tool

curl -s https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171/loadbalancers \
  -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a"
 
curl -s https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171/loadbalancers/106279/accesslist \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a"  | python -m json.tool
 
curl -s https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171/loadbalancers/106281/accesslist \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a"  | python -m json.tool

 
 
!!!!!!!!!!!!!!!!!!!DELETE!!!!
curl -s https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171/loadbalancers/106281/accesslist \
 -X 'DELETE' \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a"  | python -m json.tool
 
 
 
 /v1.0/{account}/loadbalancers/{loadBalancerId}/accesslist
 
 
 
 
 /v1.0/{account}/loadbalancers/{loadBalancerId}/accesslist
 
 
/v1.0/{account}/loadbalancers/{loadBalancerId}/accesslist










curl https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171 \
 -X POST \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a" 

curl -s https://lon.loadbalancers.api.rackspacecloud.com/v1.0/10040171/cloudLoadBalancers \
 -X POST \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a"
 
 
curl https://lon.loadbalancers.api.rackspacecloud.com/v2/10040171/servers \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -H "X-Auth-Token: 7b901aea17784fa9be1c941882879a5a" 

 
 
00000000-0000-0000-000000000000
7b901aea-1778-4fa9-be1c941882879a5a
 
 curl -s https://identity.api.rackspacecloud.com/v2.0/tokens -X 'POST' \
 -d '{"auth":{"passwordCredentials":{"username":"icandeveloper", "password":"Developer010pass"}}}' \
 -H "Content-Type: application/json" | python -m json.tool
 

 
*/
