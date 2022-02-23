<?php

namespace App\Api;

use App\Http\AuthInterface;
use Exception;

class ApiAuth implements AuthInterface
{
    private string $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $code = '';
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'OPTIONS',
            ],
        ];

        try {
            $context = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);

            if (!empty($http_response_header)) {
                sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
            } else {
                throw new Exception("Response header is empty");
            }

            if ($code > 400) {
                throw new Exception("Response code " . $code);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $result;
    }
}