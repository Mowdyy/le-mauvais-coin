<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\UserRegister;
use App\Factory\AdvertFactory;
use App\Factory\UserFactory;
use App\Factory\QuestionFactory;
use App\Factory\TagFactory;
use App\Factory\UserRegisterFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // private $hasher;

    // public function __construct(UserPasswordHasherInterface $hasher)
    // {
    //     $this->hasher = $hasher;
    // }

    public function load(ObjectManager $manager): void
    {
        // $users = [];

        // $admin = new UserRegister();
        // $admin->setUserName('admin')
        //     ->setPassword($this->hasher->hashPassword($admin, 'password'))
        //     ->setEmail('admin@lemauvaiscoin.fr')
        //     ->setRoles(['ROLE_ADMIN'])
        //     ->setCity('ParisTownCityGang')
        //     ->setPhoneNumber("012131")
        //     ->setZipCode('12131');

        // $users[] = $admin;
        // $manager->persist($admin);


        TagFactory::createMany(40);
        

        //$manager->flush();
    }
}
