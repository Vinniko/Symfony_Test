<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    public function findLatest($page, $qtyOnPage = 10)
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('p')
                ->orderBy('p.createdAt', 'DESC'),
            $page,
            $qtyOnPage
        );
    }

    public function findByFilter($page, $qtyOnPage = 10, $filters)
    {
        $keys = array_keys($filters);
        $qb = $this->createQueryBuilder('p')
            ->addSelect('o', 'po')
            ->innerJoin('p.productOptions', 'po')
            ->innerJoin('po.option_id', 'o')
            ->orderBy('p.createdAt', 'DESC');
        foreach($keys as $key){
            $qb->andWhere('o.title = :key')
                ->andWhere('po.value = :value')
                ->setParameter('key', $key)
                ->setParameter('value', $filters[$key]);
        }
        return $this->paginator->paginate(
            $qb,
            $page,
            $qtyOnPage
        );
    }
}
