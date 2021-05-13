<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Merchandise extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 15; $i++) {
            $product = new \App\Entity\Merchandise();
            $product->setLabel($faker->name);
            $product->setUrl($faker->imageUrl());
            $product->setPrice($faker->randomFloat(2, 1, 70));
            $product->setInStock($faker->numberBetween(0, 30));
            $product->setType("poster");
            $manager->persist($product);

            $manager->flush();
        }
    }
}
