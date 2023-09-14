<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, TrickRepository $trickRepository): Response
    {
        $tricksLoad = 9;

        // process load more tricks button
        if ($request->request->get('submitLoadMoreTricks') !== null) {
            $tricksLoad = $request->request->get('tricksLoad');
            $tricksLoad = $tricksLoad + 9;
        }

        // display load more tricks button or not
        if ($tricksLoad >= count($trickRepository->findAll())) {
            $loadMoreTricks = false;
        } else {
            $loadMoreTricks = true;
        }

        $tricks = $trickRepository->findTricks($tricksLoad);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks,
            'loadMoreTricks' => $loadMoreTricks,
            'tricksLoad' => $tricksLoad,
        ]);
    }
}
