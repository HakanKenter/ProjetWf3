<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Annonce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++)
        {
            $user = new User;

            $user->setPrenom($faker->firstName())
                 ->setNom($faker->lastname)
                 ->setPseudo($faker->userName)
                 ->setVille($faker->city)
                 ->setCivilite($faker->title)
                 ->setAdresse($faker->address)
                 ->setPassword($faker->password)
                 ->setBirth($faker->dateTime())
                 ->setEmail($faker->email)
                 ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                //  ->setTelephone($faker->imageUrl())
                 ->setImage($faker->imageUrl());

                 
            $manager->persist($user);

            for($j = 1; $j <= mt_rand(6, 10); $j++)
            {
                $annonce = new Annonce;

                $annonce->setTitle($faker->sentence())
                        ->setPrix(mt_rand(1,500))
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setUser($user);
                
                $manager->persist($annonce);
            }
        }

        $manager->flush();
    }
}
