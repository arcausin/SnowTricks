<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Media;

use App\Form\TrickType;
use App\Form\CommentType;
use App\Form\MediaType;

use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Mime\MimeTypes;

#[Route('/tricks')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'app_trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->redirectToRoute('app_home', ['_fragment' => 'TrickSection']);

        //return $this->render('trick/index.html.twig', [
        //    'tricks' => $trickRepository->findAll(),
        //]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreatedAt(new \DateTimeImmutable());
            $trick->setUser($this->getUser());

            $illustrationFile = $form->get('illustration')->getData();
            if ($illustrationFile) {
                $originalFilename = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$illustrationFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $illustrationFile->move(
                        $this->getParameter('illustrations_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $trick->setIllustration($newFilename);
            }

            $entityManager->persist($trick);
            $entityManager->flush();

            $targetUrl = $this->generateUrl('app_trick_show', ['id' => $trick->getId()]);
            return $this->redirect($targetUrl);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trick_show', methods: ['GET', 'POST'])]
    public function show(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, Trick $trick): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $media = new Media();
        $formMedia = $this->createForm(MediaType::class, $media);
        $formMedia->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->getUser() || $form->get('content')->getData() == '') {
                $targetUrl = $this->generateUrl('app_trick_show', ['id' => $trick->getId()]);
                return $this->redirect($targetUrl);
            }

            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);

            $entityManager->persist($comment);
            $entityManager->flush();

            $targetUrl = $this->generateUrl('app_trick_show', ['id' => $trick->getId()]) . '#commentSection';
            return $this->redirect($targetUrl);

        }

        if ($formMedia->isSubmitted() && $formMedia->isValid()) {
            if (!$this->getUser() || $formMedia->get('link')->getData() == '') {
                $targetUrl = $this->generateUrl('app_trick_show', ['id' => $trick->getId()]);
                return $this->redirect($targetUrl);
            }

            $media->setCreatedAt(new \DateTimeImmutable());
            $media->setTrick($trick);

            $illustrationFile = $formMedia->get('link')->getData();
            if ($illustrationFile) {
                $originalFilename = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$illustrationFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $illustrationFile->move(
                        $this->getParameter('illustrations_media_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $media->setLink($newFilename);
                
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/tiff', 'image/bmp'];

                if (in_array($illustrationFile->getClientMimeType(), $allowedMimeTypes)) {
                    $media->setType(0);
                } else {
                    $media->setType(1);
                }
            }

            $entityManager->persist($media);
            $entityManager->flush();

            $targetUrl = $this->generateUrl('app_trick_show', ['id' => $trick->getId()]);
            return $this->redirect($targetUrl);

        }

        $comments = $trick->getComments()->toArray();
        usort($comments, function($a, $b) {
            return $b->getCreatedAt() <=> $a->getCreatedAt();
        });

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,

            'comments' => $comments,

            'comment' => $comment,
            'media' => $media,

            'form' => $form->createView(),
            'formMedia' => $formMedia->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$trick->setCreatedAt(new \DateTimeImmutable());

            $illustrationFile = $form->get('illustration')->getData();
            if ($illustrationFile) {
                // Delete old illustration file if it exists
                $this->deleteIllustrationFile($trick);

                $originalFilename = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$illustrationFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $illustrationFile->move(
                        $this->getParameter('illustrations_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $trick->setIllustration($newFilename);
            }

            $entityManager->flush();

            $targetUrl = $this->generateUrl('app_trick_show', ['id' => $trick->getId()]);
            return $this->redirect($targetUrl);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Delete illustration file if it exists
        $this->deleteIllustrationFile($trick);
        
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home');
    }

    private function deleteIllustrationFile(Trick $trick): void
    {
        $oldFilename = $trick->getIllustration();
        if ($oldFilename) {
            $filePath = $this->getParameter('illustrations_directory') . '/' . $oldFilename;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
