<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ManagerRegistry $mr): Response
    {
        $tricks = $mr->getRepository(Trick::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks
        ]);
    }
}