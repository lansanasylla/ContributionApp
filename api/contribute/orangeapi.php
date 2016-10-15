<?php

class orangeAPI
{
    const BASE_URL = 'https://api.orange.com';
    
    protected $clientId = 'ap4enryVNU84JUlDYecWWeWaKEZuhoWA';
    protected $clientSecret = 'PXmmvTuownGixyYd';
    protected $token = '7Bfodsjoi4CKYcyzoALSBUgMGgSP';

    public function __construct($config = array())
    {
        if (array_key_exists('clientId', $config)) {
            $this->clientId = $config['clientId'];
        }
        if (array_key_exists('clientSecret', $config)) {
            $this->clientSecret = $config['clientSecret'];
        }
        if (array_key_exists('token', $config)) {
            $this->token = $config['token'];
        }
    }
	
    public function getTokenFromConsumerKey()
    {   
        $url = self::BASE_URL . '/oauth/v2/token';

        $credentials = $this->getClientId() . ':' . $this->getClientSecret();

        $headers = array('Authorization: Basic ' . base64_encode($credentials));

        $args = array('grant_type' => 'client_credentials');

        $response = $this->callApi($headers, $args, $url, 'POST', 200);

        if (!empty($response['access_token'])) {
            $this->setToken($response['access_token']);
        }

        return $response;
    }

    public function sendSms(
        $senderAddress,
        $receiverAddress,
        $message,
        $senderName = 'lansana'
    ) {
        $url = self::BASE_URL . '/smsmessaging/v1/outbound/' . urlencode($senderAddress)
            . '/requests';

        $headers = array(
            'Authorization: Bearer ' . $this->getToken(),
            'Content-Type: application/json'
        );

        if (!empty($senderName)) {
            $args = array(
                'outboundSMSMessageRequest' => array(
                    'address'                   => $receiverAddress,
                    'senderAddress'             => $senderAddress,
                    'senderName'                => urlencode($senderName),
                    'outboundSMSTextMessage'    => array(
                        'message' => $message
                    )
                )
            );
        } else {
            $args = array(
                'outboundSMSMessageRequest' => array(
                    'address'                   => $receiverAddress,
                    'senderAddress'             => $senderAddress,
                    'outboundSMSTextMessage'    => array(
                        'message' => $message
                    )
                )
            );
        }

        return $this->callApi($headers, $args, $url, 'POST', 201, true);
    }

    public function callApi(
        $headers,
        $args,
        $url,
        $method,
        $successCode,
        $jsonEncodeArgs = false
    ) {
        $ch = curl_init();
    
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);

            if (!empty($args)) {
                if ($jsonEncodeArgs === true) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
                }
            }
        } else /* $method === 'GET' */ {
            if (!empty($args)) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($args));
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         //Make sure we can access the response when we execute the call
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        if ($data === false) {
            return array('error' => 'API call failed with cURL error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
        curl_close($ch);

        $response = json_decode($data, true);

        $jsonErrorCode = json_last_error();
        if ($jsonErrorCode !== JSON_ERROR_NONE) {
            return array(
                'error' => 'API response not well-formed (json error code: '
                    . $jsonErrorCode . ')'
            );
        }

        if ($httpCode !== $successCode) {
            $errorMessage = '';

            if (!empty($response['error_description'])) {
                $errorMessage = $response['error_description'];
            } elseif (!empty($response['error'])) {
                $errorMessage = $response['error'];
            } elseif (!empty($response['description'])) {
                $errorMessage = $response['description'];
            } elseif (!empty($response['message'])) {
                $errorMessage = $response['message'];
            } elseif (!empty($response['requestError']['serviceException'])) {
                $errorMessage = $response['requestError']['serviceException']['text']
                    . ' ' . $response['requestError']['serviceException']['variables'];
            } elseif (!empty($response['requestError']['policyException'])) {
                $errorMessage = $response['requestError']['policyException']['text']
                    . ' ' . $response['requestError']['policyException']['variables'];
            }

            return array('error' => $errorMessage);
        }

        return $response;
    }
    public function getClientId()
    {
        return $this->clientId;
    }
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function getToken()
    {
        return $this->token;
    }
    public function setToken($token)
    {
        $this->token = $token;
    }
}
