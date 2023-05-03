<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    public function save(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByLibelle(string $valeur, string $niveaupro, string $domainemetier, string $metier, string $typecontrat, Request $request): array
    {
        $queryBuilder = $this->createQueryBuilder('o');
        if ($valeur !== null && $valeur !== '--'){
            $queryBuilder->where('o.libelle LIKE :valeur')
            ->orWhere('o.description LIKE :valeur')
            ->setParameter('valeur', '%' . $valeur . '%');
        }

        if ($typecontrat !== '--') {
            $queryBuilder->join('o.TypeContrats', 'tc')
            ->andWhere('tc.Libelle LIKE :typecontrat')
            ->setParameter('typecontrat', '%' . $typecontrat . '%');
        }

        if ($metier !== '--') {
            $queryBuilder->join('o.metier', 'm')
            ->andWhere('m.Libelle LIKE :metier')
            ->setParameter('metier', '%' . $metier . '%');
        }
            
        if ($domainemetier !== '--') {
            $queryBuilder->join('m.DomaineMetiers', 'dm')
            ->andWhere('dm.Libelle LIKE :domainemetier')
                ->setParameter('domainemetier', '%' . $domainemetier . '%');
        }

        if ($niveaupro !== '--') {
            $queryBuilder->andWhere('o.niveaupro LIKE :niveaupro')
                ->setParameter('niveaupro', '%' . $niveaupro . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }




    public function findByFilters(string $domainemetier, string $metier, string $typecontrat, Request $request): array
    {
        $queryBuilder = $this->createQueryBuilder('o');

        if ($domainemetier !== '--') {
            $queryBuilder->andWhere('o.domainemetier LIKE :domainemetier')
                ->setParameter('domainemetier', '%' . $domainemetier . '%');

        }
         if ($metier !== '--') {
             $queryBuilder->andWhere('o.metier LIKE :metier')
                 ->setParameter('metier', '%' . $metier . '%');

             return $queryBuilder->getQuery()->getResult();
         }
    }

//    /**
//     * @return Offre[] Returns an array of Offre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
