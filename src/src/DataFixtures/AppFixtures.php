<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Factory\AdvertFactory;
use App\Factory\UserFactory;
use App\Factory\QuestionFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
require_once 'vendor/autoload.php';

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        TagFactory::createMany(40);
        AdvertFactory::createMany(10, function(){
            return [ 'tags' => [TagFactory::random()]];
        });
        Questionfactory::createMany(1,function(){
            return ['advert'=> AdvertFactory::first()];
        });
        
    }
}
