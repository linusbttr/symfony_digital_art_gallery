<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtworkController extends AbstractController
{
    #[Route('/artwork', name: 'allArtworks')]
    public function allArtworks(ArtworkRepository $artworkRepository): Response
    {
        $artworks = $artworkRepository->findAll();

        return $this->render('artwork/all.html.twig', [
            'artworks' => $artworks,
        ]);
    }
    #[Route('/artwork/current', name: 'currentArtwork')]
    public function currentArtwork(ArtworkRepository $artworkRepository): Response
    {
        $artwork = $artworkRepository->findOneBy([], ['id' => 'DESC']);;

        if (!$artwork) {
            throw $this->createNotFoundException('Artwork not found');
        }

        return $this->render('artwork/artwork.html.twig', [
            'artwork' => $artwork,
        ]);
    }
    #[Route('/artwork/{id}', name: 'idArtwork', requirements: ['id' => '\d+'])]
    public function artworkById(int $id, ArtworkRepository $artworkRepository): Response
    {
        $artwork = $artworkRepository->find($id);

        if (!$artwork) {
            throw $this->createNotFoundException('Artwork not found');
        }

        return $this->render('artwork/artwork.html.twig', [
            'artwork' => $artwork,
        ]);
    }
}