<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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

        //gerer les images
        for ($j=0; $j<= mt_rand(1,3);$j++){
            
            $image = new Image();
                $image  ->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence(2))
                        ->setPost($post);
            
            $manager->persist($image);

            }
            $manager->persist($post);
        
        }

        $manager->flush();
    }
}
