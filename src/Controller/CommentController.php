<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/{id}/delete', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, CommentRepository $commentRepository, int $id): Response
    {
        if (!$this->getUser() || $this->getUser() !== $comment->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $comment = $commentRepository->find($id);

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        $targetUrl = $this->generateUrl('app_trick_show', ['slug' => $comment->getTrick()->getSlug()]) . '#commentSection';
        return $this->redirect($targetUrl);
    }
}
