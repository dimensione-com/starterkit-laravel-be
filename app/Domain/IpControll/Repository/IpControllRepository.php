<?php

namespace App\Domain\IpControll\Repository;

use ipinfo\ipinfo\IPInfo;

class IpControllRepository
{

    public function __construct(){}

    public function checkIp(string $ip): array
    {
        $client = new IPInfo(config('API_KEY_IPINF'));
        $result = $client->getDetails($ip);

        $isItalian = $result->country === 'IT';

        $isVpnOrProxy = isset($result->privacy) && (
                $result->privacy->vpn ?? false ||
            $result->privacy->proxy ?? false ||
            $result->privacy->relay ?? false ||
            $result->privacy->hosting ?? false
            );

        return [
            'isItalian' => $isItalian,
            'isVpnOrProxy' => $isVpnOrProxy,
            'userAgent' => $result->userAgent ?? ''
        ];

    }
}
