<?php
/**
 * Simple client class for consuming the Email & Apps REST API
 * (http://api-wiki.apps.rackspace.com/api-wiki/index.php/Main_Page)
 *
 * Pre-requisites:
 *
 * - PHP's curl extension (apt-get install php5-curl)
 * - CA cert files at /etc/ssl/certs (apt-get install ca-certificates)
 *
 * Contributors:
 *
 * - Rackspace Email & Apps REST API Team
 * - Josh Shilling
 */
class ApiClient
{
    const USER_KEY = 'icandeveloper';
    const SECRET_KEY = 'f03a31a39a263c1254506097040edd6b';
    const USER_AGENT = 'PHP Demo Client';

    const VERSION = 'v1';
    const SERVER_HOST = 'api.emailsrvr.com';

    public function get($url_string, $format)
    {
        $headers = array("Accept: $format");

        $curl_session = self::construct_session($url_string, $headers);

        $http_message = self::send_request($curl_session);
        return $http_message;
    }

    public function post($url_string, $fields, $format)
    {
        $headers = array("Accept: $format");
        $curl_session = self::construct_session($url_string, $headers);

        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $fields);

        $http_message = self::send_request($curl_session);
        return $http_message;
    }

    public function put($url_string, $fields)
    {
        $curl_session = self::construct_session($url_string, array());

        curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $fields);

        $http_message = self::send_request($curl_session);
        return $http_message;
    }

    public function delete($url_string)
    {
        $curl_session = self::construct_session($url_string, array());

        curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $http_message = self::send_request($curl_session);
        return $http_message;
    }

    private function send_request($curl_session)
    {
        $response = curl_exec($curl_session);
        curl_close($curl_session);

        return $response;
    }

    private function construct_session($url_string, $existing_headers)
    {
        $headers = array_merge(
                self::authorization_headers(), $existing_headers);
        $url = self::construct_uri($url_string);
        $curl_session = curl_init($url);

        curl_setopt($curl_session, CURLOPT_VERBOSE, false); //set to true for debug
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl_session, CURLOPT_CAPATH, "/etc/ssl/certs");

        return $curl_session;
    }

    private function authorization_headers()
    {
        $time_stamp = date('YmdHis');

        $data_to_sign = self::USER_KEY . self::USER_AGENT .  $time_stamp. self::SECRET_KEY;

        $signature = base64_encode(sha1($data_to_sign, true));

        $headers = array();
        $headers[] = "User-Agent: " . self::USER_AGENT;
        $headers[] = 'X-Api-Signature: ' . self::USER_KEY . ":$time_stamp:$signature";
        return $headers;
    }

    private function construct_uri($url_string)
    {
        $url = 'https://' . self::SERVER_HOST . '/' . self::VERSION . $url_string;
        return $url;
    }
}


header('Content-Type:  text/plain');

$client = new  ApiClient();

$response = $client->get(
    '/customers/me/domains',
    'text/xml');

echo  $response . "\r\n";
?>
