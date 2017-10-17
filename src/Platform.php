<?php

/**
 * Created by IntelliJ IDEA.
 * User: serpico
 * Date: 8/27/17
 * Time: 11:53 AM
 */

namespace Papioniha\AuthorizationServerClient;

class Platform
{
    protected $base_url;

    /**
     * Platform constructor.
     * @param string $base_url
     * @throws \Exception
     */
    function __construct($base_url)
    {
        /**
         * checking for cURL library
         * */
        if (! extension_loaded('curl') ){
            throw new \Exception('cURL library is not loaded');
        }
        $this->base_url = $base_url;
    }

    /**
     * sends a get request to $endpoint with $params
     *
     * @param $endpoint
     * @param array $params
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    public function get($endpoint, $params, $headers){
        $handle = curl_init();
        $headersArray = [];
        foreach ($headers as $key => $value){
            array_push($headersArray, $key . ": " .$value);
        }
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headersArray);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        $urlEncodeData = "";
        if ($params){
            $urlEncodeData = http_build_query($params);
        }
        curl_setopt($handle, CURLOPT_URL, $this->base_url . "/" . $endpoint . $urlEncodeData);
        $response = curl_exec($handle);
        $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
        /**
         * checking for connection errors
         * */
        if ($curl_errno = curl_errno($handle)) {
            // Connection Error
            $curl_error = curl_error($handle);
            throw new \Exception($curl_error, $curl_errno);
        }
        curl_close($handle);
        $exception = null;
        if (! ($responseCode >= 200 && $responseCode < 300) ) {
            $message = $response;
            if ($responseCode >= 300 && $responseCode < 400){
                $message = 'Response Redirected To Another Uri.';
            }
            $exception = new \Exception($message, $responseCode);
        }
        return array(
            'response' => $response,
            'responseCode' => $responseCode,
            'contentType' => $contentType,
            'exception' => $exception
        );
    }

    public function post($endpoint, $data, $headers){
        $handle = curl_init();
        $headersArray = [];
        foreach ($headers as $key => $value){
            array_push($headersArray, $key . ": " .$value);
        }
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headersArray);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_URL, $this->base_url . "/" . $endpoint);
        curl_setopt($handle, CURLOPT_POST, true);
        foreach ($data  as $k => $d) {
            if (is_array($d)) {
                foreach ($d as $i => $v){
                    $data[$k.'['.$i.']'] = $v;
                }
                unset($data[$k]);
            }
        }
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($handle);
        $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
        /**
         * checking for connection errors
         * */
        if ($curl_errno = curl_errno($handle)) {
            // Connection Error
            $curl_error = curl_error($handle);
            throw new \Exception($curl_error, $curl_errno);
        }
        curl_close($handle);
        $exception = null;
        if (! ($responseCode >= 200 && $responseCode < 300) ) {
            $message = $response;
            if ($responseCode >= 300 && $responseCode < 400){
                $message = 'Response Redirected To Another Uri.';
            }
            $exception = new \Exception($message, $responseCode);
        }
        return array(
            'response' => $response,
            'responseCode' => $responseCode,
            'contentType' => $contentType,
            'exception' => $exception
        );
    }
}