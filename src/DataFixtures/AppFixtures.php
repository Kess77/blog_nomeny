<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Role;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker    = Factory::create('fr_FR');
        $picture   = 'https://randomuser.me/api/portraits/';

        //Gérer les Roles des utilisateurs
        $adminRole = new Role();
        $adminRole ->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Nomeny')
                ->setLastName('rafen')
                ->setEmail('ra_nomeny@yahoo.fr')
                ->setPassword($this->encoder->encodePassword($adminUser,'tiakoianao'))
                ->setAvatar($picture)
                ->addUserRole($adminRole);
        $manager->persist($adminUser);
                



        //gerer les User
        $users = [];
        $genres = ['male','female'];
        for($i=1;$i<=3;$i++){
            $user = new User();
           
            //generer une avatar 
            $genre = $faker->randomElement($genres);

            //API pour les photos (avatar)
            
            $pictureId =   $faker->numberBetween(0, 99);

            //condition ternaire(avatar)
             $picture .= ($genre=='male'?'men/':'women/').$pictureId;
        
        //gerer les mots de passe 
        
            $hash = $this->encoder->encodePassword($user, 'password');
            
            $user   ->setFirstName($faker->firstName($genre))
                    ->setLastName($faker->lastName($genre))
                    ->setEmail($faker->email())
                    ->setPassword($hash)
                    ->setAvatar($picture)
                    ;

            $manager->persist($user); 
            $users[] = $user;    
        }
        

        // gerer les Post 
        for ( $i=0;$i<=20;$i++){

            $post = new Post();
            $article = '<p>' .join('</p><p>',$faker->paragraphs(2)).'</p>';
            $user = $users[mt_rand(0,count($users)-1)];

            $post   ->setTitle($faker->sentence(4))
                    ->setCoverImage($faker->imageUrl(895,470))
                    ->setCreatedAt($faker->dateTime)
                    ->setArticle($article)
                    ->setAuthor($user)
                    ->setIntroduction($faker->sentence(19))
                    ;
            
            // Gérer les images 
            for($j=1;$j<=mt_rand(1,2);$j++){
                $image = new Image();

                $image  ->setUrl($faker->imageUrl(895,470))
                        ->setCaption($faker->sentence(2))
                        ->setPost($post);

                $manager->persist($image);

            }
            
            $manager->persist($post);

        }
        

        
            $manager->flush();
    }
}
