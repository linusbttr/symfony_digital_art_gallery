<?php

namespace App\Repository;

use App\Entity\Artwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    // Find artworks by artist
    public function findByArtist(int $artistId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.artist = :artistId')
            ->setParameter('artistId', $artistId)
            ->orderBy('a.creationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // Find artworks sorted by date
    public function findAllSortedByDate(string $order = 'DESC'): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.creationDate', $order)
            ->getQuery()
            ->getResult();
    }

    // Search artworks by title keyword
    public function findByTitleKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

    // Paginate artworks
    public function findPaginated(int $page = 1, int $limit = 3): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}