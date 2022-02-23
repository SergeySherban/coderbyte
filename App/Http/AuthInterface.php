<?php

namespace App\Http;

interface AuthInterface
{
    /**
     * @description Make HTTP-Options call
     * @return      string
     */
    public function getToken(): string;
}