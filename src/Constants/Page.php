<?php
declare(strict_types=1);

namespace lindesbs\toolbox\Constants;

class Page
{
    const SSLROOT = "PAGE::ROOT::SSL";
    const NOSSLROOT = "PAGE::ROOT::NOSSL";

    public static function SSLRoot():array
    {
        return [
            'type' => 'root',
        'fallback' => true,
        'useSSL' => true,
        'includeLayout' => true
        ];

    }

    public static function NoSSLRoot():array
    {
        return [
            'type' => 'root',
            'fallback' => true,
            'useSSL' => '',
            'includeLayout' => true
        ];

    }
}