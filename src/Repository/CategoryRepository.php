<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findLatest(int $page = 1, int $pageSize = 10): Paginator
    {
        $qb = $this->createQueryBuilder('c')
            ->setFirstResult(($page - 1) * $pageSize) 
            ->setMaxResults($pageSize);

        return new Paginator($qb);
    }
}
