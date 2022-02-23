<?php

namespace App\Http;

interface HttpInterface
{
    /**
     * @description Make HTTP-Request call
     * @param string $url
     * @param array $header
     * @param string $method
     * @param string|null $params
     * @return      string|null
     */
    public function httpRequest(string $url, array $header, string $method, ?string $params): ?string;
}