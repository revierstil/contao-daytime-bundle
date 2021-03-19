<?php

declare(strict_types=1);

namespace Jdwiese\DaytimeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Jdwiese\DaytimeBundle\Entity\Category;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findOneByIdOrAlias(string $idOrAlias): ?Category
    {
        $queryBuilder = $this->createQueryBuilder('category');

        $queryBuilder
            ->where($queryBuilder->expr()->eq(ctype_digit($idOrAlias) ? 'category.id' : 'category.alias', ':id_or_alias'))
            ->setParameter('id_or_alias', $idOrAlias);

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
    }
}
