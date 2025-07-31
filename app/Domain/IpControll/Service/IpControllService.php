<?php

namespace App\Domain\IpControll\Service;

use App\Domain\IpControll\Repository\IpControllRepository;

class IpControllService
{
    public function __construct( private readonly IpControllRepository $ipControllRepository){}

    public function checkIp(string $ip) : array
    {
        return $this->ipControllRepository->checkIp($ip);
    }

}
