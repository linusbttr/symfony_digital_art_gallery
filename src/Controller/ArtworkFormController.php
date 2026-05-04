<?php

namespace App\Controller;
use App\Entity\Artwork;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ArtworkType;
use Doctrine\ORM\EntityManagerInterface;

final class ArtworkFormController extends AbstractController
{
    #[Route('/artwork/new', name: 'newArtwork')]
    public function new(Request $request, EntityManagerInterface $em): Response
{
    $artwork = new Artwork();
    $form = $this->createForm(ArtworkType::class, $artwork);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
        $imageFile = $form->get('imageFile')->getData();

        if ($imageFile) {
            $filename = uniqid() . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/images',
                $filename
            );
            $artwork->setImageUrl('/images/' . $filename);
        }

        $em->persist($artwork);
        $em->flush();
        return $this->redirectToRoute('allArtworks');
    }

    return $this->render('artwork/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
