<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        for($c=1;$c < 5;$c++)
        {
            $cat = new Category();
            $cat->setTitle($faker->realText(20))
                ->setDescription($faker->realText(200))
                ->setPicture('https://picsum.photos/id/' . $faker->numberBetween(1, 1050) . '/1920/1080');
            $manager->persist($cat);

            for($p=1;$p<10;$p++)
            {
                $article = new Article();
                $article->setTitle($faker->realText(20))
                        ->setContent($faker->realText(200))
                        ->setCreatedat(new \DateTime())
                        ->setPublishedat(new \DateTime())
                        ->setCategory($cat)
                        ->setPicture('https://picsum.photos/id/' . $faker->numberBetween(1, 1050) . '/1920/1080');

                $manager->persist($article);
            }
        }
        $manager->flush();

    }
}