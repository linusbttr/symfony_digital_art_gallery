<?php

namespace App\Controller;

use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtworkEditController extends AbstractController
{
    #[Route('/artwork/{id}/edit', name: 'editArtwork', requirements: ['id' => '\d+'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em, ArtworkRepository $artworkRepository): Response
    {
        $artwork = $artworkRepository->find($id);

        if (!$artwork) {
            throw $this->createNotFoundException('Artwork not found');
        }

        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $filename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/images',
                    $filename
                );
                $artwork->setImageUrl('/images/' . $filename);
            }

            $em->flush();
            return $this->redirectToRoute('allArtworks');
        }

        return $this->render('artwork/edit.html.twig', [
            'form' => $form->createView(),
            'artwork' => $artwork,
        ]);
    }
}