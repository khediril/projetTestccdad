<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=1;$i<15;$i++)
        { 
         $product = new Produit();
         $product->setNom("produit".$i);
         $product->setPrix($i*10);
         $product->setQuantite($i);
         $product->setDescription($faker->paragraph(
             3, true));

         $manager->persist($product);
        }

        $manager->flush();
    }
}
