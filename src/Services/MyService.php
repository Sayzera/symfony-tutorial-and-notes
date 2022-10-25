<?php

namespace App\Services;

use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Contracts\Service\Attribute\Required;

class MyService implements ServiceInterFace
{
    use OptionalServiceTrait;


    /**
     * Burası sadece Parametre olarak second service'i alıyor.
     */
    public function __construct(MySecondService $second_service)
    {
        // ...

        dump('I am Live!', $second_service);
    }

    // #[Required] # Yüklendiği anda otomatik olarak başlatılacaktır 
    // public function setSecondService(MySecondService $second_service)
    // {
    //     dump('I am Live!', $second_service);
    // }


    public function someAction()
    {
        $this->doSomething();
    }

    public function postFlush(PostFlushEventArgs $args)
    {

        dump('I am postFlush', $args);
    }

    public function clear()
    {
        dump('I am clear');
    }
}
