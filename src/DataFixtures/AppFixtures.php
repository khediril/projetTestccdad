<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Faker\Factory;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $c1=new Categorie();
        $c1->setNom("Categorie1");
         $manager->persist($c1);
        for($i=1;$i<6;$i++)
        { 
         $product = new Produit();
         $product->setNom("produit".$i);
         $product->setPrix($i*10);
         $product->setQuantite($i);
         $product->setDescription($faker->paragraph(
             3, true));
         
         $product->setCategorie($c1);
         $manager->persist($product);
        }
        $c2=new Categorie();
        $c2->setNom("Categorie2");
         $manager->persist($c2);
        for($i=6;$i<11;$i++)
        { 
         $product = new Produit();
         $product->setNom("produit".$i);
         $product->setPrix($i*10);
         $product->setQuantite($i);
         $product->setDescription($faker->paragraph(
             3, true));
         
         $product->setCategorie($c2);
         $manager->persist($product);
        }
        $c=new Categorie();
        $c->setNom("Categorie3");
         $manager->persist($c);
        for($i=11;$i<16;$i++)
        { 
         $product = new Produit();
         $product->setNom("produit".$i);
         $product->setPrix($i*10);
         $product->setQuantite($i);
         $product->setDescription($faker->paragraph(
             3, true));
         
         $product->setCategorie($c);
         $manager->persist($product);
        }
   /*     for($i=1;$i<6;$i++)
        { 
         $c = new Categorie();
         $c->setNom("catregorie".$i);
         $manager->persist($c);
        }*/

        $manager->flush();
    }
}
