<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\DoctrineUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use TFounder\Domain\Security\Entity\User;
use TFounder\Domain\Security\Exception\UserNotFoundException;
use TFounder\Domain\Security\Gateway\UserGateway;

class UserRepository extends ServiceEntityRepository implements UserGateway
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    public function register(User $user): void
    {
        $doctrineUser = (new DoctrineUser())
            ->setPseudonym($user->getPseudonym())
            ->setEmail($user->getEmail())
            ->setPassword($user->getPassword());

        $this->_em->persist($doctrineUser);
        $this->_em->flush();
    }

    public function isPseudonymAlreadyInUse($pseudonym): bool
    {
        return in_array($pseudonym, ['used_pseudo']);
    }

    public function isEmailAlreadyInUse($email): bool
    {
        return in_array($email, ['used@email.com']);
    }

    /**
     * @param string $email
     * @throws UserNotFoundException
     */
    public function getUserByEmail(string $email)
    {
        try {
            /** @var DoctrineUser $user */
            $user = $this->createQueryBuilder('u')->andWhere('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();

            if (!$user) {
                throw new UserNotFoundException();
            }

            return new User(
                $user->getPseudonym(),
                $user->getEmail(),
                $user->getPassword()
            );
        } catch (NonUniqueResultException $e) {
            die();
        }
    }
}
