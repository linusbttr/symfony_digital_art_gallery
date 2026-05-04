<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['main'];
    }
    public function load(ObjectManager $manager): void
    {
        // Create Artists
        $artist1 = new Artist();
        $artist1->setName('Leonardo da Vinci');
        $artist1->setBiography('Italian Renaissance painter and polymath.');
        $artist1->setBirthDate(new \DateTime('1452-04-15'));
        $artist1->setNationality('Italian');
        $manager->persist($artist1);

        $artist2 = new Artist();
        $artist2->setName('Vincent van Gogh');
        $artist2->setBiography('Dutch post-impressionist painter.');
        $artist2->setBirthDate(new \DateTime('1853-03-30'));
        $artist2->setNationality('Dutch');
        $manager->persist($artist2);

        // Create Artworks
        $artworks = [
            ['Mona Lisa', 'Portrait of Lisa Gherardini.', '1503-01-01', '/images/mona_lisa.jpg', $artist1],
            ['The Last Supper', 'Mural painting of the Last Supper.', '1498-01-01', '/images/last_supper.jpg', $artist1],
            ['Starry Night', 'Swirling night sky over a village.', '1889-06-01', '/images/starry_night.jpg', $artist2],
            ['Sunflowers', 'Series of still life paintings.', '1888-08-01', '/images/sunflowers.jpg', $artist2],
            ['The Bedroom', 'Painting of van Gogh\'s bedroom.', '1888-10-01', '/images/bedroom.png', $artist2],
        ];

        foreach ($artworks as [$title, $desc, $date, $image, $artist]) {
            $artwork = new Artwork();
            $artwork->setTitle($title);
            $artwork->setDescription($desc);
            $artwork->setCreationDate(new \DateTime($date));
            $artwork->setImageUrl($image);
            $artwork->setArtist($artist);
            $manager->persist($artwork);
        }

        // Create User
        $user = new User();
        $user->setEmail('admin@gallery.com');
        $user->setPassword('password123');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}