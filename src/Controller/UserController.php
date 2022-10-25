<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

        // Sorgu yapar 
        $this->user = $this->doctrine->getRepository(User::class);
        // Sorgu işlemeni tamamlar
        $this->repository = $this->doctrine->getManager();
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $repository = $this->doctrine->getManager();

        $user  = new User();
        // $user->setName('John Doe');

        // $entityManager->persist($user);
        // $entityManager->flush();

        $user = $repository->getRepository(User::class);
        // $data =  $user->findOneBy(['name' => 'John Doe-2']);

        // $data =  $user->findBy(['name' => 'John Doe-2'], ['id' => 'DESC']);

        // $data = $user->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/create', name: 'app_user_create')]
    public function create_user()
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();

            $user->setName('John Doe -' . $i);
            # code...
            $this->repository->persist($user);
        }

        $this->repository->flush();

        return new Response('User created');
    }

    #[Route('/user/update/{id?}', name: 'app_user_update', defaults: ['id' => 11])]

    public function update($id): Response
    {
        $repository = $this->doctrine->getManager();

        $user = $repository->getRepository(User::class);
        $data =  $user->find($id);

        // Error Handler
        if (!$data) {
            throw $this->createNotFoundException(' No user found for id ' . $id);
        }

        $data->setName('Sezer Bölük');

        $repository->flush();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/delete/{id?}', name: 'app_user_delete', defaults: ['id' => 11])]
    public function deleteUser($id)
    {
        $user =  $this->user->find($id);

        if (!$user) {
            throw $this->createNotFoundException(' No user found for id ' . $id);
        }
        $this->repository->remove($user);
        $this->repository->flush();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/sql', name: 'app_user_sql')]
    public function sql()
    {
        $allUser = $this->user->getAllUser();
        dd($allUser[0]['name']);
    }

    /**Convert Param */
    /**
     * Bu sorgu yapısında eğer user tablosunda uyuşan bir id olursa o id ye ait user bilgilerini döndürür.
     */
    #[Route('/user/convert/{id?}', name: 'app_user_convert', defaults: ['id' => 11])]
    public function convertParam(User $user)
    {
        dd($user);
    }

    #[Route('/create/video', name: 'app_create_video')]
    public function createVideo()
    {
        // Yeni eklenen kullanıcıya videoları ata
        $user  = new User();
        $user->setName('Sezer Bölük');


        // eşleşen kullanıcıya videoları ata
        // $user =  $this->user->find(21);

        for ($i = 0; $i < 3; $i++) {
            $video = new Video();
            $video->setTitle('Video Title -' . $i);
            $user->addVideo($video);

            $this->repository->persist($video);
        }

        $this->repository->persist($user);
        $this->repository->flush();


        return new Response('Saved new video with id ' . $video->getId());
    }

    #[Route('/user/video/{id?}', name: 'app_user_video', defaults: ['id' => 11])]
    public function userVideo($id)
    {

        $video =  $this->doctrine->getRepository(Video::class)->find($id);

        dd($video->getUser()->getName());

        // $user = $this->user->find($id);


        // foreach ($user->getVideos() as $video) {
        //     echo $video->getTitle() . '<br>';
        // }

        return new Response('Saved new video with id ' . $video->getId());
    }


    #[Route('/user/video/delete/{id?}', name: 'app_user_video_delete', defaults: ['id' => 11])]
    public function userVideoDelete($id)
    {

        $user = $this->user->find($id);

        // delete user 
        $this->repository->remove($user);
        $this->repository->flush();


        return new Response('Video deleted');
    }

    #[Route('/user/create/address', name: 'app_user_create_address')]
    public function createAddress()
    {
        $user = $this->user->find(4);

        $address = new Address();
        $address->setStreet('Street');
        $address->setNumber('City');
        // user 
        $address->setUser($user);


        $this->repository->persist($address);
        $this->repository->flush();



        return new Response('Address created');
    }


    #[Route('/user/address/{id?}', name: 'app_user_address', defaults: ['id' => 11])]

    public function userAddress($id)
    {

        $address = $this->doctrine->getRepository(Address::class)->find($id);

        dd($address->getUser()->getName());

        return new Response('Address created');
    }

    #[Route('/user/address/delete/{id?}', name: 'app_user_address_delete', defaults: ['id' => 11])]
    public function userAddressDelete($id)
    {

        // $address = $this->doctrine->getRepository(Address::class)->find($id);

        // $this->repository->remove($address);
        // $this->repository->flush();

        // return new Response('Address deleted');

        $user =  $this->user->find(4);

        $this->repository->remove($user);

        $this->repository->flush();

        return new Response('User deleted');
    }

    #[Route('/find/user/{id?}', name: 'app_find_user', defaults: ['id' => 4])]
    public function findUser($id)
    {

        $user = $this->user->find($id);

        // Kullanıcı ile ilişkili adresleri getir

        // dd($user->getAddress()->getStreet());

        // Kullanıcı ile ilişkili videoları getir

        // $user->getVideos()->map(function ($video) {
        //     echo $video->getTitle() . '<br>';
        // });
        return new Response('Address created');
    }


    /**Query Builder  */
    #[Route('/query/builder', name: 'app_query_builder')]
    public function queryBuilder()
    {
        $data =   $this->user->findWithVideos(6);

        dump(1234);

        foreach ($data->getVideos() as $video) {
            echo $video->getTitle() . '<br>';
        }


        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
