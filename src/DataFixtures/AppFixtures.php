<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker    = Factory::create('fr_FR');
        

        // gerer les Post 
        for ( $i=0;$i<=20;$i++){

            $post = new Post();
            $article = '<p>' .join('</p><p>',$faker->paragraphs(5)).'</p>';

            $post   ->setTitle($faker->sentence(4))
                    ->setCoverImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTime)
                    ->setArticle($article)
                    ->setIntroduction($faker->paragraph(2));
                  
            
            $manager->persist($post);
        
        }

        $manager->flush();
    }
}
