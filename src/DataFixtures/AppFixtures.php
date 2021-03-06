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
        
        // Un nouvel auteur
        $user = new User();
        $user->setPseudo($faker->userName())
            ->setEmail($faker->email())
            ->setPassword($faker->password())
            ->setfirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setValid(true)
            ->setRoles(['ROLE_AUTHOR'])
            ->setCreatedat(new \DateTime());
        $manager->persist($user);
        
        
        for($c=1;$c < 5;$c++)
        {
            $cat = new Category();
            $cat->setTitle($faker->realText(20))
                ->setDescription($faker->realText(200))
                ->setValid(true)
                ->setPicture('https://picsum.photos/id/' . $faker->numberBetween(1, 1050) . '/1920/1080');
            $manager->persist($cat);

            for($p=1;$p<10;$p++)
            {
                $article = new Article();
                $article->setTitle($faker->realText(20))
                        ->setContent($faker->realText(600))
                        ->setCreatedat(new \DateTime())
                        ->setPublishedat(new \DateTime())
                        ->addCategory($cat)
                        ->setValid(true)
                        ->setUser($user)
                        ->setPermalink($faker->slug())
                        ->setPicture('https://picsum.photos/id/' . $faker->numberBetween(1, 1050) . '/1920/1080');

                $manager->persist($article);
               
                for($x=1;$x<10;$x++)
                {
                    $comment = new Comment();
                    $comment->setPseudo($faker->userName())
                    ->setEmail($faker->email())
                    ->setContent($faker->realText(600))
                    ->setCreatedat(new \DateTime())
                    ->setValid(true)
                    ->setArticle($article);
                    
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();

    }
}