<?php

namespace App\Controller;

use App\Repository\VirtualTourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VirtualTourController extends AbstractController
{
    #[Route('/tours', name: 'allTours')]
    public function index(VirtualTourRepository $virtualTourRepository): Response
    {
        $tours = $virtualTourRepository->findAll();

        return $this->render('virtual_tour/index.html.twig', [
            'tours' => $tours,
        ]);
    }

    #[Route('/tours/{id}', name: 'tourDetail', requirements: ['id' => '\d+'])]
    public function detail(int $id, VirtualTourRepository $virtualTourRepository): Response
    {
        $tour = $virtualTourRepository->find($id);

        if (!$tour) {
            throw $this->createNotFoundException('Tour not found');
        }

        return $this->render('virtual_tour/detail.html.twig', [
            'tour' => $tour,
        ]);
    }
}