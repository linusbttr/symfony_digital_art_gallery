<?php

namespace App\DataFixtures;

use App\Entity\VirtualTour;
use App\Repository\ArtworkRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ExtraFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['tour'];
    }

    public function load(ObjectManager $manager): void
    {
        $artworkRepo = $manager->getRepository(\App\Entity\Artwork::class);

        $tour1 = new VirtualTour();
        $tour1->setName('Renaissance Masters');
        $tour1->setDescription('Explore the greatest works of the Italian Renaissance.');
        $tour1->setCreatedAt(new \DateTime());
        $tour1->addArtwork($artworkRepo->findOneBy(['title' => 'Starry Night']));
        $tour1->addArtwork($artworkRepo->findOneBy(['title' => 'The Last Supper']));
        $manager->persist($tour1);

        $tour2 = new VirtualTour();
        $tour2->setName('Van Gogh Collection');
        $tour2->setDescription('A journey through the vibrant world of Vincent van Gogh.');
        $tour2->setCreatedAt(new \DateTime());
        $tour2->addArtwork($artworkRepo->findOneBy(['title' => 'Starry Night']));
        $tour2->addArtwork($artworkRepo->findOneBy(['title' => 'Sunflowers']));
        $tour2->addArtwork($artworkRepo->findOneBy(['title' => 'The Bedroom']));
        $manager->persist($tour2);

        $manager->flush();
    }
}