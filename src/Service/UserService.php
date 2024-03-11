<?php

namespace App\Service;

use App\Entity\Sector;
use App\Entity\User;
use App\Entity\UserSector;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserService
{
    /**
     * Creates or updates a user based on the provided username.
     *
     * @param string $userName Username to create or update the user.
     * @param array $data Data for creating or updating the user.
     * @param EntityManagerInterface $entityManager The entity manager.
     * @return User The created or updated user.
     * @throws Exception If the user cannot be found for updating.
     */
    public function createOrUpdateUser(string $userName, array $data, EntityManagerInterface $entityManager): User
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['name' => $userName]);

        if (!$user) {
            $user = new User();
            $user->setName($userName);
        }

        $user->setAgreeToTerms($data['agreeToTerms']);

        foreach ($user->getUserSectors() as $userSector) {
            $entityManager->remove($userSector);
        }
        $entityManager->flush();

        $sectors = $entityManager->getRepository(Sector::class)->findBy(['id' => $data['sectors']]);
        foreach ($sectors as $sector) {
            $userSector = new UserSector();
            $userSector->setUser($user);
            $userSector->setSector($sector);
            $entityManager->persist($userSector);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

}