<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\MyService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;


class DefaultController extends AbstractController
{
    public  $entityManager;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }


    #[Route('default', name: 'app_default_2')]
    public function index2(): Response
    {
        $cache = new  FilesystemAdapter();

        $usersData =  $cache->getItem('database.get_users');
        if (!$usersData->isHit()) {
            $usersData->expiresAfter(5);
            $usersData->set(serialize($this->entityManager->getRepository(User::class)->findAll()));
            $cache->save($usersData);
            dump('from database');
        } else {
            dump('cache');
            $data =  unserialize($usersData->get());
            dump($data);
        }

        // cache clear 
        // $cache->delete('database.get_users');


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    #[Route('default3', name: 'app_default3')]
    public function index3(): Response
    {
        $cache = new TagAwareAdapter(
            new FilesystemAdapter()
        );

        /**
         * Cacheleri oluşturuyoruz
         */

        $acer = $cache->getItem('acer');
        $dell = $cache->getItem('dell');
        $ibm = $cache->getItem('ibm');
        $apple = $cache->getItem('apple');

        /**
         * tagler cachleri gruplamak için kullanırız ve sonrasında o grubu doğrudan silebilir
         * veya o grup içerisindeki cachleri invalid edebiliriz
         */

        if (!$acer->isHit()) {
            $acer->set('acer');
            $acer->tag(['laptop', 'computer', 'acer']);
            $cache->save($acer);

            dump('acer laptop from database ...');
        }

        if (!$dell->isHit()) {
            $dell->set('dell');
            $dell->tag(['laptop', 'computer', 'dell']);
            $cache->save($dell);

            dump('dell laptop from database ...');
        }


        if (!$ibm->isHit()) {
            $ibm->set('ibm');
            $ibm->tag(['laptop', 'computer', 'ibm']);
            $cache->save($ibm);

            dump('ibm laptop from database ...');
        }


        if (!$apple->isHit()) {
            $apple->set('apple');
            $apple->tag(['laptop', 'computer', 'apple']);
            $cache->save($apple);

            dump('apple laptop from database ...');
        }

        /**
         * Verinin cacheden gelmesini iptal et 
         */
        $cache->invalidateTags(['apple']);

        $laptop = $cache->getItems(['acer', 'dell', 'ibm', 'apple']);

        // get acer
        dump($laptop['acer']->get());

        dump($laptop);




        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }



    #[Route('/default2', name: 'app_default2')]
    public function index(Request $request, MyService $service): Response
    {
        $service->someAction();

        $entityManager =  $this->entityManager->getRepository(User::class);


        $user = new User();
        $user->setName('John Doe');
        $this->entityManager->persist($user);
        $this->entityManager->flush();







        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
