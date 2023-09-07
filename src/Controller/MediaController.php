<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/media')]
class MediaController extends AbstractController
{
    #[Route('/{id}/delete', name: 'app_media_delete', methods: ['POST'])]
    public function delete(Request $request, Media $media, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Delete illustration file if it exists
        $this->deleteIllustrationFile($media);

        if ($this->isCsrfTokenValid('delete'.$media->getId(), $request->request->get('_token'))) {
            $entityManager->remove($media);
            $entityManager->flush();
        }

        $targetUrl = $this->generateUrl('app_trick_show', ['slug' => $media->getTrick()->getSlug()]);
        return $this->redirect($targetUrl);
    }

    private function deleteIllustrationFile(Media $media): void
    {
        $oldFilename = $media->getLink();
        if ($oldFilename) {
            $filePath = $this->getParameter('illustrations_media_directory') . '/' . $oldFilename;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
