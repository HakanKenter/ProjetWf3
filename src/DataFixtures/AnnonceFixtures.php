<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Annonce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $faker = \Faker\Factory::create('fr_FR');

        // for($i = 0; $i)

        for($i = 1; $i <= 10; $i++)
        {
            $article = new Annonce;

            $article->setTitle('Titre de l\'annonce')
                    ->setPrix('10')
                    ->setImage('https://picsum.photos/250')
                    ->setCreatedAt( new \DateTime() );
            
            $manager->persist($article);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
