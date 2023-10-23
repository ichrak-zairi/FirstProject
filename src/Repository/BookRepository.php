<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function showAllBooksByAuthor($title)
        {
            return $this->createQueryBuilder('b')
                ->where('b.title LIKE :title')
                ->setParameter('title', '%'.$title.'%')
                ->getQuery()
                ->getResult()
            ;
        }
public function trieDQ (){
   $em=$this -> getEntityManager () ;
   $query =$em -> createQuery('SELECT b FROM App\Entity\Book b ORDER BY b.title DESC' );
   return $query -> getResult () ;
}
function NbBookCategory(){
    $em=$this->getEntityManager();
    return $em->createQuery('select count(b) from App\Entity\Book b WHERE b.category=:category')
    ->setParameter('category','Science Fiction')->getSingleScalarResult();
}
}
