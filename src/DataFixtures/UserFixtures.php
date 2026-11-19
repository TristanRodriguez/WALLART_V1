<?php
/**
 * Fixtures User
 * 
 * @author Tristan
 * @version 1.0
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $data = [
            [
                "firstname" => "Admin",
                "lastname" => "Wallart",
                "email" => "admin@wallart.be",
                "roles" => ['ROLE_ADMIN'],
                "password" => 'epfc'
            ],
             [
                "firstname" => "Bernard",
                "lastname" => "Madoff",
                "email" => "berny@madoff.be",
                "roles" => ['ROLE_MEMBER'],
                "password" => 'epfc'
            ],
             [
                "firstname" => "Salvador",
                "lastname" => "Dali",
                "email" => "salvator@dali.be",
                "roles" => ['ROLE_MEMBER', 'ROLE_ARTIST'],
                "password" => 'epfc'
            ],
        ];

        foreach($data as $field) {

            $existingUser = $manager->getRepository(User::class)
                ->findOneBy(['email' => $field['email']]);

            if ($existingUser) {
                continue;
            }

            $user = new User();
            $user->setFirstname($field['firstname']);
            $user->setLastname($field['lastname']);
            $user->setEmail($field['email']);
            $user->setRoles($field['roles']);
            $user->setPassword(password_hash($field['password'], PASSWORD_DEFAULT));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
