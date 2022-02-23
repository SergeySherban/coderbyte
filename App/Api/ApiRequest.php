<?php

namespace App\Api;

use App\Http\HttpInterface;
use Exception;

class ApiRequest implements HttpInterface
{
    /**
     * @param string $url
     * @param array $header
     * @param string $method
     * @param string|null $params
     * @return string|null
     * @throws Exception
     */
    public function httpRequest(string $url, array $header, string $method, ?string $params = null): ?string
    {
        //Explicit use of CURL (e.g. curl_exec()) is not allowed!
        $options = [
            'http' => [
                'header' => $header,
                'method' => $method,
                'content' => $params
            ],
        ];

        try {
            $result = $this->sentRequest($options, $url);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $result;
    }

    /**
     * @param array $options
     * @param string $url
     * @return string
     * @throws Exception
     */
    private function sentRequest(array $options, string $url): string
    {
        $code = '';
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if (!empty($http_response_header)) {
            sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
            $response_headers = $this->parseHeaders($http_response_header);
        } else {
            throw new Exception("Response header is empty");
        }

        //Erroneous HTTP response codes (e.g. 4xx, 5xx) must throw an exception
        if ($code >= 400) {
            throw new Exception("Code response " . $code);
        }

        return json_encode($response_headers);
    }

    /**
     * @param $headers
     * @return array
     */
    private function parseHeaders($headers): array
    {
        $head = [];

        //Retrieve/parse HTTP response headers
        foreach ($headers as $key => $value) {
            $header = explode(':', $value, 2);
            if (isset($header[1])) {
                $head[trim($header[0])] = trim($header[1]);
            } else {
                $head[] = $value;
            }
        }

        return $head;
    }
}