<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class ExceptionController extends AbstractController
{
    #[Route('/error', name: 'exception_error')]
    public function showError(FlattenException $exception): Response
    {
        // Vous pouvez accéder à l'exception et personnaliser la réponse en conséquence.
        if ($exception->getStatusCode() == 404) {
            // Gérer l'erreur 404, par exemple, en rendant un template Twig.
            return $this->render('errors/404.html.twig', []);
        } elseif ($exception->getStatusCode() == 500) {
            // Gérer l'erreur 500, par exemple, en rendant un template Twig.
            return $this->render('errors/500.html.twig', ['test' => $exception->getMessage()]);
        }

        // Par défaut, renvoyer une réponse générique pour d'autres erreurs.
        return $this->render('errors/default.html.twig', []);
    }
}
