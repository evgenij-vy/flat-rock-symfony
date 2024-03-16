<?php

namespace App\Repository;

use App\Entity\QuizQuestionAnswerVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizQuestionAnswerVariant>
 *
 * @method QuizQuestionAnswerVariant|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizQuestionAnswerVariant|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizQuestionAnswerVariant[]    findAll()
 * @method QuizQuestionAnswerVariant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizQuestionAnswerVariantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizQuestionAnswerVariant::class);
    }
}
