<?php

namespace App\Services;


use App\Services\MySecondService;
use Symfony\Contracts\Service\Attribute\Required;

trait OptionalServiceTrait
{
    private $service;

    #[Required]
    public function setService(MySecondService $service)
    {
        dump('I am Live Trait!', $service);
        $this->service = $service;
    }


    public function doSomething()
    {
        dump('I am doing something');
    }
}
