<?php

namespace App\Controller;

use App\Entity\File;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolimorfikController extends AbstractController
{

    private ManagerRegistry $doctrine;
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $this->doctrine->getManager();
    }


    #[Route('/polimorfik', name: 'app_polimorfik')]
    public function index(): Response
    {
        $file = $this->entityManager->getRepository(File::class)->findAll();

        dd($file);

        return $this->render('polimorfik/index.html.twig', [
            'controller_name' => 'PolimorfikController',
        ]);
    }
}
