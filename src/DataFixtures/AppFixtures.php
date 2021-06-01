<?php

namespace App\DataFixtures;

//use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use App\Entity\Income;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();

        for ($i=0; $i < 2 ; $i++) {
            $income = new Income();
            $income
                ->setTitle($faker->word)
                ->setAmount(mt_rand(1600, 1900));

            $manager->persist($income);
        }


        $manager->flush();
    }
}
