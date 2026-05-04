<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtworkDeleteController extends AbstractController
{
    #[Route('/artwork/{id}/delete', name: 'deleteArtwork', requirements: ['id' => '\d+'])]
    public function delete(int $id, Request $request, EntityManagerInterface $em, ArtworkRepository $artworkRepository): Response
    {
        $artwork = $artworkRepository->find($id);

        if (!$artwork) {
            throw $this->createNotFoundException('Artwork not found');
        }

        if ($request->isMethod('POST')) {
            $em->remove($artwork);
            $em->flush();
            return $this->redirectToRoute('allArtworks');
        }

        return $this->render('artwork/delete.html.twig', [
            'artwork' => $artwork,
        ]);
    }
}