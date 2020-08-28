<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByRandom(): ?Product
    {
        $count = $this->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();

        return $this->createQueryBuilder('p')
            ->setFirstResult(rand(1, $count))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getQuery()
    {
        return $this->createQueryBuilder('p')->getQuery();
    }
}
