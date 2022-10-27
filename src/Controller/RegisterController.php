<?php

namespace App\Controller;

use App\Entity\SecurityUser;
use App\Entity\Video;
use App\Form\RegisterUserType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {

        $user = new SecurityUser();
        $form = $this->createForm(
            RegisterUserType::class,
            $user,
        );

        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {

            $password =     $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );

            $user->setEmail($form->get('email')->getData());

            $user->setPassword($password);

            // Kayıt edilen şifre veritabanında gözükmez
            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->flush();
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/register/2', name: 'app_register2')]
    public function index2(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {

        $user = new SecurityUser();

        $user->setEmail('admi22n1@admin.com');
        $password =    $passwordHasher->hashPassword(
            $user,
            '123456'
        );
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);

        $video = new Video();
        $video->setTitle('Video 1');
        $video->setFilename('video1.mp4');
        $video->setCreatedAt(new \DateTime());

        $user->addVideo($video);

        $doctrine->getManager()->persist($user);
        $doctrine->getManager()->persist($video);
        $doctrine->getManager()->flush();


        dump($user->getId());
        dump($video->getId());





        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/get-user/{id}', name: 'app_get_user')]
    #[Security('is_granted("ROLE_USER")')]
    public function getSecurityUser2(SecurityUser $user): Response
    {
        dump($user);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    #[Route('/home', name: 'app_home')]
    public function app_home()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
